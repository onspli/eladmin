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
has_panel : false,
paused : false,

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
  if(!this.paused) this._set_panel_status('Running...');
  clearTimeout(this.timeout);
  if (next.callback !== undefined){
    var f = next.callback.bind(this);
    try{
      f(data);
    } catch(err){
      this.fail();
      throw err;
    }
  }
  this._mark_passed_test(next_state);
  this.set_state(this.get_state() + 1);
  if(!this.paused) this.continue();
},

start : function(){
  if (this.is_running()){
    alert('Test already running.');
    return;
  }
  this.set_state(0);
  this.paused = false;
  this._reset_panel();
  this.continue();
},

stop : function(){
  if (this.timeout) clearTimeout(this.timeout);
  this.set_state(-2);
  this.paused = false;
  this._update_panel_control();
  consecutive._set_panel_status('Stopped');
},

pause : function(){
  this.paused = true;
  consecutive._set_panel_status('Paused');
  this._update_panel_control();
},

continue : function(){
  if (this.paused){
    this.paused = false;

    this._update_panel_control();
  }
  while(this.is_running()){
    if (this.paused) return;
    this._set_panel_status('Running...');
    var next_state = this.get_state();
    if (next_state >= this.queue.length){
      this.success();
      return;
    }
    var next = this.queue[next_state];
    if (next.name !== null){
      // wait for point
      this._set_panel_status('Waiting...');
      this.timeout = setTimeout(this.fail.bind(this), 10000);
      return;
    }
    var f = next.callback.bind(this);
    try{
      f();
    } catch(err){
      this.fail();
      throw err;
    }
    this._mark_passed_test(next_state);
    this.set_state(this.get_state() + 1);
  }
},

assert : function(value, message){
  if (!value){
    throw message ? message : "assertion failed";
  }
},

fail : function(){
  if (!this.has_panel) alert('Test failed.');
  this.hasfailed = true;
  this._mark_failed_test(this.get_state());
  var max_state = this.get_state();
  this.log();
  this.stop();
  this._set_panel_status('<span style="color: #ff0000;font-weight: bold;">&#10008; Test failed.</span> '+max_state + ' out of ' + this.queue.length + ' tests passed');
},

success : function(){
  if (!this.has_panel) alert('Test succeeded.');
  this.hasfailed = false;
  this.log();
  this.stop();
  this._set_panel_status('<span style="color: #008000;font-weight: bold;">&#10004; Test succeeded.</span> '+this.queue.length+' out of '+this.queue.length + ' tests passed');
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
},

_set_panel_control : function(code, label){
  if (!this.has_panel) return;
  var control = document.getElementById('consecutivejs_control');
  control.href = 'javascript:' + code;
  control.innerHTML = label;
},

_update_panel_control : function(){
  if (this.is_running()){
    if (this.paused){
      this._set_panel_control('consecutive.continue();', 'Continue');
    }
    else{
      this._set_panel_control('consecutive.pause();', 'Pause');
    }
  }
  else{
    this._set_panel_control('consecutive.start();', 'Start');
  }
},

_set_panel_status : function(msg){
  if (!this.has_panel) return;
  var status = document.getElementById('consecutivejs_status');
  status.innerHTML = msg;
},

_mark_passed_test : function(state){
  if (!this.has_panel) return;
  var tests = document.getElementById('consecutivejs_tests').getElementsByTagName("div");
  var mark = tests[state].getElementsByTagName("span")[0];
  mark.innerHTML = '&#10004;';
  tests[state].style.color = '#008000';
},

_mark_failed_test : function(state){
  if (!this.has_panel) return;
  var tests = document.getElementById('consecutivejs_tests').getElementsByTagName("div");
  var mark = tests[state].getElementsByTagName("span")[0];
  mark.innerHTML = '&#10008;';
  tests[state].style.color = '#ff0000';
},

_reset_panel : function(){
  if (!this.has_panel) return;

  var panel = document.getElementById('consecutivejs_panel');
  panel.innerHTML = '';

  var header = document.createElement('div');

  var control = document.createElement('a');
  control.id = 'consecutivejs_control';
  control.style.fontWeight = 'bold';
  header.appendChild(control);

  var title = document.createElement('span');
  title.style.color = '#888';
  title.innerHTML = ' consecutive.js';
  header.appendChild(title);

  var status = document.createElement('div');
  status.id = 'consecutivejs_status';
  status.style.fontWeight = 'bold';
  status.innerHTML = '&nbsp;';

  var tests = document.createElement('div');
  tests.id = 'consecutivejs_tests';
  tests.style.maxHeight = '30vh';
  tests.style.overflowY = 'auto';
  tests.style.border = '1px solid #f5eb8b';

  for (test of this.queue){
    var test_row = document.createElement('div');
    test_row.innerHTML = '<span style="display: inline-block; width: 12px;">&bull;</span> ' + test.label;
    tests.appendChild(test_row);
  }

  panel.appendChild(header);
  panel.appendChild(tests);
  panel.appendChild(status);

  this._update_panel_control();
  var max_state = this.get_state();
  for (var state = 0; state < max_state; state++){
    this._mark_passed_test(state);
  }
},

panel : function(){
  this.has_panel = true;
  var panel = document.createElement('div');
  panel.id = 'consecutivejs_panel';
  panel.style.backgroundColor = '#fff8a9';
  panel.style.border = '1px solid #e2d54e';
  panel.style.position = 'fixed';
  panel.style.bottom = '10px';
  panel.style.right = '10px';
  panel.style.padding = '10px';
  panel.style.fontSize = '11px';
  panel.style.zIndex = 10001;
  panel.style.width = '400px';
  panel.style.maxWidth = '70vw';

  document.body.appendChild(panel);
  this._reset_panel();
  return this;
}

};
