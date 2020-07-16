<script src="{!! $eladmin->asset('consecutive.js', $eladmin->version()) !!}"></script>
@if($eladmin->consecutive)
<script>
{!! $eladmin->consecutiveScript() !!}
</script>
@endif
