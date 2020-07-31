<?php

namespace Onspli\Eladmin\Auth\EloquentUser;
use \Onspli\Eladmin;

class Module extends Eladmin\Modules\Eloquent\Crud implements Eladmin\IAuth {

protected $model = User::class;
protected $title = 'Users';
protected $icon = '<i class="fas fa-users"></i>';
protected $roles = ['admin'];

/**
* List of possible roles in format [<role> => <role description>, ...].
* If set to null text input will edit role instead of select.
*/
protected $possibleRoles = null;

public function title() : string {
  return $this->title ?? __('Users');
}

public function loginFields() : ?array {
  return [
    'login' => ['label'=>__('Login'), 'type'=>'text'],
    'password' => ['label'=>__('Password'), 'type'=>'password']
  ];
}

public function unauthorized() : void {

}

public function user() {
  $user = $this->model()->find($_SESSION['elauser'] ?? 0);
  return $user;
}

public function login($fields) : void {
  $login = $fields['login'];
  $password = $fields['password'];

  $user = $this->model()->where('login', $login)->first();
  if($user && password_verify($password , $user->passwordhash)){
    $_SESSION['elauser'] = $user->id;
    return;
  }
  $this->logout();
}

public function logout() : void {
  $_SESSION['elauser'] = null;
}

public function authorize(array $authorizedRoles = self::ANYONE) : bool {
  $user = $this->user();
  if(!$user){
    $this->logout();
    return false;
  }
  if ($authorizedRoles == self::ANYONE)
    return true;
  if (in_array($user->role, $authorizedRoles))
    return true;
  return false;
}

public function accountUpdate($fields) : void {
  $oldpassword = $fields['oldpassword'];
  $newpassword = $fields['newpassword'];
  $newpasswordconfirm = $fields['newpasswordconfirm'];
  $user = static::user();
  if(!$user)
    throw new Eladmin\Exception\BadRequestException();
  if(!password_verify($oldpassword , $user->passwordhash))
    throw new Eladmin\Exception\BadRequestException(__('Current password is not correct!'));
  if(!$newpassword)
    throw new Eladmin\Exception\BadRequestException(__('New password must not be empty!'));
  if($newpassword != $newpasswordconfirm)
    throw new Eladmin\Exception\BadRequestException(__('Passwords do not match!'));
  $user->passwordhash = $newpassword;
  $user->save();
  $this->renderText(__('Password changed.'));
}

public function userName() : string {
  return static::user()->login ?? '';
}

public function accountFields() : ?array {
  return [
    'oldpassword' => ['label'=>__('Current password'), 'type'=>'password', 'desc'=>__('You have to authorize the change with your current password.')],
    'newpassword' => ['label'=>__('New password'), 'type'=>'password'],
    'newpasswordconfirm' => ['label'=>__('Confirm new password'), 'type'=>'password']
  ];
}

protected function crudActions() {
  $actions = parent::crudActions();

  // default actions are not protected with password.
  // disable default deletes and create new action
  unset($actions->delete);
  $actions->authorizedDelete->style('danger')->label(__('Delete'))
      ->icon('<i class="fas fa-trash-alt"></i>')->title(__('Delete'))->confirm()->nonlistable()
      ->done('modalClose();');

  return $actions;
}

protected function crudColumns() {
  $cols = parent::crudColumns();
  $cols->newpassword->label(__('New password'))->nonlistable()->editable()->password();
  $cols->newpasswordconfirm->label(__('Confirm new password'))->nonlistable()->editable()->password();
  $cols->passwordhash->hidden()->disabled();
  $cols->updated_at->label(__('Updated'))->nonlistable();
  $cols->created_at->label(__('Created'));
  $cols->login->label(__('Login'));
  $cols->role->label(__('Role'));
  $cols->authpassword->label('Password')->desc(__('You have to authorize the change with your current password.'))->nonlistable()->password();

  if ($this->possibleRoles !== null) {
    $cols->role->select($this->possibleRoles);
  }

  $cols->authpassword->validate(function($password){
    if (!password_verify($password, $this->user()->passwordhash)) {
      throw new Eladmin\Exception\BadRequestException(__('Current password is not correct!'));
    }
  });

  $cols->login->validate(function($login) {
    if (!$login) {
      throw new Eladmin\Exception\BadRequestException(__('Login must not be empty!'));
    }
    $duplicatelogin = $this->model()->where('login', $login)->first();
    if ($duplicatelogin && $duplicatelogin->id != $this->id(false)) {
      throw new Eladmin\Exception\BadRequestException(__('Login already exists!'));
    }
  });

  $cols->newpassword->validate(function($newpassword) {
    if (!$this->id(false) && !$newpassword) {
      throw new Eladmin\Exception\BadRequestException(__('New password must not be empty!'));
    }
  });
  $cols->newpasswordconfirm->validate(function($newpasswordconfirm, $row) {
    if ($newpasswordconfirm != $row['newpassword']) {
      throw new Eladmin\Exception\BadRequestException(__('Passwords do not match!'));
    }
  });
  $cols->passwordhash->set(function($ph, $row) {
    if ($row['newpassword']) {
      return $row['newpassword'];
    }
    return null;
  });
  return $cols;
}

public function actionAuthorizedDelete(){
  if($this->id() == $this->user()->id)
    throw new Eladmin\Exception\BadRequestException( __('You cannot delete yourself!'));
  parent::actionDelete();
}

public function actionDelete(){
  // we cannot protect this action with password, disable it
  throw new Eladmin\Exception\UnauthorizedException();
  if($this->id() == $this->user()->id)
    throw new Eladmin\Exception\BadRequestException( __('You cannot delete yourself!'));
  parent::actionDelete();
}


}
