@if(isset($card['headline']) && $card['headline'])
  <section class="{{ classNames([
      'section--featured-card relative',
      'bg-' . $background,
    ]) }}"
    id="{{ sanitize_title($card['headline']) }}"
    aria-label="{!! $card['headline'] !!}"
  >
    <div class="fluid-container relative z-content">
      <div class="{{ classNames([
        'grid ml-0 gap-wide relative z-content grid-12',
      ]) }}">
        <div class="{{ classNames([
          'col-span-full lg:col-narrow aspect-8/5',
        ]) }}">
            <x-card
              :cta="$card['cta']"
              :image="$card['image']"
              padding="inner"
              eyebrow="{!! $card['eyebrow'] !!}"
              headingLevel="h3"
              cardHeadline="{!! $card['headline'] !!}"
              copy="{!! $card['copy'] !!}"
            ></x-card>
          </div>
        </div>
    </div>
  </section>
@endif
@if ( $block->preview && !$card )
  <section>
    <div class="fluid-container relative z-content">
      Select a featured post
    </div>
  </section>
@endif