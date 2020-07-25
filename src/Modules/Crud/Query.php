<?php
namespace Onspli\Eladmin\Modules\Crud;

class Query {

/**
* ascending direction for sorting
*/
const ASC = 'asc';

/**
* descending direction for sorting
*/
const DESC = 'desc';

/**
* infinite number of results
*/
const INFINITY = 0;

/**
* Column name for sorting, null for primary key
*/
public $sortBy = null;

/**
* Sorting direction
*/
public $direction = self::DESC;

/**
* Page number of results, starting with 1
*/
public $page = 1;

/**
* How many results per one page
*/
public $resultsPerPage = 10;

/**
* search string
*/
public $search = null;

/**
* Query rows from trash.
*/
public $trash = false;

public function fill(array $q) : void {
  if (isset($q['sort']))
    $this->sortBy = $q['sort'] ?? null;
  if (isset($q['direction']))
    $this->direction = ($_POST['direction'] == self::ASC) ? self::ASC : self::DESC;
  if (isset($q['page']))
    $this->page = $q['page'];
  if (isset($q['resultsperpage']))
    $this->resultsPerPage = $q['resultsperpage'];
  if (isset($q['search']))
    $this->search = $q['search'];
  if (isset($q['trash']))
    $this->trash = $q['trash'] ? true : false;
}

}
