<?php
namespace Onspli\Eladmin\Eloquent;

class Model extends \Illuminate\Database\Eloquent\Model implements \Onspli\Eladmin\Iface\Module
{

  protected $elaTitle = null;
  protected $elaFasIcon = 'fas fa-puzzle-piece';
  protected $elaJs = __DIR__.'/../../js/eloquent.js';
  protected $elaAuthorizedRoles = [];


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
  * Get type of a column.
  * @return string
  */
  public function getColumnType($column) {
    return $this->getSchema()->getColumnType($this->getTable(), $column);
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

  public function elaGetFasIcon(): string {
    return $this->elaFasIcon;
  }

  public function elaGetJs(): string{
    return $this->elaJs;
  }

  public function elaGetAuthorizedRoles(): array{
    return $this->elaAuthorizedRoles;
  }


  /**
  * Returns an array of columns that cannot be edited from crud. (i.e. automanaged timestamps)
  */
  public function elaDisabledColumns(){
    $columns = [];
    if($this->timestamps){
      $columns[] = static::CREATED_AT;
      $columns[] = static::UPDATED_AT;
    }
    return $columns;
  }

  public function elaExtraInputs(): array{
    return [];
  }

  public function elaExtraActions(): array{
    return [];
  }

  /**
  * List database entries.
  */
  public function elaActionGetRows(){
    $sort = $_POST['sort']??$this->primaryKey;
    $direction = $_POST['direction']??'asc';

    $rows = static::orderBy($sort, $direction)->get();

    Header('Content-type: application/json');
    echo $rows->toJson();
  }

  /**
  * Get database entry.
  */
  public function elaActionGetRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::find($id);

    if(!$row)
      throw new \Exception('Entry not found!');

    Header('Content-type: application/json');
    echo $row->toJson();
  }

  /**
  * Edit database entry.
  */
  public function elaActionPutRow(){

    $id = $_POST[$this->primaryKey];
    $row = static::find($id);

    if(!$row)
      throw new \Exception('Entry not found!');

    $this->elaModifyPost();

    /**
    * TODO: some protection?
    */
    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());

    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }
    $row->save();
    $this->elaActionGetRow();
  }

  /**
  * Create database entry.
  */
  public function elaActionPostRow(){
    $row = new static();
    $this->elaModifyPost();
    /**
    * TODO: some protection?
    */
    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());
    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }
    $row->save();

    $_POST[$this->primaryKey] = $row->{$this->primaryKey};
    $this->elaActionGetRow();
  }

  /**
  * Delete database entry.
  */
  public function elaActionDelRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::find($id);
    $row->delete();
  }


  /**
  * Here you can modify $_POST variable before the data is stored to the database.
  */
  protected function elaModifyPost():void {

  }

  /**
  * Transfer configuration to client-side.
  */
  public function elaActionGetConfig(){
    $columns = $this->getTableColumns();
    $schema = [];
    foreach($columns as $column)
      $schema[$column] = $this->getColumnType($column);

    $visibleColumns = array_diff($columns, $this->hidden??[]);

    Header('Content-type: application/json');
    echo json_encode([
      'schema'=>$schema,
      'columns'=>$columns,
      'primaryKey'=>$this->primaryKey,
      'disabledColumns'=>$this->elaDisabledColumns(),
      'visibleColumns'=>$visibleColumns,
      'extraInputs'=>$this->elaExtraInputs(),
      'extraActions'=>$this->elaExtraActions()
    ], JSON_UNESCAPED_UNICODE);
  }

}
