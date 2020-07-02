consecutive
.run("wrong credentials", function(){
  var form = $('#loginform');
  form[0].login.value = "eladmin";
  form[0].password.value = "wrong";
  form.submit();
})
.wait("wrong credentials message", 'loginfail', function(data){
  const ref = "Wrong credentials!";
  if (data != ref){
    console.error(data + ' != ' + ref)
    consecutive.fail();
  }
})
.run("login", function(){
  var form = $('#loginform');
  form[0].login.value = "eladmin";
  form[0].password.value = "nimdale";
  form.submit();
})
.wait("login ok", 'loginok')
.wait("redirect", 'layout')
.continue();
