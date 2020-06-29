@extends('layouts.card')

<?php
/**
* TODO: Hack:  poedit cannot extract gettext from javascript or HTML ??!!
*/
$loadingMessage = __('Loading data');
$nothingFoundMessage = __('Nothing found!');
$searchMessage = __('Search');
?>

@section('card-header')
  <h2>{!! $module->elaGetIcon() !!} {{$module->elaGetTitle() }}</h2>
@endsection

@section('card-body')
    <div class="actions mb-3 ">
    @if($module->elaAuth('create'))
    <button id="crudadd" type="button" class="btn btn-success"
      data-elaaction="postForm"
      data-elamodule="{{$module->elakey()}}"
      data-eladone="return;">
      <i class="fas fa-plus-circle"></i> {{ __('Add') }}
    </button>
    @endif
    @foreach($module->elaFilters() as $filter)
      <button href="#crud-filters"  class="btn btn-primary" data-toggle="collapse"><i class="fas fa-filter"></i> {{ __('Filters') }}</button>
      @break
    @endforeach
    @if($module->elaUsesSoftDeletes())
      <button class="btn btn-secondary crud-trash" data-toggle="collapse"><i class="fas fa-trash-restore"></i> {{ __('Trash') }}</button>
    @endif
    </div>

    @if($module->elaAuth('read'))

    <div id="crud-filters" class="form-inline collapse">
      @foreach($module->elaFilters() as $name=>$filter)
      <div class="input-group mr-2 mb-3">
        <div class="input-group-prepend">
          <label class="input-group-text">
            {!! $filter->icon !!}&nbsp;
            {{$filter->label??$name}} </label>
        </div>
        @if($filter->input == 'select')
          <select class="form-control" data-crudfiltercolumn="{{$filter->column??$name}}">
            <?php
            if(is_callable($filter->selectOptions)){
              $selectOptions = ($filter->selectOptions)($filter, $name);
            } else{
              $selectOptions = $filter->selectOptions;
            }
            ?>
            @foreach($selectOptions as $value=>$label)
              <option value="{{$value}}">{{ $label }}</option>
            @endforeach
          </select>
        @else
          <input type="text" class="form-control" data-crudfiltercolumn="{{$filter->column??$name}}">
        @endif
      </div>
      @endforeach
    </div>

    @push('crud-paging')
    <div class="crud-paging form-inline">
      <div class="form-group mb-3 mr-2">
        <div class="input-group">
            <input type="text" class="form-control search" data-crudfilter="search" placeholder="{{$searchMessage}}">
            <div class="input-group-append">
              <button class="btn btn-primary searchicon" type="button" ><i class="fas fa-search"></i></button>
              <button class="btn btn-secondary erase" type="button" ><i class="fas fa-eraser"></i></button>
            </div>
        </div>
      </div>
      <div class="input-group mr-2 mb-3 form-sm-inline">
        <div class="input-group-prepend">
          <label class="input-group-text"><i class="fas fa-list"></i></label>
        </div>
        <select class="custom-select form-sm-inline resultsperpage" data-crudfilter="resultsperpage">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select>
      </div>
      <div class="input-group mb-3 form-sm-inline">
        <div class="input-group form-sm-inline">
          <div class="input-group-prepend">
            <button class="btn btn-warning prev-page"><i class="fas fa-step-backward"></i></button>
          </div>
          <input type="text" class="form-control form-sm-inline page" data-crudfilter="page" value="1" style="width:3em!important;text-align:center">
          <div class="input-group-append">
            <span class="input-group-text maxpage">/ 1</span>
            <button class="btn btn-warning next-page"><i class="fas fa-step-forward"></i></button>
          </div>
        </div>
      </div>
    </div>
    @endpush

    @stack('crud-paging')



    <div class="table-responsive mb-3">
    <table id="crud-table" class="table table-striped table-bordered">
      <thead>

        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th class="noselect"  {{ $config->realcolumn? ' data-column='.$column.' ':'' }}>
              {{$config->label??$column}}
              {!! $config->realcolumn? '<span class="arrs"><span class="arr desc">&#x2191;</span> <span class="arr asc">&#x2193;</span></span>' :''!!}
          </th>
        @endforeach
        <th></th>
      </thead>
      <tbody>
      </tbody>
      <tfoot>
        @foreach($module->elaColumns() as $column=>$config)
          <?php if($config->nonlistable??false) continue; ?>
          <th class="noselect"  {{ $config->realcolumn? ' data-column='.$column.' ':'' }}>
              {{$config->label??$column}}
              {!! $config->realcolumn? '<span class="arrs"><span class="arr desc">&#x2191;</span> <span class="arr asc">&#x2193;</span></span>' :''!!}
          </th>
        @endforeach
        <th></th>
      </tfoot>
    </table>
    </div>



    @stack('crud-paging')

    @endif

@endsection
