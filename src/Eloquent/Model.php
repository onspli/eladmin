<?php
namespace Onspli\Eladmin\Eloquent;


class Model extends \Illuminate\Database\Eloquent\Model implements \Onspli\Eladmin\Iface\Module
{

  protected $elaTitle = null;
  protected $elaIcon = '<i class="fas fa-puzzle-piece"></i>';

  /**
  * Blade configuration
  */
  public $bladeViews = [];
  public $bladeCache = null;
  public $bladeViewRender = 'render';
  public $bladeViewPutForm = 'putForm';
  public $bladeViewPostForm = 'postForm';
  public $bladeViewTable = 'table';
  public $bladeViewRow = 'row';
  protected $blade = null;

  public $eladmin = null;

  protected $elaAuthorizedRoles = [];
  protected $elaAuthorizedRolesForLowercaseActions = [
    'postrow' => [],
    'putrow' => [],
    'delrow' => []
  ];

  /**
  * Render a view.
  */
  protected function view($name, $args=[]){
    if(!$this->blade)
      $this->blade = new \Philo\Blade\Blade(array_merge($this->bladeViews, [__DIR__ . '/../../views/modules/Model']), $this->bladeCache);
    return $this->blade->view()->make($name, $args+['eladmin'=>$this->eladmin, 'elaModule'=>$this]);
  }

  /**
  * Check if table for the model exists in the database;
  * @return bool
  */
  public function tableExists(){
    return $this->getSchema()->hasTable($this->getTable());
  }

  /**
  * Get an array of table columns.
  * @return array
  */
  public function getTableColumns() {
    return $this->getSchema()->getColumnListing($this->getTable());
  }

  /**
  * Get schema manager.
  */
  public function getSchema(){
    return $this->getConnection()->getSchemaBuilder();
  }

  /**
  * Getters
  */
  public function elaGetTitle(): string {
    if($this->elaTitle) return $this->elaTitle;
    else return $this->getTable();
  }

  public function elaGetIcon(): string {
    return $this->elaIcon;
  }

  public function elaGetAuthorizedRoles(): array{
    return $this->elaAuthorizedRoles;
  }

  public function elaGetAuthorizedRolesActions(): array{
    return $this->elaAuthorizedRolesForLowercaseActions;
  }

  /**
  * Render page in administration.
  */
  public function elaRender(){
    echo $this->view($this->bladeViewRender,['elaModule' => $this]);
  }

  public function elaColumns(){
    $visibleColumns = $this->elaVisibleColumns();
    $disabledColumns = $this->elaDisabledColumns();
    $columns = new \Onspli\Eladmin\Eloquent\Column\Column(true);
    foreach($visibleColumns as $column){
      $columns->$column;
      if(in_array($column, $disabledColumns))
        $columns->$column->disabled();
    }
    return $columns;
  }


  /**
  * Returns an array of columns that cannot be edited from crud. (i.e. primary key, automanaged timestamps)
  */
  public function elaDisabledColumns(){
    $columns = [$this->getKeyName()];
    if($this->timestamps){
      $columns[] = static::CREATED_AT;
      $columns[] = static::UPDATED_AT;
    }
    $columns = array_merge($columns, $this->appends);
    return $columns;
  }

  public function elaVisibleColumns(){

    $columns = $this->getTableColumns();
    $columns = array_merge($columns, $this->appends);
    if($this->visible) $visibleColumns = $this->visible;
    else $visibleColumns = array_diff($columns, $this->hidden??[]);
    return $visibleColumns;
  }

  public function elaActions(){
    return new \Onspli\Eladmin\Chainset\Chainset();
  }

  /**
  * List database entries.
  */
  public function elaActionGetRows(){
    $sort = $_POST['sort']??$this->primaryKey;
    $direction = $_POST['direction']??'asc';

    $rows = static::orderBy($sort, $direction)->get();
    foreach($rows as $row)
      $this->elaRenderRow($row);
  }

  protected function elaRenderRow($row){
    echo $this->view($this->bladeViewRow, ['row'=>$row]);
  }

  /**
  * Edit database entry.
  */
  public function elaActionPutRow(){

    $id = $_POST[$this->primaryKey]??null;
    $row = static::find($id);

    if(!$row)
      throw new \Exception('Entry not found!');

    $this->elaModifyPost();

    /**
    * TODO: some protection?
    */
    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());

    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }

    $row->save();
  }

  public function elaActionPostForm(){
    echo $this->view($this->bladeViewPostForm);
  }

  public function elaActionPutForm(){
    $id = $_POST[$this->primaryKey]??null;
    $row = static::find($id);
    if(!$row)
      throw new \Exception('Entry not found!');

    echo $this->view($this->bladeViewPutForm, ['row'=>$row]);
  }

  /**
  * Create database entry.
  */
  public function elaActionPostRow(){
    $row = new static();
    $this->elaModifyPost();
    /**
    * TODO: some protection?
    */
    $columns = $this->getTableColumns();
    $columns = array_diff($columns, $this->elaDisabledColumns());
    foreach($columns as $column){
      $value = $_POST[$column]??null;
      if($value === null || $column == $this->primaryKey) continue;
      $row->{$column} = $value;
    }
    $row->save();
  }

  /**
  * Delete database entry.
  */
  public function elaActionDelRow(){
    $id = $_POST[$this->primaryKey];
    $row = static::find($id);
    $row->delete();
  }


  /**
  * Here you can modify or validate $_POST variable before the data is stored to the database.
  */
  protected function elaModifyPost():void {

  }

}
