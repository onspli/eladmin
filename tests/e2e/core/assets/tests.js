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

// logout
.run("### CLEANUP ###")
.run("logout", _testLogout)
.wait("logout check", 'reload', _testLoginForm)

// start consecutive
.panel()
.continue();

window.addEventListener("load", function(){ consecutive.point('reload'); });
