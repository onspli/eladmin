<?php
namespace Onspli\Eladmin\Modules\Eloquent;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin\Modules\Crud as CrudModule;

/**
* Crud module for Eloquent model.
*/
trait Crud {

use CrudModule\Crud;

/**
* Primary column name.
*/
public function elaPrimary() : string {
  return $this->getKeyName();
}

protected function elaWrite(array $row, $id = null) : void {
  if ($id === null)
    $entry= new static();
  else
    $entry = $this->find($id);

  if (!$entry)
    throw new Exception\BadRequestException( __('Entry not found!') );

  $tableColumns = $this->tableColumns();
  $columns = $this->elaColumns();

  foreach ($tableColumns as $column) {
    if (!isset($row[$column]) || !isset($columns->{$column}) || $columns->{$column}->disabled)
      continue;
    $entry->{$column} = $row[$column];
  }

  $entry->save();
}

protected function elaRead($id) : array {
  if ($id === null)
    return $this->toArray();

  $row = $this->find($id)->toArray();
  return $row;
}

/**
* Hard delete entry.
*/
protected function elaDelete($id) : void {
  $row = $this->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  if ($this->elaUsesSoftDeletes())
    $row->forceDelete();
  else
    $row->delete();
}

protected function elaQuery(CrudModule\Query $query, &$totalResults) : array {
  $q = $this;

  if ($query->trash){
    $q = $q->onlyTrashed();
  }

  if ($query->sortBy)
    $q = $q->orderBy($query->sortBy, $query->direction);
  $totalResults = $q->count();
  $rows = $q->get()->toArray();
  return $rows;
}

public function elaUsesSoftDeletes() : bool {
  return method_exists($this, 'trashed');
}

/**
* Soft delete entry
*/
protected function elaSoftDelete($id) : void {
  $row = $this->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  if (!$this->elaUsesSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  else
    $row->delete();
}

/**
* Restore entry
*/
protected function elaRestore($id) : void {
  $row = $this->withTrashed()->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  if (!$this->elaUsesSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  $row->restore();
}

/**
* Check if table for the model exists in the database;
*/
protected function tableExists() : bool {
  return $this->getConnection()->getSchemaBuilder()->hasTable($this->getTable());
}

/**
* Get an array of table columns.
*/
private function tableColumns() : array {
  return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
}

/**
* Default columns setting.
*/
private function elaColumnsDef(){
  $columns = new CrudModule\Chainset\Columns;
  $tableColumns = $this->tableColumns();
  // add all columns from the table
  foreach ($tableColumns as $column)
    $columns->$column;
  // disable editing for primary key
  $columns->{$this->elaPrimary()}->disabled();
  // hide and disable deleted_at column
  if ($this->elaUsesSoftDeletes())
    $columns->{$this->getDeletedAtColumn()}->hidden();

  if (in_array(static::CREATED_AT, $tableColumns))
    $columns->{static::CREATED_AT}->disabled();
  if (in_array(static::UPDATED_AT, $tableColumns))
    $columns->{static::UPDATED_AT}->disabled();

  return $columns;
}


public function elaGetActionInstance(){
  $elaid = $this->elaId(true);
  if($elaid === null || in_array($this->eladmin->actionkey(), ['read', 'create', 'update', 'delete', 'softdelete', 'restore', 'putform', 'postform']))
    return $this;

  $entry = static::find($elaid);
  if(!$entry)
    throw new Exception\BadRequestException( __('Entry not found!') );
  $entry->elaInit($this->eladmin, $this->elakey);
  return $entry;
}

}
