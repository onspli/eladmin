<?php
namespace Onspli\Eladmin\Eloquent;

class Model extends \Illuminate\Database\Eloquent\Model
{

  protected $elaTitle = null;
  protected $elaFasIcon = 'fas fa-puzzle-piece';
  protected $elaJs = __DIR__.'/../../js/eloquent.js';
  protected $elaAuthorizedGroups = [];


  /**
  * Check if table for the model exists in the database;
  * @return bool
  */
  protected function tableExists(){
    return $this->getSchema()->hasTable($this->getTable());
  }

  public function elaGetAuthorizedGroups(){
    return $this->elaAuthorizedGroups;
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
  protected function getSchema(){
    return $this->getConnection()->getSchemaBuilder();
  }

  public function elaGetTitle(){
    if($this->elaTitle) return $this->elaTitle;
    else return $this->getTable();
  }

  public function elaGetFasIcon(){
    return $this->elaFasIcon;
  }

  public function elaGetJs(){
    return $this->elaJs;
  }



  public function elaActionGetRows(){
    $rows = static::all();

    Header('Content-type: application/json');
    echo $rows->toJson();
  }

  public function elaActionGetRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::find($id);

    Header('Content-type: application/json');
    echo $row->toJson();
  }

  public function elaActionPutRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::find($id);

    /**
    * TODO: some protection?
    */
    $columns = $this->getTableColumns();
    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }
    $row->save();
    $this->elaActionGetRow();
  }

  public function elaActionDelRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::find($id);
    $row->delete();
  }

  public function elaActionPostRow(){
    $row = new static;
    /**
    * TODO: some protection?
    */
    $columns = $this->getTableColumns();
    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }
    $row->save();

    $_POST[$this->primaryKey] = $row->{$this->primaryKey};
    $this->elaActionGetRow();
  }

  public function elaActionGetConfig(){
    $columns = $this->getTableColumns();
    $schema = [];
    foreach($columns as $column)
      $schema[$column] = $this->getColumnType($column);

    Header('Content-type: application/json');
    echo json_encode([
      'schema'=>$schema,
      'columns'=>$columns,
      'primaryKey'=>$this->primaryKey
    ], JSON_UNESCAPED_UNICODE);
  }

}
