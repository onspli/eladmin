<script src="{!! $eladmin->asset('consecutive.js', $eladmin->versionName()) !!}"></script>
@if($eladmin->consecutive)
<script>
{!! $eladmin->consecutiveScript() !!}
</script>
@endif
