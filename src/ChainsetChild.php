<?php

namespace Onspli\Eladmin;

/**
* Chainset object is funny method to configure things.
* Chainset has one parent and many children.
* We can crate and access children just like they were properties
* of parent. We can set properties of children using function-call syntax.
*
* Example:
* ```
* // create chainset with parent 'columns', child 'name' with
* // properties value = 'Ondrej' and bg = '#555', and
* // child 'modified' with property timestamp = 'now'
* $columns = new Chainset;
* $columns->name->value('Ondrej')->bg('#555');
* $columns->modified->timestamp('now');
* ```
*/
class ChainsetChild {

private $parent = null;
private $next = null;
private $prev = null;
private $key = null;

final public function __call(string $name , array $arguments) {
  $this->$name = $arguments[0] ?? null;
  return $this;
}

final public function _setKey($key) {
  $this->key = $key;
}

final public function _getKey(){
  return $this->key;
}

final public function _setNext($key){
  $this->next = $key;
}

final public function _getNext(){
  return $this->next;
}

final public function _setPrev($key){
  $this->prev = $key;
}

final public function _getPrev(){
  return $this->prev;
}

final public function _setParent($obj){
  $this->parent = $obj;
}

final public function _getParent(){
  return $this->parent;
}

final public function before($target = null) {
  if ($target == $this->key)
    return;
  if ($target !== null && !isset($this->parent->$target))
    throw new \Exception('Target '.$target.' doesn\'t exist.');
  $this->parent->cutChild($this->key);

  $prev = null;
  if ($target === null) {
    $prev = $this->parent->getLast();
    $this->parent->setLast($this->key);
  } else {
    $prev = $this->parent->$target->_getPrev();
    $this->parent->$target->_setPrev($this->key);
  }
  if ($prev)
    $this->parent->$prev->_setNext($this->key);
  $this->next = $target;
  $this->prev = $prev;

  return $this;
}

final public function after($target = null) {
  if ($target == $this->key)
    return;
  if ($target !== null && !isset($this->parent->$target))
    throw new \Exception('Target '.$target.' doesn\'t exist.');
  $this->parent->cutChild($this->key);

  $next = null;
  if ($target === null) {
    $next = $this->parent->getFirst();
    $this->parent->setFirst($this->key);
  } else {
    $next = $this->parent->$target->_getNext();
    $this->parent->$target->_setNext($this->key);
  }
  if ($next)
    $this->parent->$next->_setPrev($this->key);
  $this->prev = $target;
  $this->next = $next;

  return $this;
}


}
