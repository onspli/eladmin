consecutive
.run("reset db", function(){
  $.ajax({
    url: '.',
    method: 'GET',
    data: 'elatestinit=1'
  }).done(function(){
    consecutive.point('resetdb');
  });
})
.wait("reset db done", 'resetdb')
.continue();
