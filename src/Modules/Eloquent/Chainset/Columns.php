<?php
namespace Onspli\Eladmin\Modules\Eloquent\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Columns extends Eladmin\Modules\Crud\Chainset\Columns {

protected $childClass = Column::class;

}
