@component('components.card')

@slot('header')
  <h2>{!! $module->icon() !!} {{ $module->title() }}</h2>
@endslot

<p>I am a generic module.</p>
@endcomponent
