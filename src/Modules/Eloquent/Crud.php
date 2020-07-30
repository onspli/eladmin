<?php
namespace Onspli\Eladmin\Modules\Eloquent;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;
use Illuminate\Database;

/**
* Crud module for Eloquent model.
*/
class Crud extends Eladmin\Modules\Crud\Crud {

/**
* Model class name
*/
protected $model = Database\Eloquent\Model::class;
private $imodel = null;

public function model() {
  if ($this->imodel === null) {
    try {
      $this->imodel = new $this->model;
    } catch(\Throwable $e) {
      throw new Exception\BadRequestException( __('You have to set $model property to %s module!', static::class) );
    } catch(\Exception $e) {
      throw new Exception\BadRequestException( __('You have to set $model property to %s module!', static::class) );
    }
  }
  return $this->imodel;
}

/**
* Primary column name.
*/
public function primary() : string {
  return $this->model()->getKeyName();
}

private function updateOrCreate($entry, $row) : void {
  $tableColumns = $this->tableColumns();
  $columns = $this->getCrudColumns();

  foreach ($tableColumns as $column) {
    if (!isset($row[$column]) || !isset($columns->{$column}))
      continue;
    $entry->{$column} = $row[$column];
  }

  $entry->save();
}

public function prepare() : void {
  parent::prepare();
  if (in_array($this->core()->actionkey(), parent::actions()))
    return;
  $id = $this->id(false /* $throwIfNull */);
  if ($id !== null) {
    $entry = $this->model()->find($id);
    if (!$entry)
      throw new Exception\BadRequestException( __('Entry not found!') );
    $this->imodel = $entry;
  }
}

protected function create(array $row) : void {
  $entry = new $this->model;
  $this->updateOrCreate($entry, $row);
}

protected function update(array $row, $id) : void {
  $entry = $this->model()->find($id);
  if (!$entry)
    throw new Exception\BadRequestException( __('Entry not found!') );
  $this->updateOrCreate($entry, $row);
}

protected function get($id) : array {
  if ($id === null)
    return $this->model()->toArray();

  $row = $this->model()->find($id)->toArray();
  return $row;
}

/**
* Hard delete entry.
*/
protected function delete($id) : void {
  if ($this->implementsSoftDeletes()) {
    $row = $this->model()->withTrashed()->find($id);
    if (!$row)
      throw new Exception\BadRequestException( __('Entry not found!') );

    $row->forceDelete();
  } else {
    $row = $this->model()->find($id);
    if (!$row)
      throw new Exception\BadRequestException( __('Entry not found!') );
    $row->delete();
  }
}

protected function read(array $request, &$totalResults) : array {
  $q = $this->model();

  if ($request['trash']){
    $q = $q->onlyTrashed();
  }

  $search = $request['search'];
  if ($search && $this->implementsSearch()) {
    foreach ($this->getCrudColumns() as $column) {
      if ($column->nonsearchable)
        continue;
      $q = $q->orWhere($column->getName(), 'LIKE', '%' . $search . '%');
    }
  }

  if ($this->implementsFilters()) {
    foreach ($this->getCrudFilters() as $filterName => $filter) {
      $filterPost = $_POST['filters'][$filterName] ?? null;
      if (!$filterPost)
        continue;
      $q = $q->where($filterName, '=', $filterPost['val']);
    }
  }

  if ($this->implementsSorting()) {
    $q = $q->orderBy($request['sortBy'], $request['direction']);
  }

  $totalResults = $q->count();

  if ($request['resultsPerPage'] != self::INFINITY) {
    $resultsPerPage = $request['resultsPerPage'];
    $page = $request['page'];
    $q = $q->offset(($page - 1) * $resultsPerPage)->limit($resultsPerPage);
  }

  $rows = $q->get()->toArray();
  return $rows;
}

public function implementsSoftDeletes() : bool {
  return method_exists($this->model, 'trashed');
}

public function implementsSorting() : bool {
  return true;
}

public function implementsPaging() : bool {
  return true;
}

public function implementsSearch() : bool {
  return true;
}

public function implementsFilters() : bool {
  return true;
}

/**
* Soft delete entry
*/
protected function softDelete($id) : void {
  $row = $this->model()->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  if (!$this->implementsSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  else
    $row->delete();
}

/**
* Restore entry
*/
protected function restore($id) : void {
  if (!$this->implementsSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  $row = $this->model()->withTrashed()->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  $row->restore();
}

/**
* Check if table for the model exists in the database;
*/
protected function tableExists() : bool {
  return $this->model()->getConnection()->getSchemaBuilder()->hasTable($this->model()->getTable());
}

/**
* Get an array of table columns.
*/
private function tableColumns() : array {
  return $this->model()->getConnection()->getSchemaBuilder()->getColumnListing($this->model()->getTable());
}

/**
* Default columns setting.
*/
protected function crudColumns(){
  $columns = parent::crudColumns();
  $tableColumns = $this->tableColumns();
  // add all columns from the table
  foreach ($tableColumns as $column)
    $columns->$column;
  // disable editing for primary key
  $columns->{$this->primary()}->disabled();
  // hide and disable deleted_at column
  if ($this->implementsSoftDeletes())
    $columns->{$this->model()->getDeletedAtColumn()}->hidden();

  if (in_array($this->model::CREATED_AT, $tableColumns))
    $columns->{$this->model::CREATED_AT}->disabled()->nonsearchable();
  if (in_array($this->model::UPDATED_AT, $tableColumns))
    $columns->{$this->model::UPDATED_AT}->disabled()->nonsearchable();

  return $columns;
}

}
