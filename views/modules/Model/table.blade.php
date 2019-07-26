<div class="table-responsive">
<table id="crud-table" class="table table-striped table-bordered">

  <thead>
    @foreach($elaModule->elaColumns() as $column=>$config)
      <?php if($config->nonlistable??false) continue; ?>
      <th>{{$config->label??$column}}</th>
    @endforeach
    <th></th>
  </thead>
  <tbody>
    <tr><th colspan="1000" class="text-center">Načítám...</th></tr>
  </tbody>
  <tfoot>
    @foreach($elaModule->elaColumns() as $column=>$config)
      <?php if($config->nonlistable??false) continue; ?>
      <th>{{$column}}</th>
    @endforeach
    <th></th>
  </tfoot>
</table>
</div>
