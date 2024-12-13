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
<aside id="{!! sanitize_title($headline) !!}"
  class="{{ classNames([
    'modal closed' => !$block->preview,
  ]) }}" 
  tabindex="-1" 
  aria-labelledby="introModalTitle" 
  aria-hidden="true" 
  role="dialog" 
  data-controller="modal" 
  data-modal-type-value="{{ $type }}"
  {!! $block->preview ? "" : 'style="display: none;"' !!}
>
  <div class="modal-dialog">
    <div class="{{ classNames([
        'modal-content rounded p-4',
        'bg-' . $background => !!$background,
        'bg-image' => !!$image,
        'bg-video py-0' => !!$video,
      ]) }}">
      <div class="modal-header">
        <button class="button-white" type="button" class="close" data-modal-target="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="intro">
          <div class="banner text-center" aria-label="{!! $headline !!}"
            @if($image)
              style="--background-image: url('{{  wp_get_attachment_image_url($image, 'background') }};')"
              data-background="{{  wp_get_attachment_image_url($image, 'background') }}"
            @endif>
            @include('partials.one-column', [
              'headingLevel' => 'h2',
              'headline_size' => 1,
              'layout'  => 'center',
            ])
          </div>
        </div>
      </div>
      <div class="modal-footer flex justify-around">
        <x-button type="border" html="button" data-action="modal#confirm">{!! $confirm_cta !!}</x-button>
        @if(isset($alt_cta['title']) && $alt_cta['title'] !== false)
          <p class="partial-copy--cta">
            <x-button
              type="button"
              href="{{ $alt_cta['url'] }}"
              target="{{ $alt_cta['target'] }}"
              >
              {!! $alt_cta['title'] !!}
            </x-button>
          </p>
        @endif
      </div>
    </div>
  </div>
</aside>
@endif
