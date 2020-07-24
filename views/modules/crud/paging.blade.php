<div class="crud-paging form-inline">
  <div class="form-group mb-3 mr-2">
    <div class="input-group">
      <input type="text" class="form-control search" data-crudfilter="search" placeholder="{{ __('Search') }}">
      <div class="input-group-append">
        <button class="btn btn-primary searchicon" type="button" ><i class="fas fa-search"></i></button>
        <button class="btn btn-secondary erase" type="button" ><i class="fas fa-eraser"></i></button>
      </div>
    </div>
  </div>
  <div class="input-group mr-2 mb-3 form-sm-inline">
    <div class="input-group-prepend"><label class="input-group-text"><i class="fas fa-list"></i></label></div>
    <select class="custom-select form-sm-inline resultsperpage" data-crudfilter="resultsperpage" data-donotuncheck="true">
      <option value="5">5</option>
      <option value="10">10</option>
      <option value="25">25</option>
      <option value="50">50</option>
    </select>
  </div>
  <div class="input-group mb-3 form-sm-inline">
    <div class="input-group form-sm-inline">
      <div class="input-group-prepend"><button class="btn btn-warning prev-page"><i class="fas fa-step-backward"></i></button></div>
      <input type="text" class="form-control form-sm-inline page" data-crudfilter="page" data-donotuncheck="true" value="1" style="width:3em!important;text-align:center">
      <div class="input-group-append">
        <span class="input-group-text maxpage">/ 1</span>
        <button class="btn btn-warning next-page"><i class="fas fa-step-forward"></i></button>
      </div>
    </div>
  </div>
</div>
