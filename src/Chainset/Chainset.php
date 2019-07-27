<?php

namespace Onspli\Eladmin\Chainset;

/**
* $cs = new Chainset;
* $cs->prop1('val1')->prop2('val2')->prop3('val3');
* echo($cs->prop1);     // "val1"
* echo($cs->prop3);     // "val3"
*/

/**
* $cs = new Chainset;
* $cs->word1->val('Hello');
* $cs->word2->val('!');
* $cs->word3->val('world')->before('word2');
* foreach($cs as $word) echo $word->val." ";
* // OUTPUT: "Hello world !"
*/

class Chainset{

  protected $_key;
  protected $_parent;

  function __construct($empty=false){
    if($empty) $this->_empty();
  }

  public function __call ( string $name , array $arguments ){
    $this->$name = $arguments[0]??null;
    return $this;
  }

  public function __isset($key){
    return false;
  }

  public function __get($key){
    $this->$key = new static;
    $this->$key->_parent($this);
    $this->$key->_key($key);
    return $this->$key;
  }

  public function __set($key, $val){
    $this->$key = $val;
    if($val instanceof self){
      $this->$key->_parent($this);
      $this->$key->_key($key);
    }
  }

  public function _key($key){
    $this->_key = $key;
  }

  public function _parent($obj){
    $this->_parent = $obj;
  }

  public function before($target=null){
    ($this->_parent)->_key($this->_key);
    ($this->_parent)->__before($target);
    return $this;
  }

  public function after($target=null){
    ($this->_parent)->_key($this->_key);
    ($this->_parent)->__after($target);
    return $this;
  }

  public function _empty(){
    foreach($this as $key=>$val){
      if($key == '_key' || $key == '_parent') continue;
      unset($this->$key);
    }
  }

  public function __after($target=null){
    $copy = clone $this;
    $move = $this->_key;

    foreach($copy as $key=>$val){
      if($key == '_key' || $key == '_parent') continue;
      unset($this->$key);
    }

    if($target == null || !isset($copy->$target)) $this->$move = $copy->$move;
    foreach($copy as $key=>$val){
      if($key == '_key' || $key == '_parent') continue;
      if($key != $move) $this->$key = $val;
      if($key == $target) $this->$move = $copy->$move;
    }
  }

  public function __before($target=null){
    $copy = clone $this;
    $move = $this->_key;

    foreach($copy as $key=>$val){
      if($key == '_key' || $key == '_parent') continue;
      unset($this->$key);
    }

    foreach($copy as $key=>$val){
      if($key == '_key' || $key == '_parent') continue;
      if($key == $target) $this->$move = $copy->$move;
      if($key != $move) $this->$key = $val;
    }
    if($target == null || !isset($copy->$target)) $this->$move = $copy->$move;
  }
}
