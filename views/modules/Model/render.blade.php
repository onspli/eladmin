

<div class="card">
  <div class="card-header"><h2>{!! $elaModule->elaGetIcon() !!} {{$elaModule->elaGetTitle() }}</h2></div>
  <div class="card-body">
    @if($eladmin->auth('postRow'))
    <button id="crudadd" type="button" class="btn btn-primary mb-3" data-elaaction="postForm">
      <i class="fas fa-plus-circle"></i> Přidat
    </button>
    @endif
    @include($elaModule->bladeViewTable, ['eladmin'=>$eladmin, 'elaModule'=>$elaModule])
  </div>
</div>


<script>

function redrawCrudTable(){
  elaRequest('getRows', null).done(function(data){
    var tbody = $('#crud-table tbody');
    tbody.html(data);
  });
}

redrawCrudTable();

$(document).on('submit', 'form#modal-form', function(e){
  e.preventDefault();
  $.ajax({
    url: $(this).attr('action'),
    method: 'POST',
    data: $(this).serialize()
  }).fail(function(response){
    toastr.error(response.responseText);
  }).done(function(data){
    toastr.success('Uloženo!');
    $('#dynamic .modal').modal('hide');
    redrawCrudTable();
  });

});

</script>
