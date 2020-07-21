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
class Chainset implements \Iterator {

  // parent's
  private $position = null;
  private $first = null;
  private $last = null;
  private $children = [];

  final public function __isset($key){
    if($this->parent === null)
    {
      return isset($this->children[$key]);
    }
    return false;
  }

  final public function _cut_child($key)
  {
    $prev = $this->children[$key]->_get_prev();
    $next = $this->children[$key]->_get_next();
    if ($key == $this->last)
    {
      $this->last = $prev;
    }
    if ($key == $this->first)
    {
      $this->first = $next;
    }
    if ($prev !== null)
    {
      $this->children[$prev]->_set_next($next);
    }
    if ($next !== null)
    {
      $this->children[$next]->_set_prev($prev);
    }
  }

  final public function __unset($key){
    if($this->parent === null)
    {
      $this->_cut_child($key);
      unset($this->children[$key]);
    }
  }

  final public function __get($key){
    if($this->parent === null)
    {
      if (!isset($this->children[$key]))
      {
        if ($this->last === null)
        {
          // children empty
          $this->first = $key;
        }
        else{
          $this->children[$this->last]->_set_next($key);
        }
        $prev = $this->last;
        $this->last = $key;
        $this->children[$key] = new static;
        $this->children[$key]->_set_parent($this);
        $this->children[$key]->_set_key($key);
        $this->children[$key]->_set_prev($prev);
      }
      return $this->children[$key];
    }
    throw new \Exception('Property '.static::class.'::'.$key.' is not accessible.');
  }

  final public function _set_first($key){
    $this->first = $key;
  }

  final public function _get_first(){
    return $this->first;
  }

  final public function _set_last($key){
    $this->last = $key;
  }

  final public function _get_last(){
    return $this->last;
  }

  final public function current ()
  {
    return $this->children[$this->position];
  }

  final public function  key ()
  {
    return $this->position;
  }

  final public function  next () : void
  {
    if ($this->position !== null)
    {
      $this->position = $this->children[$this->position]->_get_next();
    }
  }

  final public function  rewind () : void
  {
    $this->position = $this->first;
  }

  final public  function valid () : bool
  {
    return $this->position !== null;
  }

  // child's
  private $parent = null;
  private $next = null;
  private $prev = null;
  private $key = null;

  final public function __call ( string $name , array $arguments ){
    if($this->parent !== null)
    {
      $this->$name = $arguments[0]??null;
      return $this;
    }
    throw new \Exception('Method '.static::class.'::'.$name.' is not accessible.');
  }

  final public function _set_key($key){
    $this->key = $key;
  }

  final public function _get_key(){
    return $this->key;
  }

  final public function _set_next($key){
    $this->next = $key;
  }

  final public function _get_next(){
    return $this->next;
  }

  final public function _set_prev($key){
    $this->prev = $key;
  }

  final public function _get_prev(){
    return $this->prev;
  }

  final public function _set_parent($obj){
    $this->parent = $obj;
  }

  final public function _get_parent(){
    return $this->parent;
  }

  final public function before($target=null)
  {
    if ($this->parent === null) throw new \Exception('Method '.static::class.'::before cannot be called by parent.');
    if ($target == $this->key) return;
    if ($target !== null && !isset($this->parent->$target)) throw new \Exception('Target '.$target.' doesn\'t exist.');
    $this->parent->_cut_child($this->key);

    $prev = null;
    if ($target === null)
    {
      $prev = $this->parent->_get_last();
      $this->parent->_set_last($this->key);
    }
    else
    {
      $prev = $this->parent->$target->_get_prev();
      $this->parent->$target->_set_prev($this->key);
    }
    if ($prev) $this->parent->$prev->_set_next($this->key);
    $this->next = $target;
    $this->prev = $prev;

    return $this;
  }

  final public function after($target=null)
  {
    if ($this->parent === null) throw new \Exception('Method '.static::class.'::after cannot be called by parent.');
    if ($target == $this->key) return;
    if ($target !== null && !isset($this->parent->$target)) throw new \Exception('Target '.$target.' doesn\'t exist.');
    $this->parent->_cut_child($this->key);

    $next = null;
    if ($target === null)
    {
      $next = $this->parent->_get_first();
      $this->parent->_set_first($this->key);
    }
    else
    {
      $next = $this->parent->$target->_get_next();
      $this->parent->$target->_set_next($this->key);
    }
    if ($next) $this->parent->$next->_set_prev($this->key);
    $this->prev = $target;
    $this->next = $next;

    return $this;
  }


}
