@component('components.card')

@slot('header')
  <h2>{!! $module->elaIcon() !!} {{ $module->elaTitle() }}</h2>
@endslot

<p>I am a generic module.</p>
@endcomponent
