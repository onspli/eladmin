@push('header_row')
      <tr>
        <th class="text-center"><input class="bulk-all" type="checkbox"></th>
@foreach($module->elaColumns() as $column => $config)
<?php if($config->nonlistable) continue; ?>
        <th class="noselect" {!! $config->nonsortable ? '' : 'data-column="'.$column.'"' !!}>
          {{ $config->label ?? $column }}
          {!! $config->nonsortable ? '' : '<span class="arrs"><span class="arr desc">&#x2191;</span> <span class="arr asc">&#x2193;</span></span>' !!}
        </th>
@endforeach
        <th></th>
      </tr>
@endpush

@push('results_info')
<div class="mb-1 mt-1">
  {!! __('Showing %s of %s results.', '<span class="results-shown">0</span>', '<span class="results-total">0</span>') !!}
  {!! __('%s items selected.', '<span class="items-selected">0</span>') !!}
</div>
@endpush

@stack('results_info')

<div class="table-responsive mb-1">
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

@stack('results_info')
