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
* postForm
* putForm
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
* ## Connecting CRUD with ORM
* The following methods needs to be implemented for a particular ORM library.
* ```lang-php
* public function elaPrimary() : string
* private function elaColumnsDef()
* protected function elaWrite(array $values, $id = null) : void
* protected function elaRead($id) : array
* protected function elaDelete($id) : void
* protected function elaRequest(array $request, &$totalResults) : array
*
* public function elaImplementsPaging() : bool
* public function elaImplementsSorting() : bool
* public function elaImplementsSearch() : bool
* public function elaImplementsFilters() : bool
* public function elaImplementsSoftDeletes() : bool
* protected function elaSoftDelete($id) : void
* protected function elaRestore($id) : void
* ```
*/
trait Crud {

use Module {
  Module::elaViews as elaViews_Module;
}

/**
* Constant. Infinite number of results requested.
*/
protected $INFINITY = 0;

/**
* Constant. Ascending order.
*/
protected $ASC = 'asc';

/**
* Constant. Descending order.
*/
protected $DESC = 'desc';

/**
* Cached columns chainset
*/
private $elaColumns = null;

/**
* Cached actions chainset;
*/
private $elaActions = null;

/**
* Cached filters chainset.
*/
private $elaFilters = null;

/**
* IMPLEMENT. Does CRUD use soft deletes?
*/
public function elaImplementsSoftDeletes() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support searching?
*/
public function elaImplementsSearch() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support paging?
*/
public function elaImplementsPaging() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support sorting?
*/
public function elaImplementsSorting() : bool {
  return false;
}

/**
* IMPLEMENT. Does CRUD support filtering?
*/
public function elaImplementsFilters() : bool {
  return false;
}

/**
* IMPLEMENT. Name of primary key column. Default is 'id'.
*/
public function elaPrimary() : string {
  return 'id';
}

/**
* IMPLEMENT. Update or creat item.
* @param $values associative array in form ['columnName' => 'value', ...]
* @param $id id of item to be updated, or null if it's a new item
*/
protected function elaWrite(array $values, $id = null) : void {

}

/**
* IMPLEMENT. Read one row, or get default one ($id = null)
* Returns row as an associative array ['columnName' => 'value']
*/
protected function elaRead($id) : array {
  return [$this->elaPrimary() => null];
}

/**
* IMPLEMENT. Hard delete row.
*/
protected function elaDelete($id) : void {

}

/**
* IMPLEMENT. Soft delete row.
*/
protected function elaSoftDelete($id) : void {

}

/**
* IMPLEMENT. Restore soft deleted row.
*/
protected function elaRestore($id) : void {

}

/**
* IMPLEMENT. Query for an array of rows.
* Row is an associative array ['columnName' => 'value']
* $totalResults needs to be set to number of results without paging applied
*/
protected function elaRequest(array $request, &$totalResults) : array {
  return [];
}

/**
* IMPLEMENT. Default columns chainset.
*/
private function elaColumnsDef() {
  $columns = new Chainset\Columns;
  return $columns;
}

/**
* Default actions chainset.
*/
private function elaActionsDef() {
  $actions = new Chainset\Actions;
  $actions->setModule($this);

  foreach ($this->elaActionsList() as $action) {
    $actions->{$action}->bulk();
  }

  unset($actions->create);
  unset($actions->update);
  unset($actions->read);
  $actions->putForm->hidden()->label('')->style('primary')->icon('<i class="fas fa-edit"></i>')->nonbulk();
  $actions->postForm->hidden()->nonbulk();
  $actions->restore->style('success')->label('')->icon('<i class="fas fa-recycle"></i>')->title(__('Restore'))->hidden();
  $actions->delete->style('danger')->label('')->icon('<i class="fas fa-trash-alt"></i>')->title(__('Delete'))->confirm()->hidden();
  $actions->softDelete->style('danger')->label('')->icon('<i class="fas fa-trash-alt"></i>')->hidden();

  if (!$this->elaImplementsSoftDeletes()) {
    unset($actions->restore);
    unset($actions->softDelete);
  }

  if (!$this->elaAuth('update') && $this->elaAuth('read')) {
    $actions->putform->icon('<i class="fas fa-eye"></i>');
  }




  return $actions;
}

/**
* Default filters chainset.
*/
private function elaFiltersDef() {
  return new Chainset\Filters;
}

/**
* Override to configure columns.
*/
protected function elaColumns() {
  return $this->elaColumnsDef();
}

/**
* Override to configure actions.
*/
protected function elaActions() {
  return $this->elaActionsDef();
}

/**
* Override to configure filters.
*/
protected function elaFilters() {
  return $this->elaFiltersDef();
}

/**
* Get columns chainset.
*/
final public function elaColumnsGet() {
  if ($this->elaColumns === null)
    $this->elaColumns = $this->elaColumns();
  return $this->elaColumns;
}

/**
* Get actions chainset.
*/
final public function elaActionsGet() {
  if ($this->elaActions === null)
    $this->elaActions = $this->elaActions();
  return $this->elaActions;
}

/**
* Get filters chainset.
*/
final public function elaFiltersGet() {
  if ($this->elaFilters === null)
    $this->elaFilters = $this->elaFilters();
  return $this->elaFilters;
}

/**
* Extends views directory.
*/
public function elaViews() : array {
  return array_merge([__DIR__ . '/../../../views/modules/crud'], $this->elaViews_Module());
}


/**
* Return ID of the row which should be affected by the action.
*/
protected function elaId($throwIfNull = true) {
  if (!isset($_GET['id']) && $throwIfNull)
    throw new Exception\BadRequestException(__('Entry not identified.'));
  return $_GET['id'] ?? null;
}

/**
* generate array of values for one row
*/
private function elaRowValuesArray($row) {
  $elaColumns = $this->elaColumnsGet();
  $values = [];
  foreach($elaColumns as $column) {
    if($column->nonlistable ?? false)
      continue;
    $values[] = $column->getValue($row);
  }
  return $values;
}

/**
* generate array of actions for one item
*/
private function elaRowActionsArray($row) {
  $elaActions = $this->elaActionsGet();
  $actions = array();
  foreach($elaActions as $action) {
    if(!$this->elaAuth($action->getName()))
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
private function elaValidateAndModify(){
  $columns = $this->elaColumnsGet();
  // check that disabled columns are not set
  foreach ($columns as $column => $config) {
    if ($config->disabled && isset($_POST[$column])) {
      unset($_POST[$column]);
    }
  }
  // validate values
  foreach ($columns as $column => $config) {
    if ($config->validate) {
      ($config->validate)($_POST[$column] ?? null, $this);
    }
  }
  // modify values
  foreach ($columns as $column => $config) {
    if ($config->setformat) {
      $_POST[$column] = ($config->setformat)($_POST[$column] ?? null, $this);
    }
  }
}

final public function elaInstanceForAction() : object {
  if (($_GET['update'] ?? null) && $this->elaAuth('update')) {
    $this->elaValidateAndModify();
    $this->elaWrite($_POST, $this->elaId());
  }
  return $this;
}


/**
* ACTION. Show form - create entry.
*/
public function elaActionPostForm(){
  if(!$this->elaAuth('create'))
    throw new Exception\UnauthorizedException();
  $this->eladmin->elaOutHtml($this->elaView('postForm', ['row' => $this->elaRead(null)]));
}

/**
* ACTION. Show form - edit entry.
*/
public function elaActionPutForm(){
  if(!$this->elaAuth('read'))
    throw new Exception\UnauthorizedException();
  $this->eladmin->elaOutHtml($this->elaView('putForm', ['row' => $this->elaRead($this->elaId())]));
}

/**
* ACTION. List database entries.
*/
public function elaActionRead(){

  $totalResults = 0;
  $onlyIds = $_POST['onlyIds'] ?? false;
  $trash = ($_POST['trash'] ?? false) ? true : false;
  if (!$this->elaImplementsPaging() || $onlyIds) {
    $_POST['page'] = 1;
    $_POST['resultsPerPage'] = $this->INFINITY;
  }
  if (!$this->elaImplementsSoftDeletes()) {
    $_POST['trash'] = 0;
  }
  if (!$this->elaImplementsSearch()) {
    $_POST['search'] = '';
  }
  if (!$this->elaImplementsFilters()) {
    $_POST['filters'] = [];
  }
  if (!$this->elaImplementsSorting()) {
    $_POST['sortBy'] = null;
    $_POST['direction'] = null;
  }

  if (!$_POST['sortBy']) {
    $_POST['sortBy'] = $this->elaPrimary();
  }
  if (!in_array($_POST['direction'], [$this->ASC, $this->DESC])) {
    $_POST['direction'] = $this->DESC;
  }

  $rows = $this->elaRequest($_POST, $totalResults);

  $ids = [];
  foreach($rows as $row){
    $ids[] = $row[$this->elaPrimary()];
  }

  if ($onlyIds) {
    $this->eladmin->elaOutJson($ids);
    return;
  }

  $response = [];
  $response['totalResults'] = $totalResults;
  $response['ids'] = $ids;
  $response['rows'] = array();
  $response['actions'] = array();

  foreach($rows as $row){
    $response['actions'][] = $trash ? [] : $this->elaRowActionsArray($row);
    $response['rows'][] = $this->elaRowValuesArray($row);
  }
  $this->eladmin->elaOutJson($response);
}


/**
* ACTION. Edit database entry.
*/
public function elaActionUpdate(){
  $this->elaValidateAndModify();
  $this->elaWrite($_POST, $this->elaId());
  $this->eladmin->elaOutText(__('Entry modified.'));
}

/**
* ACTION. Create database entry.
*/
public function elaActionCreate(){
  $this->elaValidateAndModify();
  $this->elaWrite($_POST);
  $this->eladmin->elaOutText(__('Entry added.'));
}

/**
* ACTION. Hard delete.
*/
public function elaActionDelete(){
  $this->elaDelete($this->elaId());
  $this->eladmin->elaOutText(__('Entry deleted.'));
}

/**
* ACTION. Soft delete.
*/
public function elaActionSoftDelete(){
  $this->elaSoftDelete($this->elaId());
  $this->eladmin->elaOutText(__('Entry deleted. It can be restored from Trash later.'));
}

/**
* ACTION. Restore.
*/
public function elaActionRestore(){
  $this->elaRestore($this->elaId());
  $this->eladmin->elaOutText(__('Entry restored.'));
}

}
