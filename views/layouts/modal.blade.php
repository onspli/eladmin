<div class="modal" tabindex="-1" role="dialog" <?php if(isset($module)) { echo 'data-elamodule="' . $module->elakey() . '"'; } ?>>
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          @section('modal-title')
          Modal Title
          @show
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @section('modal-body')
        <p>Modal body text goes here.</p>
        @show
      </div>
      <div class="modal-footer">
        @section('modal-footer')
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        @show
      </div>
    </div>
  </div>
</div>
