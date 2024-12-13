@set($emptyFields, true)
@foreach($panels as $panel)
@if(
  !empty($panel['headline']) ||
  !empty($panel['subhead']) ||
  !empty($panel['copy'])
)
  @set($emptyFields, false)
  @break
@endif
@endforeach

@if(
  $block->preview ||
  (
    count($panels) >= 2 &&
    !$emptyFields
  )
)

{{--
  define the variables if they're empty
  to provide content in Preview mode
--}}
@if(
  $emptyFields
)
  @set($headline, 'Headline')
  @set($subhead, 'Subhead')
  @set($copy, 'Copy goes here.')
  @set($panels, [
    [
      'headline'  => 'Headline',
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
      'image'       => null,
    ],
    [
      'headline'  => 'Headline',
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
      'image'       => null,
    ]
  ])
@endif
<section class="{{ classNames([
    'section section--accordion',
    'grid-half' => $two_cols,
    'bg-' . $background,
  ])}}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  @if($two_cols)
    <div class="{{ classNames([
      'accordion--copy lg:sticky lg:top-0 h-auto !justify-start items-start',
      'bg-' . $left_background,
    ]) }}">
      <div class="accordion--copy">
        @include('partials.accordion.copy')
      </div>
    </div>
    <div class="{{ classNames([
      'accordion--items items-start h-full',
      'bg-' . $right_background,
    ]) }}">
      @include('partials.accordion.accordions')
    </div>
  @else
    <div class="fluid-container grid-12">
      <div class="col-narrow">
        @include('partials.accordion.copy', ['mb' => 'full'])
        @include('partials.accordion.accordions')
      </div>
    </div>
  @endif
      
</section>
@endif