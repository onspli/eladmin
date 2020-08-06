<?php
namespace Examples\Eloquent;
use \Illuminate\Database\Eloquent;

class Event extends Eloquent\Model {

  protected $dates = ['when'];

  function __construct() {
    parent::__construct();
    $schema = $this->getConnection()->getSchemaBuilder();
    if (!$schema->hasTable($this->getTable())) {

      $schema->create($this->getTable(), function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->datetime('when');
        $table->string('where');
        $table->integer('price');
        $table->text('description');
        $table->timestamps();
      });

    }
  }

}
