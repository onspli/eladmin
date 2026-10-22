<h1 class="sidebar-heading"><a href=".">{{ $eladmin->title() }}</a></h1>
<div class="list-group list-group-flush" id="modules-menu">
@foreach($eladmin->modules() as $key => $module)
  <a href="?elamodule={{$key}}" class="list-group-item menumodul list-group-item-action {{ ($eladmin->modulekey() === $module->elakey()) ? 'selected' : '' }}">
    {!! $module->icon() !!} {{ $module->title() }}
  </a>
@endforeach
</div>
@if($eladmin->iauth() !== null && $eladmin->iauth()->authorize())
<div class="sidebar-footer text-muted small">
  Eladmin {{ $eladmin->version() }} &middot; PHP {{ PHP_VERSION }}
</div>
@endif
