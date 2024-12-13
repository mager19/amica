@if(isset($block) &&
  $block->preview ||
  (
    $eyebrow ||
    $headline ||
    $subhead
  )
)

{{--
  define the variables if they're empty
  to provide content in Preview mode
--}}
@if(
  empty($eyebrow) &&
  empty($headline) &&
  empty($subhead)
)
  @set($eyebrow, 'Eyebrow')
  @set($headline, 'Headline')
  @set($subhead, 'Subhead copy goes here')
@endif
<section class="section--two-column grid-half bg-{{ $background }}"
  aria-label="{!! $headline !!}" 
  id="{{ sanitize_title($headline) }}"
>
  @include('partials.two-columns', [
    'headingLevel' => 'h2',
    ])
</section>
@endif