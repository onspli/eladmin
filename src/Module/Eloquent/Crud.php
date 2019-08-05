<?php
namespace Onspli\Eladmin\Module\Eloquent;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;


trait Crud
{
  use Eladmin\Module\Module {
    Eladmin\Module\Module::elaInit as elaInit_Parent_Module;
  }

  protected function elaViewsDef(): array{
    return [
      'render'=>'modules.eloquent.render',
      'putForm'=>'modules.eloquent.putForm',
      'postForm'=>'modules.eloquent.postForm',
      'row'=>'modules.eloquent.row'
    ];
  }

  public function elaInit($eladmin, $elakey){
    $this->elaInit_Parent_Module($eladmin, $elakey);
    $this->elaActions(); // set authorized roles
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
    $columns = new Chainset\Column($this, true);
    foreach($visibleColumns as $column){
      $columns->$column;
      if(in_array($column, $disabledColumns))
        $columns->$column->disabled();
      if(in_array($column, $realColumns))
        $columns->$column->realcolumn = true;
      if(!$this->elaAuth('update'))
        $columns->$column->disabled();
    }
    if($this->elaUsesSoftDeletes())
      unset($columns->deleted_at);
    return $columns;
  }

  public function elaActionsDef(){
    return new Chainset\Action($this, true);
  }

  public function elaFiltersDef(){
    return new Chainset\Filter($this, true);
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
    if(!$this->elaAuth('create'))
      throw new Exception\UnauthorizedException();
    echo $this->eladmin->view($this->elaGetView('postForm'), ['module'=>$this]);
  }

  public function elaActionPutForm(){
    if(!$this->elaAuth('read'))
      throw new Exception\UnauthorizedException();
    echo $this->eladmin->view($this->elaGetView('putForm'), ['row'=>$this,'module'=>$this]);
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
  public function elaActionRead(){
    $t0 = microtime(true);
    $sort = $_POST['sort']??$this->getKeyName();
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
    $t1 = microtime(true);

    $result['totalresults'] = $total;
    $result['html'] = '';
    $elaColumns = $this->elaColumns();
    $elaActions = $this->elaActions();
    foreach($rows as $row){
      $row->elaInit($this->eladmin, $this->elakey);
      $result['html'] .= $this->eladmin->view($this->elaGetView('row'), ['row'=>$row,'module'=>$this, 'trash'=>$trash, 'columns'=>$elaColumns, 'actions'=>$elaActions]);
    }

    $t2 = microtime(true);

    //$result['html'] = $this->eladmin->view($this->elaGetView('rows'), ['rows'=>$rows,'module'=>$this, 'trash'=>$trash, 'columns'=>$this->elaColumns(), 'actions'=>$this->elaActions()]);
    $t3 = microtime(true);
    $result['time0'] = $t0-$this->eladmin->microtime0;
    $result['time1'] = $t1-$this->eladmin->microtime0;
    $result['time2'] = $t2-$this->eladmin->microtime0;
    $result['time3'] = $t3-$this->eladmin->microtime0;
    $this->elaOutJson($result);
  }

  /**
  * Edit database entry.
  */
  public function elaActionUpdate(){
    $this->elaUpdate();
    $this->elaOutText(__('Entry modified.'));
  }

  protected function elaUpdate(){
    $columns = $this->elaColumns();
    foreach ($columns as $column => $config) {
      if($config->validate){
        ($config->validate)($_POST[$column]??null, $this);
      }
      if($config->setformat && isset($_POST[$column])){
        $_POST[$column] = ($config->setformat)($_POST[$column], $this);
      }
    }

    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());

    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->getKeyName()) continue;
      $this->{$column} = $value;
    }

    $this->save();
    $this->refresh();
  }

  /**
  * Create database entry.
  */
  public function elaActionCreate(){
    $columns = $this->elaColumns();
    foreach ($columns as $column => $config) {
      if($config->validate){
        ($config->validate)($_POST[$column]??null, $this);
      }
      if($config->setformat && isset($_POST[$column])){
        $_POST[$column] = ($config->setformat)($_POST[$column], $this);
      }
    }
    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());
    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->getKeyName()) continue;
      $this->{$column} = $value;
    }
    $this->save();
    $this->elaOutText(__('Entry added.'));
  }

  /**
  * Delete database entry.
  */
  public function elaActionDelete(){
    $this->delete();
    Header('Content-type: text/plain');
    if($this->elaUsesSoftDeletes())
      $this->elaOutText(__('Entry deleted. It can be restored from Trash later.'));
    else
      $this->elaOutText(__('Entry deleted.'));
  }

  public function elaActionForceDelete(){
    if(!$this->elaAuth('delete'))
      throw new Exception\UnauthorizedException();
    $this->forceDelete();
    $this->elaOutText(__('Deleted forever!'));
  }

  public function elaActionRestore(){
    if(!$this->elaAuth('delete'))
      throw new Exception\UnauthorizedException();
    $this->restore();
    $this->elaOutText(__('Entry restored.'));
  }

  public function elaGetActionInstance(){
    if(!isset($_POST[$this->getKeyName()])) return $this;
    $entry = new static();
    $action = $this->eladmin->action();
    if(in_array($action, ['forcedelete', 'restore']))
      $entry = $entry->withTrashed();
    $entry = $entry->find($_POST[$this->getKeyName()]);
    if(!$entry) throw new Exception\BadRequestException( __('Entry not found!') );
    $entry->elaInit($this->eladmin, $this->elakey);
    if(!in_array($action, ['update']) && $this->elaAuth('update') && ($_GET['elaupdate']??false)){
      $entry->elaUpdate();
    }
    return $entry;
  }

}
