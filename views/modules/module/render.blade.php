@component('components.card')

@slot('header')
  <h2>{!! $module->elaGetIcon() !!} {{$module->elaGetTitle() }}</h2>
@endslot

<p>I am a generic module.</p>
@endcomponent
