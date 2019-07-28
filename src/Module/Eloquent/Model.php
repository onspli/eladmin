<?php
namespace Onspli\Eladmin\Module\Eloquent;
use \Onspli\Eladmin\Exception;


class Model extends \Illuminate\Database\Eloquent\Model implements \Onspli\Eladmin\Iface\Module
{

  protected $elaTitle = null;
  protected $elaIcon = '<i class="fas fa-puzzle-piece"></i>';
  public $elaRepresentativeColumn = null;

  public $bladeViewRender = 'modules.model.render';
  public $bladeViewPutForm = 'modules.model.putForm';
  public $bladeViewPostForm = 'modules.model.postForm';
  public $bladeViewRow = 'modules.model.row';
  protected $blade = null;

  public $eladmin = null;
  public $elakey = null;

  protected $elaAuthorizedRoles = [];
  protected $elaAuthorizedRolesForLowercaseActions = [
    'postrow' => [],
    'putrow' => [],
    'delrow' => []
  ];

  public function elakey(){
    return (string)$this->elakey;
  }

  public function __toString(){
    $elakey = $this->elakey();
    if($elakey) return $elakey;
    return parent::__toString();
  }

  public function elaRequest($action, $args=[]){
    return $this->eladmin->request($action, $this, $args);
  }

  public function elaAuth($action): bool{
    return $this->eladmin->auth($action, $this);
  }

  protected function defaultProperties(){
  }

  public function __construct(){
    $this->defaultProperties();
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

  /**
  * Getters
  */
  public function elaGetTitle(): string {
    if($this->elaTitle) return $this->elaTitle;
    else return $this->getTable();
  }

  public function elaGetIcon(): string {
    return $this->elaIcon;
  }

  public function elaGetAuthorizedRoles(): array{
    return $this->elaAuthorizedRoles;
  }

  public function elaGetAuthorizedRolesActions(): array{
    return $this->elaAuthorizedRolesForLowercaseActions;
  }

  public function elaColumns(){
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
    return $columns;
  }

  public function elaActions(){
    return new Chainset\Action(true);
  }

  public function elaFilters(){
    return new Chainset\Filter(true);
  }

  public function elaActionPostForm(){
    echo $this->eladmin->view($this->bladeViewPostForm, ['module'=>$this]);
  }

  public function elaActionPutForm(){
    $id = $_POST[$this->primaryKey]??null;
    $row = static::find($id);
    if(!$row)
      throw new Exception\BadRequestException(__('Entry not found!'));

    echo $this->eladmin->view($this->bladeViewPutForm, ['row'=>$row,'module'=>$this]);
  }


  /**
  * Returns an array of columns that cannot be edited from crud. (i.e. primary key, automanaged timestamps)
  */
  public function elaDisabledColumns(){
    $columns = [$this->getKeyName()];
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

    $realColumns = $this->getTableColumns();

    $q = $this;
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
      $result['html'] .= $this->eladmin->view($this->bladeViewRow, ['row'=>$row,'module'=>$this]);
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
    echo __('Entry deleted.');
  }

  /**
  * Here you can modify or validate $_POST variable before the data is stored to the database.
  */
  protected function elaModifyPost():void {

  }

}
