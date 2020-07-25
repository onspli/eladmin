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
*       <column name> : <value>,
*       <column name> : <value>,
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
*   columns : [{<first column config>}, {<second column config>}, ...],
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
* protected function elaQuery(array $query, &$totalResults) : array
* public function elaUsesSoftDeletes() : bool
* protected function elaSoftDelete($id) : void
* protected function elaRestore($id) : void
* ```
*/
trait Crud {

use Module {
  Module::elaViews as elaViews_Module;
}

/**
* IMPLEMENT. Does CRUD use soft deletes?
*/
public function elaUsesSoftDeletes() : bool {
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
protected function elaQuery(array $query, &$totalResults) : array {
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

  if ($this->elaAuth('restore')){
    $actions->restore->style('success')->icon('<i class="fas fa-recycle"></i>')->title(__('Restore'))->hidden();
  }

  if ($this->elaAuth('delete')){
    $actions->delete->style('danger')->icon('<i class="fas fa-trash-alt"></i>')->title(__('Delete'))->confirm()->hidden();
  }

  if ($this->elaAuth('update')){
    $actions->putForm->style('primary')->icon('<i class="fas fa-edit"></i>')->done('return;')->hidden();
  } elseif ($this->elaAuth('read')){
    $actions->putForm->style('primary')->icon('<i class="fas fa-eye"></i>')->done('return;')->hidden();
  }

  if ($this->elaUsesSoftDeletes() && $this->elaAuth('softDelete')){
    $actions->softDelete->style('danger')->icon('<i class="fas fa-trash-alt"></i>')->hidden();
  }

  return $actions;
}

/**
* Default filters chainset.
*/
private function elaFiltersDef() {
  return new Chainset\Filters;
}

public function elaColumns() {
  return $this->elaColumnsDef();
}

public function elaActions() {
  return $this->elaActionsDef();
}

public function elaFilters() {
  return $this->elaFiltersDef();
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
private function elaRowValuesArray($row, $elaColumns) {
  $values = [$row[$this->elaPrimary()]];
  foreach($elaColumns as $column) {
    if($column->nonlistable ?? false)
      continue;
    $values[] = $column->getValue($row);
  }
  return $values;
}

/**
* generate array of actions for one column
*/
private function elaColumnsConfigArray($elaColumns) {
  $config = ['id'];
  foreach($elaColumns as $column) {
    if($column->nonlistable ?? false)
      continue;
    $configArr = [];
    if (!$column->raw) {
      $configArr["limit"] = $column->limit;
    } else {
      $configArr["raw"] = 1;
    }
    $config[] = $configArr;
  }
  return $config;
}

/**
* generate array of actions for one item
*/
private function elaRowActionsArray($row, $elaActions, $trash = false){
  $actions = array();
  if ($trash) {
    if(isset($elaActions->restore) && $this->elaAuth('restore')) {
      $actions[] = $elaActions->restore->getAction($row);
    }
    if(isset($elaActions->delete) && $this->elaAuth('delete')) {
      $actions[] = $elaActions->delete->getAction($row);
    }
  } else {
    foreach($elaActions as $action) {
      if(!$this->elaAuth($action->getName()))
        continue;
      if($action->nonlistable)
        continue;
      $actions[] = $action->getAction($row);
    }
    if(isset($elaActions->putForm) && ($this->elaAuth('update') || $this->elaAuth('read'))) {
      $actions[] = $elaActions->putForm->getAction($row);
    }
    if(isset($elaActions->softDelete) && $this->elaUsesSoftDeletes() && $this->elaAuth('softDelete')) {
      $actions[] = $elaActions->softDelete->getAction($row);
    } else if (isset($elaActions->delete) && !$this->elaUsesSoftDeletes() && $this->elaAuth('delete')) {
      $actions[] = $elaActions->delete->getAction($row);
    }
  }
  return $actions;
}

/**
* Validate and modify values before saving.
*/
private function elaValidateAndModify(){
  $columns = $this->elaColumns();
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
  $rows = $this->elaQuery($_POST, $totalResults);

  $ids = [];
  foreach($rows as $row){
    $ids[] = $row[$this->elaPrimary()];
  }

  if ($onlyids) {
    $this->eladmin->elaOutJson($ids);
    return;
  }

  $response = [];
  $response['totalResults'] = $totalResults;
  $response['rows'] = array();
  $response['actions'] = array();

  $elaColumns = $this->elaColumns();
  $elaActions = $this->elaActions();
  foreach($rows as $row){
    $response['actions'][] = $this->elaRowActionsArray($row, $elaActions, ($_POST['trash'] ?? false) ? true : false);
    $response['rows'][] = $this->elaRowValuesArray($row, $elaColumns);
  }
  $response['columns'] = $this->elaColumnsConfigArray($elaColumns);
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
