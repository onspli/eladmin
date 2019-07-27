<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          @section('modal-title')
          Účet <strong>{{$eladmin->username()}}</strong>
          @show
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="accountform" action="{{ $eladmin->request('account','') }}">
          @foreach($eladmin->accountFields() as $column=>$config)
            <div class="form-group">
              <label>{{$config['label']??$column}}</label>
              <input type="{{ $config['type']??'text' }}" class="form-control" name="{{$column}}">
            </div>
          @endforeach
        </form>
      </div>
      <div class="modal-footer">
        @section('modal-footer')
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Zrušit</button>
        <button type="submit" form="accountform" class="btn btn-primary"><i class="fas fa-save"></i> Uložit</button>
        @show
      </div>
    </div>
  </div>
</div>
