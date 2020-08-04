<?php
namespace Onspli\Eladmin\Modules\Eloquent\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Column extends Eladmin\Modules\Crud\Chainset\Column {

public function datetime($format, $allowNull = false) {
  $this->get(function($val, $row) use($format) {
    $carbon = \Carbon\Carbon::parse($val);
    if (!$carbon)
      return null;
    return $carbon->format($format);
  });
  $this->format(function($val, $row) use($format) {
    $carbon = \Carbon\Carbon::parse($val);
    if (!$carbon)
      return null;
    return $carbon->format($format);
  });
  $this->set(function($val) use($format, $allowNull) {
    if (!$val){
      if ($allowNull)
        return null;
      else
        throw new Exception\BadRequestException(__('Date or time cannot be empty.'));
    }
    try {
      return \Carbon\Carbon::createFromFormat($format, $val);
    } catch(\Throwable $e) {
      throw new Exception\BadRequestException(__('Date or time format is not valid.'));
    } catch(\Exception $e) {
      throw new Exception\BadRequestException(__('Date or time format is not valid.'));
    }
  });
  return $this;
}

}
