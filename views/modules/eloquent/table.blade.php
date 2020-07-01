@push('header_row')
@foreach($module->elaColumns() as $column=>$config)
<?php if($config->nonlistable??false) continue; ?>
      <th class="noselect" {!! $config->realcolumn? 'data-column="'.$column.'"':'' !!}>
        {{ $config->label??$column }}
        {!! $config->realcolumn ? '<span class="arrs"><span class="arr desc">&#x2191;</span> <span class="arr asc">&#x2193;</span></span>' : '' !!}
      </th>
@endforeach
      <th></th>
@endpush

<div class="table-responsive mb-3">
  <table id="crud-table" class="table table-striped table-bordered">
    <thead>
@stack('header_row')
    </thead>
    <tbody>
    </tbody>
    <tfoot>
@stack('header_row')
    </tfoot>
  </table>
</div>
