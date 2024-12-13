<div class="fluid-container grid-12 col-span-full row-span-full z-content partials--one-column">
  <div class="col-narrow">
    @include('partials.copy', [
      'repeater'      => isset($repeater) ? $repeater : false,
    ])
  </div>
</div>