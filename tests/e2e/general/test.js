// init test - reset database
consecutive
.run("Are we on login page?", function(){
  consecutive.assert($("#loginform").length != 0);
})
.run("reset db", function(){
  $.get('?elatestinit=1').done(function(data){
    consecutive.point('db_reset', data);
  });
})
.wait("reset db check", 'db_reset', function(data){
  consecutive.assert(data == "reset");
})

// enter wrong credentials
.run("wrong credentials", function(){
  var form = $("#loginform");
  form[0].login.value = "eladmin";
  form[0].password.value = "wrong";
  form.submit();
})
.wait("wrong credentials check", 'login_fail', function(data){
  consecutive.assert(data == "Wrong credentials!");
})

// login
.run("login", function(){
  var form = $("#loginform");
  form[0].login.value = "eladmin";
  form[0].password.value = "nimdale";
  form.submit();
})
.wait("login check", 'login_ok')
.wait("login redirect", 'reload', function(){
  consecutive.assert($("#logout_button").length != 0);
})

// logout
.run("logout", function(){
  $("#logout_button")[0].click();
})
.wait("logout check", 'reload', function(){
  consecutive.assert($("#loginform").length != 0);
})

// clean up - reset db
.run("reset db", function(){
  $.get('?elatestinit=1').done(function(data){
    consecutive.point('db_reset', data);
  });
})
.wait("reset db check", 'db_reset', function(data){
  consecutive.assert(data == "reset");
})
.panel()
.continue();

consecutive.point('reload');
