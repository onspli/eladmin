function _testEladminLogin(){
  var form = $("#loginform");
  form[0].login.value = "eladmin";
  form[0].password.value = "nimdale";
  form.submit();
}

function _testLogout(){
  $("#logout_button")[0].click();
}

function _testAjaxLogout(){
  $.get('?elalogout=true').always(function(){
    consecutive.point('ajax_logout');
  });
}

function _testLoggedIn(){
  consecutive.assert($("#logout_button").length != 0);
}

function _testLoginForm(){
  consecutive.assert($("#loginform").length != 0);
}

function _testResetDb(){
  $.get('?elatestinit=1').done(function(data){
    consecutive.point('db_reset', data);
  });
}

function _testDbWasReset(data){
  consecutive.assert(data == "reset");
}

function _testOpenAccountForm(){
  consecutive.assert($("#elaeditaccount").length != 0);
  $("#elaeditaccount")[0].click();
}

function _testAccountFormIsOpen(){
  consecutive.assert($("form[elaaction=account]").length != 0);
}

function _testModalIsOpen(){
  consecutive.assert($("#dynamic>div.modal.show").length != 0);
}

function _testModalIsClosed(){
  consecutive.assert($("#dynamic>div.modal.show").length == 0);
}

function _testCloseModalButton(){
  $("#dynamic>div.modal.show button.close[data-dismiss=modal]")[0].click();
}

function _testCloseModalBack(){
  window.history.back();
}

// init test - reset database
consecutive
.run("### INIT TEST ###")
.run("refresh and go to login page", function(){
  document.location = '?elalogout=true';
})
.wait("are we on login page?", 'reload', _testLoginForm)
.run("reset db", _testResetDb)
.wait("reset db check", 'db_reset', _testDbWasReset)

// enter wrong credentials
.run("### TEST LOGIN FORM ###")
.run("login with wrong credentials", function(){
  var form = $("#loginform");
  form[0].login.value = "eladmin";
  form[0].password.value = "wrong";
  form.submit();
})
.wait("check wrong credentials message", 'login_fail', function(data){
  consecutive.assert(data == "Wrong credentials!");
})

// login
.run("login with correct credentials", _testEladminLogin)
.wait("wait for ajax login", 'login_ok')
.wait("wait for login redirect", 'reload', _testLoggedIn)

// logout
.run("### TEST LOGOUT ###")
.run("logout with button", _testLogout)
.wait("wait for logout redirect", 'reload', _testLoginForm)
.run("login", _testEladminLogin)
.wait("wait for login redirect", 'reload', _testLoggedIn)

// auth expired
.run("### TEST AUTH EXPIRED ###")
.run("simulate login expired with ajax logout", _testAjaxLogout)
.wait("wait for ajax logout", 'ajax_logout')
.run("open account modal should redirect to login", _testOpenAccountForm)
.wait("wait for redirect to login page", 'reload', _testLoginForm)
.run("login", _testEladminLogin)
.wait("wait for login redirect", 'reload', _testLoggedIn)

// open - close modal
.run("### TEST MODAL OPEN/CLOSE ###")
.run("open account modal", _testOpenAccountForm)
.wait("wait for account modal", 'action_ok', _testModalIsOpen)
.run("close modal button", _testCloseModalButton)
.run("account modal is closed", _testModalIsClosed)

.run("open account modal", _testOpenAccountForm)
.wait("wait for account modal", 'action_ok', _testModalIsOpen)
.run("close modal history back", _testCloseModalBack)
.wait("wait for popstate event", 'popstate')
.run("account modal is closed", _testModalIsClosed)

// test users crud
.run("### TEST USERS CRUD")
.run("go to users crud", function(){
  var menu = $("#modules-menu a");
  consecutive.assert(menu.length == 3);
  menu[2].click();
})
.wait("wait for redirect to users crud", 'reload', function(){
  var title = $(".card-header h2");
  consecutive.assert(title.html() == '<i class="fas fa-users"></i> Users');
})
.wait("check crud table", 'crud_read', function(){
  var table = $("#crud-table");
  consecutive.assert(table.length != 0, "CRUD table doesn't exist.");
  var rowcells = table.find('tbody tr').first().find('td');
  consecutive.assert(rowcells.eq(0).html() == '1' && rowcells.eq(1).html() == 'eladmin' && rowcells.eq(2).html() == 'admin');
})
.run("open add modal", function(){
  $("#crudadd").click();
})
.wait("wait for add modal to open", 'action_ok', _testModalIsOpen)
.run("test disabled inputs", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  consecutive.assert(inputs.eq(0).attr("disabled") == "disabled", "ID input should be disabled");
})
.run("create user with empty login", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  form.submit();
})
.wait("wait for empty login message", 'form_fail', function(data){
  consecutive.assert(data.responseText == "Login must not be empty!");
})
.run("create user with duplicate login", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  inputs.eq(1).val('eladmin');
  form.submit();
})
.wait("wait for duplicate login message", 'form_fail', function(data){
  consecutive.assert(data.responseText == "Login already exists!");
})
.run("create user with empty password", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  inputs.eq(1).val('user');
  form.submit();
})
.wait("wait for empty password message", 'form_fail', function(data){
  consecutive.assert(data.responseText == "New password must not be empty!");
})

.run("create user", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  inputs.eq(1).val('user');
  inputs.eq(2).val('group');
  inputs.eq(5).val('password');
  form.submit();
})
.wait("wait for creation", 'form_ok', function(data){
  consecutive.assert(data == "Entry added.");
  _testModalIsClosed();
})
.wait("wait for table reload", 'crud_read', function(data){
  var table = $("#crud-table");
  var rowcells = table.find('tbody tr').first().find('td');
  consecutive.assert(rowcells.eq(0).html() == '2' && rowcells.eq(1).html() == 'user' && rowcells.eq(2).html() == 'group');
})

.run("edit user", function(){
  $("button[data-elaid=2]").first().click();
})
.wait("wait for edit modal to open", 'action_ok', _testModalIsOpen)
.run("set empty login", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  inputs.eq(1).val('');
  form.submit();
})
.wait("wait for empty login message", 'form_fail', function(data){
  consecutive.assert(data.responseText == "Login must not be empty!");
})
.run("set duplicate login", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  inputs.eq(1).val('eladmin');
  form.submit();
})
.wait("wait for duplicate login message", 'form_fail', function(data){
  consecutive.assert(data.responseText == "Login already exists!");
})
.run("edit user", function(){
  var form = $("#modal-form");
  var inputs = form.find("input");
  inputs.eq(1).val('user');
  inputs.eq(2).val('user');
  form.submit();
})
.wait("wait for modification", 'form_ok', function(data){
  consecutive.assert(data == "Entry modified.");
  _testModalIsClosed();
})
.wait("wait for table reload", 'crud_read', function(data){
  var table = $("#crud-table");
  var rowcells = table.find('tbody tr').first().find('td');
  consecutive.assert(rowcells.eq(0).html() == '2' && rowcells.eq(1).html() == 'user' && rowcells.eq(2).html() == 'user');
})

.run("### LOGIN AS USER ###")
.run("logout", _testLogout)
.wait("logout check", 'reload', _testLoginForm)
.run("login as user", function(){
  var form = $("#loginform");
  form[0].login.value = "user";
  form[0].password.value = "password";
  form.submit();
})
.wait("wait for ajax login", 'login_ok')
.wait("wait for login redirect", 'reload', _testLoggedIn)
.run("check authorized modules", function(){
  var menu = $("#modules-menu a");
  consecutive.assert(menu.length == 2);
})


// logout
.run("### CLEANUP ###")
.run("logout", _testLogout)
.wait("logout check", 'reload', _testLoginForm)

// clean up - reset db
.run("reset db", _testResetDb)
.wait("reset db check", 'db_reset', _testDbWasReset)

// start consecutive
.panel()
.continue();

window.addEventListener("load", function(){ consecutive.point('reload'); });
