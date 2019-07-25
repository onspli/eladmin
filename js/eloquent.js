$('#content').empty();
$('#content').append('<div><button id="crudadd" type="button" class="btn btn-primary">Přidat záznam</button></div>');
$('#content').append(elaTable({id:'crudtable'}));

var crudFilters = {
  sort: 'id',
  direction: 'desc'
}

function redrawTable(filters){
  var fil = $.extend( {}, crudFilters, filters );

  elaQuery({
    action: 'getRows',
    data: {
      sort: crudFilters.sort,
      direction: crudFilters.direction
    }
  }).done(function(rows){
    var tbody = $('#crudtable tbody').empty();
    $.each(rows, function(){
        var row = $('<tr></tr>');
        row.data('id', this[crudConfig.primaryKey]);
        var rowdata = this;
        $.each(crudConfig.visibleColumns, function(){
          var td = $('<td></td>');
          if(rowdata[this]) td.text(rowdata[this]);
          row.append(td);
        });

        tbody.append(row);
    });

  });
}

var crudConfig = null;
elaQuery({
  action: 'getConfig'
}).done(function(data){
    crudConfig = data;
    console.debug(crudConfig);
    crudFilters.sort = data.primaryKey;
    var tr = $('<tr></tr>');
    $.each(crudConfig.visibleColumns, function(){
      var th = $('<th style="cursor:pointer">'+this+'</th>');
      th.data('column', this);
      tr.append(th);
    });
    $('#crudtable thead, #crudtable tfoot').append(tr);
    redrawTable();

    $('#crudtable').on('click', 'th', function(){
      var column = $(this).data('column');
      $('#crudtable th i').remove();
      if(crudFilters.sort != column){
        crudFilters.sort = column;
        crudFilters.direction = 'asc';
        $(this).append('<i class="fas fa-sort-down float-right"></i>');
      } else if(crudFilters.direction == 'asc'){
        crudFilters.direction = 'desc';
        $(this).append('<i class="fas fa-sort-up float-right"></i>');
      } else{
        crudFilters.direction = 'asc';
        $(this).append('<i class="fas fa-sort-down float-right"></i>');
      }
      redrawTable();
    })
});




$('#crudtable tbody').on('click', 'tr', function(e){
    e.preventDefault();

    console.debug('#'+$(this).data('id'));
    var id = $(this).data('id');

    elaQuery({
      action: 'getRow',
      data: {[crudConfig.primaryKey]: id}
    }).done(function(data){
      var form = elaForm({
        id: 'crudform',
        action: 'putRow',
        done: function(){
          elaModalHide();
          redrawTable();
          toastr.success('Uloženo!');
        }
      });

      $.each(crudConfig.schema, function(key,value){
        if(crudConfig.visibleColumns.indexOf(key)<0) return;
        if(key == crudConfig.primaryKey){
          form.append(elaInput({label: key, name: key, type: 'hidden', value: data[key] }));
          form.append(elaInput({label: key, name: key, type: 'text', value: data[key], disabled: true }));
        } else if(value=="text")
          form.append(elaInput({label: key, name: key, type: 'textarea', value: data[key], disabled: crudConfig.disabledColumns.indexOf(key)>=0 }));
        else
          form.append(elaInput({label: key, name: key, type: 'text', value: data[key], disabled: crudConfig.disabledColumns.indexOf(key)>=0 }));
      });

      $.each(crudConfig.extraInputs, function(key, value){
        form.append(elaInput({label: this.label, name: key, type: 'text'}));
      });

      $.each(crudConfig.extraActions, function(key, value){
        var but = elaButton({label: this.label, style: this.style});
        but.click(function(){
          elaQuery({action:key}).done(function(data){
            toastr.success(data);
          }).fail(function(data){
            console.error(data);
            toastr.error(data.responseText);
          });
        });
        form.append('<div class="form-group"></div>').append(but);
      });

      var footer = $('<div> <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušit</button> <button type="submit" class="btn btn-primary" form="crudform">Uložit</button></div>');
      var delbut = elaButton({style: 'danger',label: 'Smazat'}).click(function(e){
        e.preventDefault();
        if(confirm('Opravdu smazat?')){
          elaQuery({
            action: 'delRow',
            data: {[crudConfig.primaryKey]: id}
          }).done(function(){
            elaModalHide();
            redrawTable();
            toastr.success('Smazáno!');
          });
        }
      });

      footer.prepend(delbut);
      elaModal({title: 'Záznam #'+id, body: form, footer: footer});

    });
});

$('#crudadd').click(function(e){
  e.preventDefault();

  var form = elaForm({
    id: 'crudform',
    action: 'postRow',
    done: function(){
      elaModalHide();
      redrawTable();
      toastr.success('Přidáno!');
    }
  });

  $.each(crudConfig.schema, function(key,value){
    if(crudConfig.visibleColumns.indexOf(key)<0) return;
    if(key == crudConfig.primaryKey) return;
    if(value=="text")
      form.append(elaInput({label: key, name: key, type: 'textarea', disabled: crudConfig.disabledColumns.indexOf(key)>=0 }));
    else
      form.append(elaInput({label: key, name: key, type: 'text', disabled: crudConfig.disabledColumns.indexOf(key)>=0 }));
  });

  $.each(crudConfig.extraInputs, function(key, value){
    form.append(elaInput({label: this.label, name: key, type: 'text'}));
  });

  $.each(crudConfig.extraActions, function(key, value){
    var but = elaButton({label: this.label, style: this.style});
    but.click(function(){
      elaQuery({action:key}).done(function(data){
        toastr.success(data);
      }).fail(function(data){
        console.error(data);
        toastr.error(data.responseText);
      });
    });
    form.append('<div class="form-group"></div>').append(but);
  });

  var footer = $('<button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušit</button> <button type="submit" class="btn btn-primary" form="crudform">Uložit</button>');
  elaModal({title: 'Nová položka', body: form, footer, footer});

})
