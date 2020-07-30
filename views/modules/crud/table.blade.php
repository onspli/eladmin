@push('header_row')
      <tr>
        <th class="text-center"><input class="bulk-all" type="checkbox"></th>
@foreach($module->getCrudColumns() as $column => $config)
<?php if($config->nonlistable) continue; ?>
        @if($config->nonsortable || !$module->implementsSorting())
        <th class="noselect">
          {{ $config->label ?? $column }}
        </th>
        @else
        <th class="noselect" data-column="{{$column}}">
          {{ $config->label ?? $column }}
          <span class="arrs"><span class="arr desc">&#x2191;</span> <span class="arr asc">&#x2193;</span></span>
        </th>
        @endif
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

<div class="table-responsive mb-1 mt-1">
  <table id="crud-table" class="table table-striped table-bordered mb-0 mt-0">
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
