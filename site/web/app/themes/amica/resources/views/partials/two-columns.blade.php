@if(!isset($left_background))
  @set($left_background, null)
@endif
@if(!isset($right_background))
  @set($right_background, null)
@endif
  <div class="{{ classNames([
    'mobile-first' => $layout == 'left',
  ]) }}">
    @if($layout == 'left')
      <div class="self-center">@include('partials.copy')</div>
    @else
      @isset($image['ID'])
        <div class="h-full">
          <x-image
            id="{{ $image['ID'] }}"
            size="full"
            class="w-full rounded-image aspect-square"
            alignY="bottom"
            alignX="left"
          ></x-image>
        </div>
      @endisset
    @endif
  </div>
  <div class="{{ classNames([
    'mobile-first' => $layout != 'left',
  ]) }}">
    @if($layout == 'right')
      <div class="self-center">@include('partials.copy')</div>
    @else
      @isset($image['ID'])
        <div class="h-full">
          <x-image
            id="{{ $image['ID'] }}"
            size="full"
            class="w-full rounded-image aspect-square"
            alignY="top"
            alignX="right"
          ></x-image>
        </div>
      @endisset
    @endif
  </div>