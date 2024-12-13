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
<section class="{{ classNames([
    'section--cta-full text-center',
    'min-h-' . $height,
    'bg-' . $background => !!$background,
    'bg-white cta-image' => !!$image,
    '-mt-header' => isset($first_block)
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  <div class="fluid-container">
    <div class="{{ classNames([
        'py-max px-[2rem] md:p-max !rounded-block',
        'card' => !$image,
        'bg-image' => !!$image,
      ]) }}"
      @if($image)
        style="--background-image: url('{{  wp_get_attachment_image_url($image['ID'], 'background') }};')"
        data-background="{{  wp_get_attachment_image_url($image['ID'], 'background') }}"
    @endif>
      @include('partials.copy', [
        'headingLevel' => 'h2',
        'headline_size' => 1,
        'layout'  => 'center',
      ])
    </div>
  </div>
</section>
@endif
