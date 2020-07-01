<h1 class="sidebar-heading"><a href=".">{{$eladmin->title()}}</a></h1>
<div class="list-group list-group-flush">
@foreach($eladmin->modules() as $key=>$module)
  <a href="?elamodule={{$key}}" class="list-group-item menumodul list-group-item-action {{ (isset($module) && $eladmin->moduleKey() === $module->elakey()) ? 'selected' : '' }}">
    {!! $module->elaGetIcon() !!} {{ $module->elaGetTitle() }}
  </a>
@endforeach
</div>
