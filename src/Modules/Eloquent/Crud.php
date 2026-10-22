<?php
namespace Onspli\Eladmin\Modules\Eloquent;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;
use Illuminate\Database;

/**
* Crud module for Eloquent model.
*/
abstract class Crud extends Eladmin\Modules\Crud\Crud {

/**
* Model class name. Must be overriden.
*/
protected $model = null;

/**
* Model instance
*/
private $imodel = null;

protected $crudColumns = Chainset\Columns::class;

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
* Return model instance for action.
*/
protected function model() {
  if ($this->imodel === null) {
    try {
      $this->imodel = new $this->model;
    } catch(\Throwable $e) {
      $this->core()->log()->error($e->getMessage());
      throw new Exception\BadRequestException( __('You have to set $model property to %s module!', static::class) );
    } catch(\Exception $e) {
      $this->core()->log()->error($e->getMessage());
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

/**
* Update or create entry.
*/
private function updateOrCreate($entry, $row) : void {
  $tableColumns = $this->tableColumns();

  foreach ($row as $column => $value) {
    if (!in_array($column, $tableColumns) ) {
      continue;
    }
    $entry->{$column} = $value;
  }

  $entry->save();
}

/**
* Prepare action. Initialise model() with the requested db entry.
*/
public function prepare() : void {
  parent::prepare();
  if (in_array($this->core()->actionkey(), Eladmin\Modules\Crud\Crud::actions()))
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
  $row = $this->model()->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  return $this->rowToArray($row);
}

protected function delete($id) : void {
  if ($this->implementsSoftDeletes()) {
    $row = $this->model::withTrashed()->find($id);
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

  if ($request['trash']) {
    $q = $q->onlyTrashed();
  }

  $search = $request['search'];
  if ($search && $this->implementsSearch()) {
    $q = $q->where( function ($subQ) use ($search) {
      foreach ($this->getCrudColumns() as $column) {
        if (!$column->searchable)
          continue;
        $subQ = $subQ->orWhere($column->getName(), 'LIKE', '%' . $search . '%');
      }
    } );
  }

  if ($this->implementsFilters()) {
    foreach ($this->getCrudFilters() as $filterName => $filter) {
      $filterPost = $request['filters'][$filterName] ?? null;
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

  $rows = [];
  foreach ($q->get() as $row)
    $rows[] = $this->rowToArray($row);
  return $rows;
}

protected function softDelete($id) : void {
  $row = $this->model()->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  if (!$this->implementsSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  else
    $row->delete();
}

protected function restore($id) : void {
  if (!$this->implementsSoftDeletes())
    throw new Exception\BadRequestException( __('This CRUD doesn\'t support soft deletes!') );
  $row = $this->model()->withTrashed()->find($id);
  if (!$row)
    throw new Exception\BadRequestException( __('Entry not found!') );
  $row->restore();
}

/**
* Convert model to array keeping dates in the database format (e.g. 2020-08-05 12:49:07).
* Eloquent 7+ serializes dates as ISO-8601 by default, older versions used the database format.
* Dates serialized with custom format (model's serializeDate or datetime:<format> cast) are kept untouched.
*/
private function rowToArray($row) : array {
  $array = $row->toArray();
  foreach ($array as $key => $value) {
    if (!is_string($value))
      continue;
    $date = $row->getAttribute($key);
    if (!$date instanceof \DateTimeInterface)
      continue;
    $iso = $date instanceof \DateTimeImmutable ? \Carbon\CarbonImmutable::instance($date)->toJSON() : \Carbon\Carbon::instance($date)->toJSON();
    if ($value === $iso)
      $array[$key] = $date->format($row->getDateFormat());
  }
  return $array;
}

/**
* Get an array of table columns.
* MySQL/MariaDB are queried directly, because Laravel 11's getColumnListing()
* selects generation_expression, which MySQL < 5.7 doesn't have.
*/
protected function tableColumns() : array {
  $conn = $this->model()->getConnection();
  $table = $this->model()->getTable();
  if (!in_array($conn->getDriverName(), ['mysql', 'mariadb']))
    return $conn->getSchemaBuilder()->getColumnListing($table);

  $rows = $conn->select(
    'select column_name as `name` from information_schema.columns where table_schema = ? and table_name = ? order by ordinal_position',
    [$conn->getDatabaseName(), $conn->getTablePrefix() . $table]
  );
  return array_map(fn($row) => $row->name, $rows);
}

/**
* Default columns setting.
*/
protected function crudColumns(){
  $columns = parent::crudColumns();
  $tableColumns = $this->tableColumns();
  // add all columns from the table
  foreach ($tableColumns as $column)
    $columns->$column->enabled()->sortable()->searchable();
  // disable editing for primary key
  $columns->{$this->primary()}->disabled();
  // hide and disable deleted_at column
  if ($this->implementsSoftDeletes())
    $columns->{$this->model()->getDeletedAtColumn()}->hidden()->nonsearchable();

  if (in_array($this->model::CREATED_AT, $tableColumns))
    $columns->{$this->model::CREATED_AT}->disabled()->nonsearchable();
  if (in_array($this->model::UPDATED_AT, $tableColumns))
    $columns->{$this->model::UPDATED_AT}->disabled()->nonsearchable();

  return $columns;
}

}
