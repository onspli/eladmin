<?php

namespace Onspli\Eladmin\Auth;


class User extends \Illuminate\Database\Eloquent\Model implements AuthInterface
{
  use Module\Eloquent\Crud {
    Module\Eloquent\Crud::elaActionDelete as ela_Parent_Crud_ActionDelete;
  }
  use \Illuminate\Database\Eloquent\SoftDeletes;

  protected $table = 'elausers';

  protected $elaTitle = 'Users';
  protected $elaIcon = '<i class="fas fa-users"></i>';
  public $elaRepresentativeColumn = 'login';

  protected $hidden = ['passwordhash'];

  protected $elaAuthorizedRoles = ['admin'];

  public function __construct(){
    parent::__construct();
    if(!$this->tableExists()) $this->createTable();
    $this->elaTitle = __('Users');
  }

  protected function createTable(){
    $this->getSchema()->create($this->getTable(), function ($table) {
            $table->increments('id');
            $table->string('login')->unique();
            $table->string('role');
            $table->timestamps();
            $table->string('passwordhash');
            $table->softDeletes();
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
      'login' => ['label'=>__('Login'), 'type'=>'text'],
      'password' => ['label'=>__('Password'), 'type'=>'password']
    ];
  }

  public function elaColumns(){
    $cols = $this->elaColumnsDef();
    $cols->newpassword->label(__('New password'))->nonlistable()->editable();
    $cols->login->validate(function($login, $row){
      if(!$login)
        throw new Exception\BadRequestException(__('Login must not be empty!'));
      $duplicatelogin = static::where('login',$login)->withTrashed()->first();
      if($duplicatelogin && $duplicatelogin->id != $row->id)
        throw new Exception\BadRequestException(__('Login already exists!'));
    });
    $cols->newpassword->validate(function($newpassword, $row){
      $newpassword = $_POST['newpassword']??null;
      if(!$row->id && !$newpassword)
        throw new Exception\BadRequestException(__('New password must not be empty!'));
      if($newpassword)
        $_POST['passwordhash'] = $newpassword;
    });

    return $cols;
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

  public function elaAuthorize(?array $authorizedRoles=null):bool{
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

  public function elaUserName():string{
    return $this->get()->login??'';
  }

  public function elaUserId(){
    return $this->get()->id??null;
  }

  public function elaAccountFields(): ?array{
    return [
      'oldpassword' => ['label'=>__('Current password'), 'type'=>'password'],
      'newpassword' => ['label'=>__('New password'), 'type'=>'password'],
      'newpasswordconfirm' => ['label'=>__('Confirm new password'), 'type'=>'password']
    ];
  }

  public function elaActionDelete(){
    if(($_POST[$this->getKeyName()]??null) == $this->elaUserId())
      throw new Exception\UnauthorizedException( __('You cannot delete yourself!'));
    $this->ela_Parent_Crud_ActionDelete();
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
      throw new Exception\UnauthorizedException();
    if(!password_verify($oldpassword , $user->passwordhash))
      throw new Exception\UnauthorizedException(__('Current password is not correct!'));
    if(!$newpassword)
      throw new Exception\BadRequestException(__('New password must not be empty!'));
    if($newpassword != $newpasswordconfirm)
      throw new Exception\BadRequestException(__('Passwords do not match!'));
    $user->passwordhash = $newpassword;
    $user->save();
  }

}