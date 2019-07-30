<?php
namespace Onspli\Eladmin\Module\Eloquent;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;


trait Crud
{
  use Eladmin\Module\Module {
    Eladmin\Module\Module::elaInit as elaInitParent;
  }

  protected function elaViewsDef(): array{
    return [
      'render'=>'modules.eloquent.render',
      'putForm'=>'modules.eloquent.putForm',
      'postForm'=>'modules.eloquent.postForm',
      'row'=>'modules.eloquent.row'
    ];
  }



  public function __toString(){
    $elakey = $this->elakey();
    if($elakey) return $elakey;
    return parent::__toString();
  }

  public function elaInit($eladmin, $elakey){
    $this->elaInitParent($eladmin, $elakey);
    if(!$this->tableExists()) $this->createTable();
  }

  protected function createTable(){

  }

  /**
  * Check if table for the model exists in the database;
  * @return bool
  */
  public function tableExists(){
    return $this->getSchema()->hasTable($this->getTable());
  }

  /**
  * Get an array of table columns.
  * @return array
  */
  public function getTableColumns() {
    return $this->getSchema()->getColumnListing($this->getTable());
  }

  /**
  * Get schema manager.
  */
  public function getSchema(){
    return $this->getConnection()->getSchemaBuilder();
  }


  public function elaColumnsDef(){
    $visibleColumns = $this->elaVisibleColumns();
    $disabledColumns = $this->elaDisabledColumns();
    $realColumns = $this->getTableColumns();
    $columns = new Chainset\Column(true);
    foreach($visibleColumns as $column){
      $columns->$column;
      if(in_array($column, $disabledColumns))
        $columns->$column->disabled();
      if(in_array($column, $realColumns))
        $columns->$column->realcolumn = true;
    }
    if($this->elaUsesSoftDeletes())
      unset($columns->deleted_at);
    return $columns;
  }

  public function elaActionsDef(){
    return new Chainset\Action(true);
  }

  public function elaFiltersDef(){
    return new Chainset\Filter(true);
  }

  public function elaColumns(){
    return $this->elaColumnsDef();
  }

  public function elaActions(){
    return $this->elaActionsDef();
  }

  public function elaFilters(){
    return $this->elaFiltersDef();
  }

  public function elaActionPostForm(){
    echo $this->eladmin->view($this->elaGetView('postForm'), ['module'=>$this]);
  }

  public function elaActionPutForm(){
    $id = $_POST[$this->primaryKey]??null;
    $row = static::find($id);
    if(!$row)
      throw new Exception\BadRequestException(__('Entry not found!'));

    echo $this->eladmin->view($this->elaGetView('putForm'), ['row'=>$row,'module'=>$this]);
  }

  public function elaUsesSoftDeletes(){
    return in_array('deleted_at', $this->getTableColumns());
  }


  /**
  * Returns an array of columns that cannot be edited from crud. (i.e. primary key, automanaged timestamps)
  */
  public function elaDisabledColumns(){
    $columns = [$this->getKeyName()];
    if($this->elaUsesSoftDeletes())
      $columns[] = 'deleted_at';
    if($this->timestamps){
      $columns[] = static::CREATED_AT;
      $columns[] = static::UPDATED_AT;
    }
    $columns = array_merge($columns, $this->appends);
    return $columns;
  }

  public function elaVisibleColumns(){

    $columns = $this->getTableColumns();
    $columns = array_merge($columns, $this->appends);
    if($this->visible) $visibleColumns = $this->visible;
    else $visibleColumns = array_diff($columns, $this->hidden??[]);
    return $visibleColumns;
  }

  /**
  * List database entries.
  */
  public function elaActionGetRows(){
    $sort = $_POST['sort']??$this->primaryKey;
    $direction = $_POST['direction']??'desc';
    $page = $_POST['page']??1;
    $resultsperpage = $_POST['resultsperpage']??10;
    $search = $_POST['search']??'';
    $columns = $_POST['columns']??[];
    $trash = $_POST['trash']??0;

    $realColumns = $this->getTableColumns();


    $q = $this;

    if($trash){
      $q = $this->onlyTrashed();
    }

    if($search){
      $q = $q->where(function($q) use($realColumns, $search){
        foreach($realColumns as $key=>$col){
          if($key==0) $q=$q->where($col, 'LIKE', '%'.$search.'%');
          else $q=$q->orWhere($col, 'LIKE', '%'.$search.'%');
        }
      });
    }

    foreach($columns as $col=>$data){
      $q = $q->where($col,$data['op'],$data['val']);
    }

    $total = $q->count();
    $rows = $q->orderBy($sort, $direction)->offset(($page-1)*$resultsperpage)->limit($resultsperpage)->get();

    $result['totalresults'] = $total;
    $result['html'] = '';
    foreach($rows as $row)
      $result['html'] .= $this->eladmin->view($this->elaGetView('row'), ['row'=>$row,'module'=>$this, 'trash'=>$trash]);
    Header('Content-type:application/json');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }

  /**
  * Edit database entry.
  */
  public function elaActionPutRow(){

    $id = $_POST[$this->primaryKey]??null;
    $row = static::find($id);
    if(!$row) throw new Exception\BadRequestException( __('Entry not found!') );

    $this->elaModifyPost();
    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());

    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }

    $row->save();
    Header('Content-type: text/plain');
    echo __('Entry modified.');
  }

  /**
  * Create database entry.
  */
  public function elaActionPostRow(){
    $row = new static();
    $this->elaModifyPost();

    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());
    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }
    $row->save();
    Header('Content-type: text/plain');
    echo __('Entry added.');
  }

  /**
  * Delete database entry.
  */
  public function elaActionDelRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::find($id);
    $row->delete();
    Header('Content-type: text/plain');
    if($this->elaUsesSoftDeletes())
      echo __('Entry deleted. It can be restored from Trash later.');
    else
      echo __('Entry deleted.');
  }

  public function elaActionForceDelRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::withTrashed()->find($id);
    $row->forceDelete();
    Header('Content-type: text/plain');
    echo __('Deleted forever!');
  }

  public function elaActionRestoreRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::withTrashed()->find($id);
    $row->restore();
    Header('Content-type: text/plain');
    echo __('Entry restored.');
  }

  /**
  * Here you can modify or validate $_POST variable before the data is stored to the database.
  */
  protected function elaModifyPost():void {

  }

}
