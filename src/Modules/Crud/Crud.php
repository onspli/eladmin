<?php
namespace Onspli\Eladmin\Modules\Crud;
use \Onspli\Eladmin\Module;
use \Onspli\Eladmin\Exception;


trait Crud {

  use Module {
    Module::elaAuth as elaAuth_Module;
    Module::elaViews as elaViews_Module;
  }

  private $elaRolesFromActionsChainsetAlreadySet = false;

  /**
  * Check if user is authorized to do action, or athorized to access module at all.
  */
  final public function elaAuth(?string $action = null) : bool {
    if (!$this->elaRolesFromActionsChainsetAlreadySet) {
      $this->elaRolesFromActionsChainsetAlreadySet = true;
      $this->elaActions();
    }
    return $this->elaAuth_Module($action);
  }

  public function elaViews() : array {
    return array_merge([__DIR__ . '/../../../views/modules/crud'], $this->elaViews_Module());
  }

  public function elaUsesSoftDeletes(){
    return false;
  }

  /**
  * Returns an array of columns that cannot be edited from crud by default. (i.e. primary key, automanaged timestamps)
  */
  public function elaDisabledColumns(){
    return [];
  }

  public function elaVisibleColumns(){
    $columns = $this->getTableColumns();
    return $columns;
  }


  /**
  * Get an array of real table columns data columns stored in database.
  */
  final private function getTableColumns() {
    return ['id', 'name', 'desc'];
  }

  /**
  * Default columns chainset.
  */
  private function elaColumnsDef(){
    $visibleColumns = $this->elaVisibleColumns();
    $disabledColumns = $this->elaDisabledColumns();
    $realColumns = $this->getTableColumns();
    $columns = new Chainset\Columns;
    foreach($realColumns as $column){
      $columns->$column;
      if(!in_array($column, $visibleColumns))
        $columns->$column->hidden()->nonsearchable();
      if(in_array($column, $disabledColumns))
        $columns->$column->disabled()->nonsearchable();
      if(in_array($column, $realColumns))
        $columns->$column->realcolumn = true;
      if(!$this->elaAuth('update'))
        $columns->$column->disabled();
    }
    if($this->elaUsesSoftDeletes())
      unset($columns->deleted_at);
    return $columns;
  }

  final private function elaActionsDef(){
    $actions = new Chainset\Actions;
    $actions->setModule($this);

    if ($this->elaAuth('restore')){
      $actions->restore->style('success')->icon('<i class="fas fa-recycle"></i>')->title(__('Restore'))->hidden();
    }

    if ($this->elaAuth('forceDelete')){
      $actions->forceDelete->style('danger')->icon('<i class="fas fa-trash-alt"></i>')->title(__('Delete'))->confirm()->hidden();
    }


    if ($this->elaAuth('update')){
      $actions->putForm->style('primary')->icon('<i class="fas fa-edit"></i>')->done('return;')->hidden();
    }
    elseif ($this->elaAuth('read')){
      $actions->putForm->style('primary')->icon('<i class="fas fa-eye"></i>')->done('return;')->hidden();
    }

    if ($this->elaUsesSoftDeletes() && $this->elaAuth('delete')){
      $actions->delete->style('danger')->icon('<i class="fas fa-trash-alt"></i>')->hidden();
    }

    return $actions;
  }

  final private function elaFiltersDef(){
    return new Chainset\Filters;
  }

  public function elaColumns(){
    return $this->elaColumnsDef();
  }

  public function elaActions(){
    return $this->elaActionsDef();
  }

  public function elaFilters(){
    return $this->elaFiltersDef();
  }


  public function elaActionPostForm(){
    if(!$this->elaAuth('create'))
      throw new Exception\UnauthorizedException();
    echo $this->elaView('postForm', ['row'=>$this]);
  }

  public function elaActionPutForm(){
    if(!$this->elaAuth('read'))
      throw new Exception\UnauthorizedException();
    echo $this->elaView('putForm', ['row'=>$this]);
  }

  private function elaRowValuesArray($row, $elaColumns){
    $values = [$row[$this->getKeyName()]];
    foreach($elaColumns as $column){
      if($column->nonlistable??false) continue;
      $values[] = $column->getValue($row);
    }
    return $values;
  }

  private function elaColumnsConfigArray($elaColumns){
    $config = ['elaid'];
    foreach($elaColumns as $column){
      if($column->nonlistable??false) continue;
      $configArr = [];
      if (!$column->rawoutput){
        $configArr["limit"] = $column->listlimit;
      } else{
        $configArr["raw"] = 1;
      }
      $config[] = $configArr;
    }
    return $config;
  }

  // generate array of actions for one row
  private function elaRowActionsArray($row, $elaActions, $trash=false){
    $actions = array();

    if($trash)
    {

      if(isset($elaActions->restore) && $this->elaAuth('restore')){
        $actions[] = $elaActions->restore->getAction($row);
      }

      if(isset($elaActions->forceDelete) && $this->elaAuth('forceDelete')){
        $actions[] = $elaActions->forceDelete->getAction($row);
      }

    }
    else
    {

      foreach($elaActions as $action)
      {
        if(!$this->elaAuth($action->getName())) continue;
        if($action->nonlistable) continue;
        $actions[] = $action->getAction($row);
      }

      if(isset($elaActions->putForm) && ($this->elaAuth('update') || $this->elaAuth('read'))){
        $actions[] = $elaActions->putForm->getAction($row);
      }

      if(isset($elaActions->delete) && $this->elaUsesSoftDeletes() && $this->elaAuth('delete')){
        $actions[] = $elaActions->delete->getAction($row);
      }

    }
    return $actions;
  }

  private function elaReadQuery($sort=null, $direction='desc', $page=1, $resultsperpage=10, $search='', $columns=[], $trash=false){
    $sort = $sort ?? $this->elaOrderBy ?? $this->getKeyName();
    $elaColumns = $this->elaColumns();

    $q = $this;

    if($trash){
      $q = $this->onlyTrashed();
    }

    if($search){
      $q = $q->where(function($q) use($elaColumns, $search){
        foreach($elaColumns as $col){
          if (!$col->realcolumn || $col->nonsearchable) continue;
          $q = $q->orWhere($col->getName(), 'LIKE', '%'.$search.'%');
        }
      });
    }

    foreach($columns as $col=>$data){
      $q = $q->where($col, $data['op'], $data['val']);
    }

    $q = $q->orderBy($sort, $direction);
    return $q;
  }

  /**
  * List database entries.
  */
  public function elaActionRead(){

    $sort = $_POST['sort']??$this->elaOrderBy??$this->getKeyName();
    $direction = $_POST['direction']??$this->orderDirection??'desc';
    $page = $_POST['page']??1;
    $resultsperpage = $_POST['resultsperpage']??10;
    $search = $_POST['search']??'';
    $columns = $_POST['columns']??[];
    $trash = $_POST['trash']??false;
    $onlyids = $_POST['onlyids']??false;

    $q = $this->elaReadQuery($sort, $direction, $page, $resultsperpage, $search, $columns, $trash);
    $total = $q->count();
    $rows = $q->offset(($page-1)*$resultsperpage)->limit($resultsperpage)->get();

    $result = [];
    if($onlyids){
      foreach($rows as $row){
        $result[] = $row[$this->getKeyName()];
      }
      $this->elaOutJson($result);
      return;
    }

    $result['totalresults'] = $total;
    $result['results'] = sizeof($rows);
    $result['rows'] = array();
    $result['actions'] = array();

    $elaColumns = $this->elaColumns();
    $elaActions = $this->elaActions();
    foreach($rows as $row){
      $result['actions'][] = $this->elaRowActionsArray($row, $elaActions, $trash);
      $result['rows'][] = $this->elaRowValuesArray($row, $elaColumns);
    }
    $result['columns'] = $this->elaColumnsConfigArray($elaColumns);
    $this->elaOutJson($result);
  }

  /**
  * Edit database entry.
  */
  public function elaActionUpdate(){
    $this->elaUpdate();
    $this->elaOutText(__('Entry modified.'));
  }

  /**
  * Create database entry.
  */
  public function elaActionCreate(){
    $this->elaUpdate();
    $this->elaOutText(__('Entry added.'));
  }

  protected function elaUpdate(){
    $columns = $this->elaColumns();
    foreach ($columns as $column => $config) {
      if($config->validate){
        ($config->validate)($_POST[$column]??null, $this);
      }
      if($config->setformat && isset($_POST[$column])){
        $_POST[$column] = ($config->setformat)($_POST[$column], $this);
      }
    }

    $tcolumns = $this->getTableColumns();
    foreach($tcolumns as $column){
      $value = $_POST[$column]??null;
      if($value === null || !isset($columns->{$column}) || $columns->{$column}->disabled) continue;
      $this->{$column} = $value;
    }

    $this->save();
    $this->refresh();
  }

  /**
  * Delete database entry.
  */
  public function elaActionDelete(){
    $this->delete();
    Header('Content-type: text/plain');
    if($this->elaUsesSoftDeletes())
      $this->elaOutText(__('Entry deleted. It can be restored from Trash later.'));
    else
      $this->elaOutText(__('Entry deleted.'));
  }

  public function elaActionForceDelete(){
    if(!$this->elaAuth('delete'))
      throw new Exception\UnauthorizedException();
    $this->forceDelete();
    $this->elaOutText(__('Deleted forever!'));
  }

  public function elaActionRestore(){
    if(!$this->elaAuth('delete'))
      throw new Exception\UnauthorizedException();
    $this->restore();
    $this->elaOutText(__('Entry restored.'));
  }

  public function elaInstanceForAction(){
    if(!isset($_GET['elaid'])) return $this;
    $entry = new static();
    $action = $this->eladmin->actionkey();
    if(in_array($action, ['forcedelete', 'restore']))
      $entry = $entry->withTrashed();
    $entry = $entry->find($_GET['elaid']);
    if(!$entry) throw new Exception\BadRequestException( __('Entry not found!') );
    $entry->elaInit($this->eladmin, $this->elakey);
    if(!in_array($action, ['update']) && $this->elaAuth('update') && ($_GET['elaupdate']??false)){
      $entry->elaUpdate();
    }
    return $entry;
  }

}
