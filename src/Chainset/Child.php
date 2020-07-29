<?php

namespace Onspli\Eladmin\Chainset;

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
class Child {

private $parent = null;
private $next = null;
private $prev = null;
private $key = null;

 public function __call(string $name , array $arguments) {
  $this->$name = $arguments[0] ?? null;
  return $this;
}

 public function _setKey(string $key) : void {
  $this->key = $key;
}

 public function _getKey() : string {
  return $this->key;
}

 public function _setNext(?string $key) : void {
  $this->next = $key;
}

 public function _getNext() : ?string {
  return $this->next;
}

 public function _setPrev(?string $key) : void {
  $this->prev = $key;
}

 public function _getPrev() : ?string {
  return $this->prev;
}

 public function _setParent(Chainset $obj) : void {
  $this->parent = $obj;
}

 public function _getParent() : Chainset {
  return $this->parent;
}

/**
* Place child just before $target.
*/
 public function before(?string $target = null) : Child {
  if ($target == $this->key)
    return $this;
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

/**
* Place child just after $target.
*/
 public function after(?string $target = null) : Child {
  if ($target == $this->key)
    return $this;
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
