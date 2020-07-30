<?php
namespace Examples\Eloquent;
use \Illuminate\Database\Eloquent;

class Registration extends Eloquent\Model {

function __construct() {
  $schema = $this->getConnection()->getSchemaBuilder();
  if (!$schema->hasTable($this->getTable())) {

    $schema->create($this->getTable(), function ($table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('event_id')->unsigned();
      $table->string('email');
      $table->string('status');
      $table->timestamps();
    });

  }
}

}
