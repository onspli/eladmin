<?php
namespace Onspli\Eladmin\Modules\Crud;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Module;
use \Onspli\Eladmin\Exception;

/**
* Generic CRUD module.
*
* Actions
* ```
*
* ```
*
* The following methods needs to be implemented for a particular ORM library.
* ```php
* public function elaPrimary() : string
* private function elaColumnsDef()
* protected function elaWrite(array $row, $id = null) : void
* protected function elaRead($id) : array
* protected function elaDelete($id) : void
* protected function elaQuery(Query $query, &$totalResults) : array
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
* Extends views directory.
*/
public function elaViews() : array {
  return array_merge([__DIR__ . '/../../../views/modules/crud'], $this->elaViews_Module());
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
* IMPLEMENT. Update or create ($id = null) row.
* Row is an associative array ['columnName' => 'value']
*/
protected function elaWrite(array $row, $id = null) : void {

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
protected function elaQuery(Query $query, &$totalResults) : array {
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
* Return ID of the row which should be affected by the action.
* Throws if ID isn't set, unless $allowNull = true.
*/
protected function elaId($allowNull = false) {
  if (!isset($_GET['id']) && !$allowNull)
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
* generate array of actions for one row
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
* Validate and modify values.
*/
private function elaEvalColumns(){
  $columns = $this->elaColumns();
  foreach ($columns as $column => $config) {
    if($config->validate){
      ($config->validate)($_POST[$column]??null, $this);
    }
    if($config->setformat && isset($_POST[$column])){
      $_POST[$column] = ($config->setformat)($_POST[$column], $this);
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
  if(!$this->elaAuth('update'))
    throw new Exception\UnauthorizedException();
  $this->eladmin->elaOutHtml($this->elaView('putForm', ['row' => $this->elaRead($this->elaId())]));
}

/**
* ACTION. List database entries.
*/
public function elaActionRead(){

  $query = new Query();
  $query->fill($_POST);
  $onlyids = $_POST['onlyids'] ?? false;

  $totalResults = 0;
  $rows = $this->elaQuery($query, $totalResults);

  $result = [];
  if ($onlyids) {
    foreach($rows as $row){
      $result[] = $row[$this->elaPrimary()];
    }
    $this->eladmin->elaOutJson($result);
    return;
  }

  $result['totalresults'] = $totalResults;
  $result['results'] = sizeof($rows);
  $result['rows'] = array();
  $result['actions'] = array();

  $elaColumns = $this->elaColumns();
  $elaActions = $this->elaActions();
  foreach($rows as $row){
    $result['actions'][] = $this->elaRowActionsArray($row, $elaActions, $query->trash);
    $result['rows'][] = $this->elaRowValuesArray($row, $elaColumns);
  }
  $result['columns'] = $this->elaColumnsConfigArray($elaColumns);
  $this->eladmin->elaOutJson($result);
}


/**
* ACTION. Edit database entry.
*/
public function elaActionUpdate(){
  $this->elaEvalColumns();
  $this->elaWrite($_POST, $this->elaId());
  $this->eladmin->elaOutText(__('Entry modified.'));
}

/**
* ACTION. Create database entry.
*/
public function elaActionCreate(){
  $this->elaEvalColumns();
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
