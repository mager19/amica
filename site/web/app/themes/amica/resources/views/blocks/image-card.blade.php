<section class="{{ classNames([
    'section--image-card relative',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title($block_headline) }}"
  aria-label="{!! $block_headline !!}"
>
  @if($eyebrow || $headline)
    @include('partials.one-column', [
      'headingLevel' => 'h2',
      'eyebrow' => $eyebrow ?: '',
      'headline' => $headline ?: '',
      'subhead' => false,
      'layout' => 'center',
      'class' => 'py-0',
      'mb'  => 'half'
    ])
  @endif
  <div class="fluid-container relative z-content">

    <div class="{{ classNames([
      'grid ml-0 gap-wide relative z-content lg:grid-12',
      'pt-half'  => $eyebrow !== '' || $headline !== ''
    ]) }}">
      <div class="{{ classNames([
        'col-span-full lg:col-narrow',
      ]) }}">
          <x-card
            :cta="$card['cta']"
            :image="$card['image_foreground']"
            eyebrow="{{ $card['eyebrow'] }}"
            padding="inner"
            headingLevel="h3"
            cardHeadline="{{ $card['headline'] }}"
            copy="{!! $card['copy'] !!}"
          ></x-card>
        </div>

      </div>
  </div>
  @if($is_image_background)
  <div class="z-under-content absolute w-full h-full top-0 left-0 overflow-hidden">
    @image($image_background['ID'], 'large', ['class' => 'w-full h-full object-cover'])
  </div>
  @endif
</section>