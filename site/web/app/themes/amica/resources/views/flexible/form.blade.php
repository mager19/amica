<section class="{{ classNames(
  'section--form flex items-center',
  ['min-h-[calc(100vh-5rem)]' => !$has_alert],
  ['min-h-[calc(100vh-8rem)]' => $has_alert],
) }}">
  <div class="fluid-container">
    <div class="mx-auto w-full md:w-10/12 lg:w-9/12 xxl:w-8/12 md:px-4 text-center">
      @if($eyebrow)
        <x-eyebrow
          size="1"
          style="">
          {{ $eyebrow }}
        </x-eyebrow>
      @endif

      @if($header)
        <x-display
          size="2"
          html="h2"
          >
          {{ $header }}
        </x-display>
      @endif

      @if($subtitle)
        <x-subhead
          size="1"
          >
          {!! $subtitle !!}
        </x-subhead>
      @endif
    </div>

    <div class="w-full">
      @if(isset($form))
          <div class="my-6">
              {!! gravity_form($form['title'], false, false, false, null, true) !!}
          </div>
      @endif
    </div>
  </div>
</section>