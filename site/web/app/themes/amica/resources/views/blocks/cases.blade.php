<section class="{{ classNames([
    'section--cases',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
  data-controller="cases"
>
<div class="fluid-container grid-12 col-span-full row-span-full z-content partials--one-column">
  <div class="col-narrow">
    @include('partials.copy', [
      'headline_size'       => 1,
      'headingLevel'  => 'h2',
      'layout'        => 'center',
      'mb'            => 'half',
      'class'         => 'pb-0'
    ])
    <x-category-filter post-type="case"></x-category-filter>
  </div>

  <div class="col-narrow text-center min-h-[110px] pt-inner filter-pills" data-cases-target="activeFilters">
    <h4 class="body body-2 mb-min">{!! __('Showing results for... ', 'amica') !!}</h4>
    <div class="flex gap-min items-center justify-center flex-wrap" data-cases-target="pills">
      <template id="pill-template">
        <x-button size="small" type="border" html="button" class="flex items-center justify-center gap-min"
          data-cases-target="pill" 
          data-slug=""
        >
          <span class="pill-content"></span>
          <span class="pill-icon">@svg('images.icons.x', ['class' => 'w-4 h-4 rotate-45', 'aria-hidden' => 'true'])</span>
        </x-button>
      </template>
    </div>
  </div>

  <div class="col-narrow text-center hidden" data-cases-target="noResults">
    <p>{!! $no_results !!}</p>
  </div>

  <ul class="{{ classNames([
    'col-span-full grid list-none ml-0 pt-half',
    'gap-wide' => $cards_count < 3,
    'gap-narrow' => $cards_count >= 3,
    'lg:auto-cols-fr lg:grid-flow-col' => $cards_count <= 3,
    'grid-12' => $cards_count > 3 || $cards_count == 1,
  ]) }}" data-cases-target="itemList">
    @foreach($cards as $key => $card)
      @php
        $index = $key + 1;
      @endphp
      <li class="{{ classNames([
          'case-card active',
          'col-span-full lg:col-narrow' => $cards_count === 1, // 1 Card
          '', // 2 cards
          'col-span-full lg:col-auto'   => $cards_count === 3, // 3 Cards
          'col-span-full md:col-span-6' => $cards_count > 3 && $index <= ( $cards_count - $cards_count%2 ), // 4 cards +, full row of 2
          'col-span-full'               => $cards_count > 3 && $index > ( $cards_count - $cards_count%2 ) && $cards_count%2 == 1, // 4 cards + remainder of 1 card
        ]) }}"
        data-cases-target="item"
        data-judges="{{ $card['judges'] }}"
        data-case-categories="{{ $card['legal_categories'] }}"
      >
        <x-card
          repeater="true"
          class="{{ classNames([
            'justify-end',
            ])}}"
          card-color="{{ $card_color }}"
          padding="inner"
          eyebrow="{!! $card['eyebrow'] !!}"
          headingLevel="h3"
          cardHeadline="{!! $card['headline'] !!}"
          copy="{!! $card['copy'] !!}"
          totalCards="{{ $cards_count }}"
          :cta="$card['cta']"
          ctaType="link"
          ctaIcon="arrow-right"
        ></x-card>
      </li>
    @endforeach
  </ul>

  @if($disclaimers)
    <div class="cases--disclaimers col-narrow pt-full">
      {!! $disclaimers !!}
    </div>
  @endif

</div>
<script type="text/javascript">
  const news_info = {!! json_encode($cards); !!};
</script>
</section>