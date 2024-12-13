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
@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'border'  => false,
    'left' => false,
    'top'  => true
  ])
@endif
<section class="{{ classNames([
    'section--form grid-half md:min-h-screen',
    'bg-' . $background => !$is_image_background,
    'bg-image' => $is_image_background,
  ]) }}" 
  @if($image)
    style="--background-image: url('{{  wp_get_attachment_image_url($image['ID'], 'background') }};')"
    data-background="{{  wp_get_attachment_image_url($image['ID'], 'background') }}"
  @endif
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}" 
>
  <div class="form--copy">
    <div class="self-center">
      @include('partials.copy', [
        'headline_size' => 1,
      ])
    </div>
  </div>
  <div class="form--form">
    <div class="self-center !h-auto p-half xxl:p-full card">
      @isset($form_embed)
        <script type='text/javascript' src='https://static.everyaction.com/ea-actiontag/at.js' crossorigin='anonymous'></script>

        {!! $form_embed !!}
      @endisset
      @isset($form_gravityforms)
        @include('partials.copy', [
          'align' => 'center',
          'eyebrow' => false,
          'headline' => false,
          'subhead' => $form_headline,
          'copy' => $form_copy,
          'mb'  => 'inner',
        ])
        {!! gravity_form($form_gravityforms['id'], false, false, false, null, false) !!}
      @endisset
    </div>
  </div>
</section>
@endif