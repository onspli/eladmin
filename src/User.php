<?php

namespace Onspli\Eladmin;


class User extends Eloquent\Model implements Iface\Authorization
{

  protected $table = 'elausers';
  protected $hidden = ['passwordhash'];

  protected $elaTitle = 'Eladmin Users';
  protected $elaFasIcon = 'fas fa-users';

  public function __construct(){
    if(!$this->tableExists())
      $this->createTable();

    if(!session_id()) session_start();
  }

  protected function createTable(){
    $this->getSchema()->create($this->getTable(), function ($table) {
            $table->bigIncrements('id');
            $table->string('login')->unique();;
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

  public function setPasswordhashAttribute($value){
    $this->attributes['passwordhash'] = password_hash($value, PASSWORD_DEFAULT);
  }

  public function elaLoginFields(): ?array{
    return [
      'login' => ['label'=>'Login', 'type'=>'text'],
      'password' => ['label'=>'Password', 'type'=>'password']
    ];
  }

  public function elaExtraInputs(): array{
    return [
      'password' => ['label'=>'Nové heslo', 'type'=>'text']
    ];
  }

  protected function elaModifyPost(): void{
    $newpassword = $_POST['password']??null;
    if($newpassword)
      $_POST['passwordhash'] = $newpassword;
  }

  public function elaLogin():void {
    $login = $_POST['login']??'';
    $password = $_POST['password']??'';

    $user = static::where('login', $login)->first();
    if($user && password_verify($password , $user->passwordhash)){
      $_SESSION['elauser'] = $user->id;
      return;
    }
    $this->elaLogout();
  }

  public function elaLogout():void{
    $_SESSION['elauser'] = null;
  }

  public function elaAuth(?array $authorizedRoles=null):bool{
    $user = static::get();
    if(!$user){
      $this->elaLogout();
      return false;
    }
    if(!$authorizedRoles) return true;
    if($authorizedRoles && in_array($user->role, $authorizedRoles)) return true;
    return false;
  }

  public static function get(){
    $user = static::find($_SESSION['elauser']??0);
    return $user;
  }

  public function elaAccountFields(): ?array{
    return [
      'oldpassword' => ['label'=>'Současné heslo', 'type'=>'password'],
      'newpassword' => ['label'=>'Nové heslo', 'type'=>'password'],
      'newpasswordconfirm' => ['label'=>'Potvrď nové heslo', 'type'=>'password']
    ];
  }



  /**
  * Eladmin calls this method during profile update. Login Fields are passed through POST variable
  */
  public function elaAccount():void{
    $oldpassword = $_POST['oldpassword']??'';
    $newpassword = $_POST['newpassword']??'';
    $newpasswordconfirm = $_POST['newpasswordconfirm']??'';
    $user = static::get();
    if(!$user)
      throw new \Exception('Unathorized!');
    if(!password_verify($oldpassword , $user->passwordhash))
      throw new \Exception('Současné heslo není správně!');
    if(!$newpassword)
      throw new \Exception('Nové heslo nesmí být prázdné!');
    if($newpassword != $newpasswordconfirm)
      throw new \Exception('Hesla se neshodují!');
    $user->passwordhash = $newpassword;
    $user->save();
  }

}
