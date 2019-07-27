<?php
namespace Onspli\Eladmin\Eloquent;
use \Onspli\Eladmin\Exception;


class Model extends \Illuminate\Database\Eloquent\Model implements \Onspli\Eladmin\Iface\Module
{

  protected $elaTitle = null;
  protected $elaIcon = '<i class="fas fa-puzzle-piece"></i>';

  public $bladeViewRender = 'modules.model.render';
  public $bladeViewPutForm = 'modules.model.putForm';
  public $bladeViewPostForm = 'modules.model.postForm';
  public $bladeViewRow = 'modules.model.row';
  protected $blade = null;

  public $eladmin = null;

  protected $elaAuthorizedRoles = [];
  protected $elaAuthorizedRolesForLowercaseActions = [
    'postrow' => [],
    'putrow' => [],
    'delrow' => []
  ];

  protected function defaultProperties(){
  }

  public function __construct(){
    $this->defaultProperties();
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
    $columns = new \Onspli\Eladmin\Eloquent\Column\Column(true);
    foreach($visibleColumns as $column){
      $columns->$column;
      if(in_array($column, $disabledColumns))
        $columns->$column->disabled();
    }
    return $columns;
  }

  public function elaActions(){
    return new \Onspli\Eladmin\Chainset\Chainset();
  }

  public function elaActionPostForm(){
    echo $this->eladmin->view($this->bladeViewPostForm);
  }

  public function elaActionPutForm(){
    $id = $_POST[$this->primaryKey]??null;
    $row = static::find($id);
    if(!$row)
      throw new Exception\BadRequestException(__('Entry not found!'));

    echo $this->eladmin->view($this->bladeViewPutForm, ['row'=>$row]);
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
    $direction = $_POST['direction']??'asc';

    $rows = static::orderBy($sort, $direction)->get();
    foreach($rows as $row)
      echo $this->eladmin->view($this->bladeViewRow, ['row'=>$row]);
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
