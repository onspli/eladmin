<?php
namespace Onspli\Eladmin\Modules\Eloquent;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin\Modules\Crud as CrudModule;

/**
* Crud module for Eloquent model.
*/
trait Crud {

use CrudModule\Crud {
  CrudModule\Crud::elaInstanceForAction as elaInstanceForAction_CrudModule_Crud;
}

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
    if (!isset($row[$column]) || !isset($columns->{$column}))
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
  if ($this->elaImplementsSoftDeletes()) {
    $row = $this->withTrashed()->find($id);
    if (!$row)
      throw new Exception\BadRequestException( __('Entry not found!') );

    $row->forceDelete();
  } else {
    $row = $this->find($id);
    if (!$row)
      throw new Exception\BadRequestException( __('Entry not found!') );
    $row->delete();
  }
}

protected function elaRequest(array $request, &$totalResults) : array {
  $q = $this;

  if ($request['trash']){
    $q = $q->onlyTrashed();
  }

  $search = $request['search'];
  if ($search && $this->elaImplementsSearch()) {
    foreach ($this->elaColumnsGet() as $column) {
      if ($column->nonsearchable)
        continue;
      $q = $q->orWhere($column->getName(), 'LIKE', '%' . $search . '%');
    }
  }

  if ($this->elaImplementsFilters()) {
    foreach ($this->elaFiltersGet() as $filterName => $filter) {
      $filterPost = $_POST['filters'][$filterName] ?? null;
      if (!$filterPost)
        continue;
      $q = $q->where($filterName, '=', $filterPost['val']);
    }
  }

  if ($this->elaImplementsSorting()) {
    $q = $q->orderBy($request['sortBy'], $request['direction']);
  }

  $totalResults = $q->count();

  if ($request['resultsPerPage'] != $this->INFINITY) {
    $resultsPerPage = $request['resultsPerPage'];
    $page = $request['page'];
    $q = $q->offset(($page - 1) * $resultsPerPage)->limit($resultsPerPage);
  }

  $rows = $q->get()->toArray();
  return $rows;
}

public function elaImplementsSoftDeletes() : bool {
  return method_exists($this, 'trashed');
}

public function elaImplementsSorting() : bool {
  return true;
}

public function elaImplementsPaging() : bool {
  return true;
}

public function elaImplementsSearch() : bool {
  return true;
}

public function elaImplementsFilters() : bool {
  return true;
}

/**
* Soft delete entry
*/
protected function elaSoftDelete($id) : void {
  $row = $this->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  if (!$this->elaImplementsSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  else
    $row->delete();
}

/**
* Restore entry
*/
protected function elaRestore($id) : void {
  if (!$this->elaImplementsSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  $row = $this->withTrashed()->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
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
  if ($this->elaImplementsSoftDeletes())
    $columns->{$this->getDeletedAtColumn()}->hidden();

  if (in_array(static::CREATED_AT, $tableColumns))
    $columns->{static::CREATED_AT}->disabled()->nonsearchable();
  if (in_array(static::UPDATED_AT, $tableColumns))
    $columns->{static::UPDATED_AT}->disabled()->nonsearchable();

  return $columns;
}


public function elaInstanceForAction() {
  $this->elaInstanceForAction_CrudModule_Crud();
  $elaid = $this->elaId(false /* $throwIfNull */);
  if($elaid === null || in_array($this->eladmin->actionkey(), ['read', 'create', 'update', 'delete', 'softdelete', 'restore', 'putform', 'postform']))
    return $this;

  $entry = static::find($elaid);
  if(!$entry)
    throw new Exception\BadRequestException( __('Entry not found!') );
  $entry->elaInit($this->eladmin, $this->elakey);
  return $entry;
}

}
