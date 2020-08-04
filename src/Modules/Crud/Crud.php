<?php
namespace Onspli\Eladmin\Modules\Crud;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Module;
use \Onspli\Eladmin\Exception;

/**
* Generic CRUD module.
*
* ## Actions:
* ```
* updateForm
* createForm
* read
* update
* create
* delete
* softDelete
* restore
* ```
*
* ### Action read
* Request:
* ```lang-js
* {
*   post : {
*     onlyIds : <bool - return only ids, paging not applied>,
*     orderBy : <column name>,
*     direction : <'asc'|'desc'>,
*     page : <requested page number>,
*     resultsPerPage : <number of results per page>,
*     trash : <bool - query only soft deleted items>,
*     search : <search string>,
*     filters : {
*       <column name> : {op : <operator>, val : <value>},
*       <column name> : {op : <operator>, val : <value>},
*       ...
*     }
*   }
* }
* ```
* Response (request.onlyIds == false):
* ```lang-js
* {
*   totalResults : <total number of results on all pages>,
*   ids : [
*     <first item id>,
*     <second item id>,
*     ...
*   ],
*   rows : [
*     [<first column value>, <second column value>, ...],
*     [<first column value>, <second column value>, ...],
*     ...
*   ],
*   actions : [
*     [<first item actions>],
*     [<second item actions>],
*     ...
*   ]
* }
* ```
* Response (request.onlyIds == true):
* ```lang-js
* [
*   <first item id>,
*   <second item id>,
*   ...
* ]
* ```
*
*/
abstract class Crud extends Module {

/**
* Constant. Infinite number of results requested.
*/
const INFINITY = 0;

/**
* Constant. Ascending order.
*/
const ASC = 'asc';

/**
* Constant. Descending order.
*/
const DESC = 'desc';

/**
* Columns chainset class
*/
protected $crudColumns = Chainset\Columns::class;

/**
* Actions chainset class
*/
protected $crudActions = Chainset\Actions::class;

/**
* Filters chainset class
*/
protected $crudFilters = Chainset\Filters::class;

/**
* Cached columns chainset
*/
private $crudColumnsCached = null;

/**
* Cached actions chainset;
*/
private $crudActionsCached = null;

/**
* Cached filters chainset.
*/
private $crudFiltersCached = null;

/**
* IMPLEMENT. Does CRUD use soft deletes?
*/
public function implementsSoftDeletes() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support searching?
*/
public function implementsSearch() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support paging?
*/
public function implementsPaging() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support sorting?
*/
public function implementsSorting() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support filtering?
*/
public function implementsFilters() : bool {
  return false;
}

/**
* IMPLEMENT. Name of primary key column. Default is 'id'.
*/
abstract public function primary() : string;

/**
* IMPLEMENT. Create item.
* @param $values associative array in form ['columnName' => 'value', ...]
*/
abstract protected function create(array $values) : void;

/**
* IMPLEMENT. Update item.
* @param $values associative array in form ['columnName' => 'value', ...]
* @param $id id of item to be updated
*/
abstract protected function update(array $values, $id) : void;

/**
* IMPLEMENT. Read one row, or get default one ($id = null)
* Returns row as an associative array ['columnName' => 'value']
*/
abstract protected function get($id) : array;

/**
* IMPLEMENT. Hard delete row.
*/
abstract protected function delete($id) : void;

/**
* IMPLEMENT. Soft delete row.
*/
abstract protected function softDelete($id) : void;

/**
* IMPLEMENT. Restore soft deleted row.
*/
abstract protected function restore($id) : void;

/**
* IMPLEMENT. Fetch an array of rows.
* Row is an associative array ['columnName' => 'value']
* $totalResults needs to be set to number of results without paging applied
*/
abstract protected function read(array $request, &$totalResults) : array;

/**
* IMPLEMENT. Default columns chainset. Override to configure columns.
*/
protected function crudColumns() {
  if (!is_a($this->crudColumns, Chainset\Columns::class, true))
    throw new Exception\Exception($this->crudColumns . ' is not a subclass of ' . Chainset\Columns::class);
  $columns = new $this->crudColumns;
  return $columns;
}

/**
* Default actions chainset. Override to configure actions.
*/
protected function crudActions() {
  if (!is_a($this->crudActions, Chainset\Actions::class, true))
    throw new Exception\Exception($this->crudActions . ' is not a subclass of ' . Chainset\Actions::class);
  $actions = new $this->crudActions;

  $actions->create->icon('<i class="fas fa-plus-circle"></i>')->label(__('Add'))->hidden();
  $actions->updateForm->hidden()->label('')->style('primary')->icon('<i class="fas fa-edit"></i>')->nonbulk();
  $actions->createForm->hidden()->nonbulk();
  $actions->delete->style('danger')->label(__('Delete'))->icon('<i class="fas fa-trash-alt"></i>')->title()->confirm()->bulk()->done('modalClose();');

  if ($this->implementsSoftDeletes()) {
    $actions->restore->style('success')->label(__('Restore'))->icon('<i class="fas fa-recycle"></i>')->bulk()->hidden();
    $actions->softDelete->style('danger')->label(__('Move to trash'))->icon('<i class="fas fa-trash-alt"></i>')->bulk()->done('modalClose();');
    $actions->delete->hidden();
  } else {
    $actions->delete->listable()->editable();
  }

  if (!$this->auth('update') && $this->auth('read')) {
    $actions->updateForm->icon('<i class="fas fa-eye"></i>');
  }

  return $actions;
}

/**
* Default filters chainset. Override to configure filters.
*/
protected function crudFilters() {
  if (!is_a($this->crudFilters, Chainset\Filters::class, true))
    throw new Exception\Exception($this->crudFilters . ' is not a subclass of ' . Chainset\Filters::class);
  return new $this->crudFilters;
}

/**
* Get columns chainset.
*/
final public function getCrudColumns() : Chainset\Columns {
  if ($this->crudColumnsCached === null)
    $this->crudColumnsCached = $this->crudColumns();
  return $this->crudColumnsCached;
}

/**
* Get actions chainset.
*/
final public function getCrudActions() : Chainset\Actions {
  if ($this->crudActionsCached === null)
    $this->crudActionsCached = $this->crudActions();
  return $this->crudActionsCached;
}

/**
* Get filters chainset.
*/
final public function getCrudFilters() : Chainset\Filters {
  if ($this->crudFiltersCached === null)
    $this->crudFiltersCached = $this->crudFilters();
  return $this->crudFiltersCached;
}

/**
* Extends views directory.
*/
protected function views() : array {
  return array_merge([__DIR__ . '/../../../views/modules/crud'], parent::views());
}


/**
* Return ID of the row which should be affected by the action.
*/
protected function id($throwIfNull = true) {
  if (!isset($_GET['id']) && $throwIfNull)
    throw new Exception\BadRequestException(__('Entry not found!'));
  return $_GET['id'] ?? null;
}

/**
* generate array of values for one row
*/
private function rowValuesArray($row) {
  $crudColumns = $this->getCrudColumns();
  $values = [];
  foreach($crudColumns as $column) {
    if($column->nonlistable ?? false)
      continue;
    $values[] = $column->getValue($row);
  }
  return $values;
}

/**
* generate array of actions for one item
*/
private function rowActionsArray($row) {
  $crudActions = $this->getCrudActions();
  $actions = array();
  foreach($crudActions as $action) {
    if(!$this->auth($action->getName()))
      continue;
    if($action->nonlistable)
      continue;
    $actions[] = $action->getName();
  }
  return $actions;
}

/**
* Validate and modify values before saving.
*/
private function validateAndModify(){
  $columns = $this->getCrudColumns();
  // unset columns which we shouldn't recieve
  foreach ($_POST as $key => $value) {
    if (!isset($columns->$key) || $columns->$key->disabled || $columns->$key->noneditable) {
      unset($_POST[$key]);
    }
  }
  // validate values
  foreach ($columns as $key => $column) {
    if ($columns->$key->disabled || $columns->$key->noneditable)
      continue;
    $column->evalProperty('validate', $_POST);
  }
  // modify values
  foreach ($columns as $key => $column) {
    if ($column->setformat) {
      $value = $column->evalProperty('setformat', $_POST);
      if (array_key_exists($key, $_POST)) {
        $_POST[$key] = $value;
      }
    }
  }
}

public function prepare() : void {
  if (($_GET['update'] ?? null) && $this->auth('update')) {
    $this->validateAndModify();
    $this->update($_POST, $this->id());
  }
}


/**
* ACTION. Show form - create entry.
*/
public function actionCreateForm(){
  if(!$this->auth('create'))
    throw new Exception\UnauthorizedException();
  $this->renderHtml($this->render('createForm', ['row' => $this->get(null)]));
}

/**
* ACTION. Show form - edit entry.
*/
public function actionUpdateForm(){
  if(!$this->auth('read'))
    throw new Exception\UnauthorizedException();
  $this->renderHtml($this->render('updateForm', ['row' => $this->get($this->id())]));
}

/**
* ACTION. List database entries.
*/
public function actionRead() {

  $totalResults = 0;
  $onlyIds = $_POST['onlyIds'] ?? false;
  $trash = ($_POST['trash'] ?? false) ? true : false;
  if (!$this->implementsPaging() || $onlyIds) {
    $_POST['page'] = 1;
    $_POST['resultsPerPage'] = self::INFINITY;
  }
  if (!$this->implementsSoftDeletes()) {
    $_POST['trash'] = 0;
  }
  if (!$this->implementsSearch()) {
    $_POST['search'] = '';
  }
  if (!$this->implementsFilters()) {
    $_POST['filters'] = [];
  }
  if (!$this->implementsSorting()) {
    $_POST['sortBy'] = null;
    $_POST['direction'] = null;
  }

  if (!$_POST['sortBy']) {
    $_POST['sortBy'] = $this->primary();
  }
  if (!in_array($_POST['direction'], [self::ASC, self::DESC])) {
    $_POST['direction'] = self::DESC;
  }

  $rows = $this->read($_POST, $totalResults);

  $ids = [];
  foreach($rows as $row){
    $ids[] = $row[$this->primary()];
  }

  if ($onlyIds) {
    $this->renderJson($ids);
    return;
  }

  $response = [];
  $response['totalResults'] = $totalResults;
  $response['ids'] = $ids;
  $response['rows'] = array();
  $response['actions'] = array();

  foreach($rows as $row){
    $response['actions'][] = $trash ? [] : $this->rowActionsArray($row);
    $response['rows'][] = $this->rowValuesArray($row);
  }
  $this->renderJson($response);
}


/**
* ACTION. Edit database entry.
*/
public function actionUpdate(){
  $this->validateAndModify();
  $this->update($_POST, $this->id());
  $this->renderText(__('Entry modified.'));
}

/**
* ACTION. Create database entry.
*/
public function actionCreate(){
  $this->validateAndModify();
  $this->create($_POST);
  $this->renderText(__('Entry added.'));
}

/**
* ACTION. Hard delete.
*/
public function actionDelete(){
  $this->delete($this->id());
  $this->renderText(__('Entry deleted.'));
}

/**
* ACTION. Soft delete.
*/
public function actionSoftDelete(){
  $this->softDelete($this->id());
  $this->renderText(__('Entry moved to trash.'));
}

/**
* ACTION. Restore.
*/
public function actionRestore(){
  $this->restore($this->id());
  $this->renderText(__('Entry restored.'));
}

}
