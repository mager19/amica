@set($id, rand(1,1000))
@set($emptyFields, true)
@set($cards_count, is_array($cards) ? count($cards) : 0)
@foreach($cards as $card)
@if(
  !empty($card['headline']) ||
  !empty($card['subhead']) ||
  !empty($card['copy'])
)
  @set($emptyFields, false)
  @break
@endif
@endforeach

@if(
  $block->preview ||
  (
    count($cards) >= 2 &&
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
  @set($headline, 'Card Slider Headline')
  @set($subhead, 'Subhead')
  @set($copy, 'Copy goes here')
  @set($cards, [
    [
      'headline'  => 'Card headline',
      'subhead'   => 'Card subhead',
      'copy'      => 'Card copy goes here.',
      'cta'       => null,
      'image'     => null,
    ],
    [
      'headline'  => 'Card headline',
      'subhead'   => 'Card subhead',
      'copy'      => 'Card copy goes here.',
      'cta'       => null,
      'image'     => null,
    ]
  ])
@endif
<section class="{{ classNames([
    'section--card-slider block',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  <div class="fluid-container">
  <div class="swiper swiper-card-slider" data-controller="card-slider">
    <div class="grid">
      <div class="copy">
        @include('partials.copy', [
          'headingLevel' => 'h2',
          ])
      </div>
      <div class="swiper--pagination-navigation flex justify-self-end self-start row-start-1 col-start-2">
        <button class="custom-button-prev" data-carousel-target="prev" aria-controls="card-slider--{{ $id }}"><span class="fa fa-arrow-left" aria-label=""></span><span class="sr-only">Next slide</span></button>
        <button class="custom-button-next" data-carousel-target="next" aria-controls="card-slider--{{ $id }}"><span class="fa fa-arrow-right" aria-label=""></span><span class="sr-only">Previous slide</span></button>
      </div>
    </div>
    @if($cards)
      <ul class="swiper-wrapper cursor-grab active:cursor-grabbing mt-12 md:mt-16 " data-card-slider-target="slider" id="card-slider--{{ $id }}">
        @foreach ($cards as $index => $card)
          <li class="swiper-slide">
            <x-card
              :cta="$card['cta']"
              :image="$card['image']"
              card_headline="{{ $card['headline'] }}"
              card_subhead="{!! $card['subhead'] !!}"
              copy="{!! $card['copy'] !!}"
              total-cards="{{ $cards_count }}"
              repeater="true"
              headingLevel="h3"
            ></x-card>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
  </div>
</section>
@endif