@set($mb, isset($mb) ? $mb : '0')
@set($align, isset($align) ? $align : 'left')
@set($repeater, isset($repeater) ? $repeater : false)
@set($class, isset($class) ? $class : '')
@set($padding, isset($padding) ? $padding : 'inner')
@set($copy_size, isset($copy_size) ? $copy_size : 1)
@set($subhead_el, isset($subhead_el) ? $subhead_el : 'p')

@if(!isset($headline_size))
  @set($headline_size, isset($card_headline) ? 1 : 2)
@endif

@isset($layout) @set($align, $layout) @endisset

<div data-repeater="{{ $repeater ? 'true': 'false' }}" class="{{ classNames([
  'partial-copy flex flex-col flex-1',
  'mb-' . $mb  => $mb,
  'text-' . $align  => $align,
  'space-y-' . $padding => $padding,
  'is-repeater' => $repeater,
  $class  => $class,
])}}">
@if((isset($eyebrow) && $eyebrow) || (isset($headline) && $headline) || (isset($card_headline) && $card_headline))
  <div class="{{ classNames([
    'copy--headline break-words',
    'space-y-' . $padding => $padding,
  ])}}">
    @if(isset($eyebrow) && $eyebrow)
      <x-eyebrow
        class="mb-0"
        html="p"
      >
        {!! $eyebrow !!}
      </x-eyebrow>
    @endif
    @if(isset($headline) && $headline)
      <x-display
        class="mb-0"
        size="{{ $headline_size }}"
        html="{{ isset($headingLevel) ? $headingLevel : 'p' }}"
      >
        {!! $headline !!}
      </x-display>
    @endif
    @if(isset($card_headline) && $card_headline)
      <x-subhead
        size="{{ $headline_size }}"
        class="mb-0"
        html="{{ ( isset($headingLevel) && isset($card_headline) ) ? $headingLevel : 'p' }}"
      >
        {!! $card_headline !!}
      </x-subhead>
    @endif
  </div>
@endif
@if((isset($subhead) && $subhead) || (isset($card_subhead) && $card_subhead) || (isset($copy) && $copy))
  <div class="copy--body space-y-min">
    @if(isset($subhead) && $subhead)
      <x-subhead
        class="mb-0"
        size="2"
        html="{{ $subhead_el }}"
      >
        {!! $subhead !!}
      </x-subhead>
    @endif
    @if(isset($card_subhead) && $card_subhead)
      <x-subhead
        size="3"
        class="mb-0"
        html="{{ $subhead_el }}"
      >{!! $card_subhead !!}
      </x-subhead>
    @endif
    @if(isset($copy) && $copy)
      <div class="partial-copy--lead-copy">
        @if(isset($copy) && $copy)
          <div class="partial-copy--copy body-{{ $copy_size }}">{!! $copy !!}</div>
        @endif
      </div>
    @endif
  </div>
@endif
@if(isset($cta['title']) && $cta['title'] !== false)
  <p class="partial-copy--cta">
    <x-button
      type="{{ isset($cta_type) ? $cta_type : 'button' }}"
      icon="{{ isset($cta_icon) ? $cta_icon : '' }}"
      size="{{ isset($cta_size) ? $cta_size: '' }}"
      html="{{ isset($cta_html) ? $cta_html : 'a' }}"
      href="{{ $cta['url'] }}"
      target="{{ $cta['target'] }}"
      >
      {!! $cta['title'] !!}
    </x-button>
  </p>
@endif
</div>