@if($alert)
  <aside class="{{ classNames([
    'alert',
    'bg-' . $background,
    'py-half' => $use === 'block',
    'py-inner' => $use === 'bar',
  ]) }}" data-header-target="alert">
    <div class="fluid-container flex flex-col text-center md:text-left md:flex-row justify-between items-center gap-inner">
      <div class="">
        <x-subhead html="p" class="{{ classNames('body-1', [
          'mb-0' => !isset($subtext),
          'mb-min' => isset($subtext)
        ] ) }}">{!! $text !!}</x-subhead>
        @if(isset($subtext) && $subtext)<p class="mb-0">{{ $subtext }}</p>@endif
      </div>
      @if($cta)
        <p class="mb-0">
          <x-button
            class="w-max"
            href="{{ $cta['url'] }}"
            target="{{ $cta['target'] }}"
            type="{{ isset($cta_type) ? $cta_type : 'button' }}"
            icon="{{ isset($cta_icon) ? $cta_icon : '' }}"
            size="{{ isset($cta_size) ? $cta_size: '' }}"
            html="{{ isset($cta_html) ? $cta_html : 'a' }}"
          >
            {{ $cta['title'] }}
          </x-button>
        </p>
      @endif
    </div>
  </aside>
@endif