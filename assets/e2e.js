consecutive
.run("Jednicka", function(){
  console.log('First test.');
})
.run("Dvojka", function(){
  console.log('Second test.');
})
.wait("Cekej", 'wait1', function(data){
  consecutive.assert(data == 'ahoj', 'Pozdrav!');
  console.log('Wait for: '+data);
})
.run("Konec", function(){
  console.log('Final');
})
.continue();
