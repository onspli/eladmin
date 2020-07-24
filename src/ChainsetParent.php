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
class ChainsetParent implements \Iterator {

protected $childClass = ChainsetChild::class;

private $position = null;
private $first = null;
private $last = null;
private $children = [];

function __construct($childClass = null) {
  if ($childClass !== null) {
    $this->childClass = $childClass;
  }
}

final public function __isset($key) {
  return isset($this->children[$key]);
}

/**
* Remove child from linked list.
*/
final public function cutChild(string $key) : void {
  $prev = $this->children[$key]->_getPrev();
  $next = $this->children[$key]->_getNext();
  if ($key == $this->last) {
    $this->last = $prev;
  }
  if ($key == $this->first) {
    $this->first = $next;
  }
  if ($prev !== null) {
    $this->children[$prev]->_setNext($next);
  }
  if ($next !== null) {
    $this->children[$next]->_setPrev($prev);
  }
}

final public function __unset($key) {
  if (!isset($this->children[$key]))
    return;
  $this->cutChild($key);
  unset($this->children[$key]);
}

final public function __get($key) {
  if (!isset($this->children[$key])) {
    if ($this->last === null) {
      // children empty
      $this->first = $key;
    } else {
      $this->children[$this->last]->_setNext($key);
    }
    $prev = $this->last;
    $this->last = $key;
    $this->children[$key] = new $this->childClass;
    $this->children[$key]->_setParent($this);
    $this->children[$key]->_setKey($key);
    $this->children[$key]->_setPrev($prev);
  }
  return $this->children[$key];
}

final public function setFirst(?string $key) : void {
  $this->first = $key;
}

final public function getFirst() : ?string {
  return $this->first;
}

final public function setLast(?string $key) : void {
  $this->last = $key;
}

final public function getLast() : ?string {
  return $this->last;
}

final public function current() {
  return $this->children[$this->position];
}

final public function key() {
  return $this->position;
}

final public function next() : void {
  if ($this->position !== null) {
    $this->position = $this->children[$this->position]->_getNext();
  }
}

final public function rewind() : void {
  $this->position = $this->first;
}

final public function valid() : bool {
  return $this->position !== null;
}

}
