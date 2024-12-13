@set($emptyFields, true)
@foreach($list as $item)
@if(
  !empty($item['subhead']) ||
  !empty($item['copy'])
)
  @set($emptyFields, false)
  @break
@endif
@endforeach

@if(
  $block->preview ||
  (
    count($list) >= 1 &&
    !$emptyFields &&
    (
      $headline ||
      $subhead ||
      $copy
    )
  )
)

{{--
  define the variables if they're empty
  to provide content in Preview mode
--}}
@if(
  !$headline &&
  !$subhead &&
  !$copy
) 
  @set($headline, 'Headline') 
  @set($subhead, 'Subhead') 
  @set($copy, 'Copy goes here.')
@endif
@if(
  $emptyFields
)
  @set($list, [
    [
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
      'image'     => null,
    ],
    [
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
      'image'     => null,
    ]
  ])
@endif


@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'border'  => false,
    'left' => false,
    'top'  => true
  ])
@endif

<section class="{{ classNames([
    'section section--sticky-50 grid-half',
    'bg-' . $background,
    'has-tab' => $folder_tab == true,
  ])}}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}" 
>

  <div class="{{ classNames([
    '!justify-start items-start',
    'bg-' . $left_background,
    'stick-50--copy lg:sticky lg:top-0 h-auto grid-rows-none' => $layout == 'left',
    'stick-50--items h-full items-start' => $layout != 'left',
  ]) }}">
    @if($layout == 'left')
      @include('partials.sticky.copy', [
        'mb'  => isset($image) && $image ? 'inner' : ''
      ])
    @else
      @include('partials.sticky.list')
    @endif
  </div>
  <div class="{{ classNames([
    'items-start',
    'bg-' . $right_background,
    'stick-50--copy lg:sticky lg:top-0 h-auto grid-rows-none' => $layout != 'left',
    'stick-50--items h-full' => $layout == 'left',
  ]) }}">
    @if($layout == 'right')
      @include('partials.sticky.copy', [
        'mb'  => isset($image) && $image ? 'inner' : ''
      ])
    @else
      @include('partials.sticky.list')
    @endif
  </div>
</section>
@endif