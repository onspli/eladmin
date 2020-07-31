<?php
namespace Onspli\Eladmin\Auth\EloquentUser;
use \Illuminate\Database\Eloquent;

class User extends Eloquent\Model {

protected $table = 'elausers';

public function __construct() {
  parent::__construct();
  if (!$this->getConnection()->getSchemaBuilder()->hasTable($this->getTable())) {
    $this->createTable();
  }
}

public function setPasswordhashAttribute($value){
  $this->attributes['passwordhash'] = password_hash($value, PASSWORD_DEFAULT);
}

protected function createTable(){
  $this->getConnection()->getSchemaBuilder()->create($this->getTable(), function ($table) {
    $table->increments('id');
    $table->string('login')->unique();
    $table->string('role');
    $table->timestamps();
    $table->string('passwordhash');
  });

  $firstUser = new static();
  $firstUser->login = 'eladmin';
  $firstUser->passwordhash = 'nimdale';
  $firstUser->role = 'admin';
  $firstUser->save();
}

}
