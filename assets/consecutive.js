/**
* consecutive.js - minimalistic web end2end testing framework
* MIT licence
* author: Ondrej Splichal, ondrej.splichal@gmail.com
*/

var consecutive = {

state : -2,
queue : [],
hasfailed : false,
timeout : null,

get_state : function(){
  if (this.state != -2){
    return this.state;
  }
  var cookie = document.cookie.split('; ').find(row => row.startsWith('_consecutive='));
  if (!cookie){
    return this.state;
  }
  this.state = parseInt(cookie.split('=')[1]);
  return this.state;
},

set_state : function(state){
  this.state = state;
  document.cookie = '_consecutive='+state;
},

is_running : function(){
  return this.get_state() >= 0;
},

run : function(label, callback){
  this.wait(label, null, callback);
  return this;
},

wait : function(label, name, callback){
  this.queue.push({label:label, callback:callback, name:name});
  return this;
},

point : function(name, data){
  if (!this.is_running()) return;
  var next_state = this.get_state();
  var next = this.queue[next_state];
  if (next.name !== name){
    return;
  }
  clearTimeout(this.timeout);
  if (next.callback !== undefined){
    next.callback(data);
  }
  this.set_state(this.get_state() + 1);
  this.continue();
},

start : function(){
  if (this.is_running()){
    alert('Test already running.');
    return;
  }
  this.set_state(0);
  this.continue();
},

stop : function(){
  if (this.timeout) clearTimeout(this.timeout);
  this.set_state(-2);
},

continue : function(){
  while(this.is_running()){
    var next_state = this.get_state();
    if (next_state >= this.queue.length){
      this.success();
      return;
    }
    var next = this.queue[next_state];
    if (next.name !== null){
      // wait for point
      this.timeout = setTimeout(this.fail.bind(this), 10000);
      return;
    }
    next.callback();
    this.set_state(this.get_state() + 1);
  }
},

assert : function(value, message){
  if (value) return true;
  if (message) console.error(message);
  this.fail();
  return false;
},

fail : function(){
  alert('Test failed.');
  this.hasfailed = true;
  this.log();
  this.stop();
},

success : function(){
  alert('Test succeeded.');
  this.hasfailed = false;
  this.log();
  this.stop();
},

log : function(){
  var max_state = this.get_state();
  if (max_state < 0){
      console.debug('Empty log.');
      return;
  }
  for (var state = 0; state < max_state; state++){
    const runner = this.queue[state];
    console.log(runner.label + '... OK');
  }
  const msg = max_state + ' out of ' + this.queue.length + ' tests passed';
  if (this.hasfailed){
    const next_runner = this.queue[max_state];
    console.log(next_runner.label + '... Failed');
    console.log(msg);
  } else if (max_state >= this.queue.length){
    console.log(msg);
  } else {
    const next_runner = this.queue[max_state];
    console.log(next_runner.label + '... Running');
    console.log(msg + ' so far');
  }
}



};
