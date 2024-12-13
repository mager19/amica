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
@if(empty($class))@set($class, '')@endif
@if(empty($layout)) @set($layout, 'left') @endif
@if(empty($folder_tab)) @set($folder_tab, false) @endif

@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'left' => false,
    'top'  => true,
  ])
@endif

<section class="{{ classNames([
    'section--one-column',
    'bg-' . $background,
    'text-' . $layout => $layout,
    'has-tab' => $folder_tab == true,
    $class      => isset($class)
  ]) }}" 
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  @include('partials.one-column', [
    'headingLevel' => 'h2',
    ])
</section>
@endif