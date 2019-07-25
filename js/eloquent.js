$('#content').empty();
$('#content').append('<div><button id="crudadd" type="button" class="btn btn-primary">Přidat záznam</button></div>');
$('#content').append(elaTable({id:'crudtable'}));

var crudConfig = null;
elaQuery({
  action: 'getConfig'
}).done(function(data){
    crudConfig = data;
    $('#crudtable thead, #crudtable tfoot').append(elaRow(crudConfig.columns, {cell:'th'}));
    redrawTable();
});


function redrawTable(){
  elaQuery({
    action: 'getRows'
  }).done(function(rows){
    $('#crudtable tbody').empty();
    $.each(rows, function(){
        var row = elaRow(this);
        row.data('id', this[crudConfig.primaryKey]);
        $('#crudtable tbody').append(row);
    });

  });
}


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
        if(key == crudConfig.primaryKey){
          form.append(elaInput({label: key, name: key, type: 'hidden', value: data[key] }));
          form.append(elaInput({label: key, name: key, type: 'text', value: data[key], disabled: true }));
        } else if(value=="text")
          form.append(elaInput({label: key, name: key, type: 'textarea', value: data[key] }));
        else
          form.append(elaInput({label: key, name: key, type: 'text', value: data[key] }));
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
      elaModal({header: 'Záznam #'+id, body: form, footer: footer});

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
    if(key == crudConfig.primaryKey) return;
    if(value=="text")
      form.append(elaInput({label: key, name: key, type: 'textarea'}));
    else
      form.append(elaInput({label: key, name: key, type: 'text'}));
  });

  var footer = $('<button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušit</button> <button type="submit" class="btn btn-primary" form="crudform">Uložit</button>');
  elaModal({header: 'Nová položka', body: form, footer, footer});

})
