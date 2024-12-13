<section class="{{ classNames([
    'section--news-story-repeater',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
  data-controller="filters"
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
    <x-category-filter taxonomySlug="{{ $taxonomy_slug }}"></x-category-filter>
  </div>
  <ul class="{{ classNames([
    'col-span-full grid list-none ml-0 pt-half',
    'gap-wide' => $cards_count < 3,
    'gap-narrow' => $cards_count >= 3,
    'lg:auto-cols-fr lg:grid-flow-col' => $cards_count <= 3,
    'grid-12' => $cards_count > 3 || $cards_count == 1,
  ]) }}">
    @foreach($cards as $key => $card)
      @php
        $index = $key + 1;
      @endphp
      <li class="{{ classNames([
          'col-span-full lg:col-narrow aspect-8/5' => $cards_count === 1, // 1 Card
          '', // 2 cards
          'col-span-full lg:col-auto'   => $cards_count === 3, // 3 Cards
          'col-span-full md:col-span-6' => $cards_count > 3 && $index <= ( $cards_count - $cards_count%2 ), // 4 cards +, full row of 2
          'col-span-full'               => $cards_count > 3 && $index > ( $cards_count - $cards_count%2 ) && $cards_count%2 == 1, // 4 cards + remainder of 1 card
        ]) }}"
        data-filters-target="item"
        data-tags="{{ $card['tags'] }}"
      >
        <x-card
          repeater="true"
          class="{{ classNames([
            'justify-end',
            'is-folder-tab card-white' => $is_folder_tab && !$card_color,
            'is-folder-tab card-' . $card_color => $is_folder_tab && $card_color,
          ])}}"
          card-color="{{ $card_color }}"
          is-folder-tab="{{ $is_folder_tab }}"
          :image="$card['image']"
          padding="inner"
          eyebrow="{!! $card['eyebrow'] !!}"
          headingLevel="h3"
          cardHeadline="{!! !$is_folder_tab ? $card['headline'] : '' !!}"
          cardSub="{!! !$is_folder_tab ? $card['headline'] : '' !!}"
          subhead="{!! $is_folder_tab ? $card['headline'] : '' !!}"
          copy="{!! $card['copy'] !!}"
          totalCards="{{ $cards_count }}"
          :cta="$card['cta']"
        ></x-card>
      </li>
    @endforeach
  </ul>
</div>
<script type="text/javascript">
  const news_info = {!! json_encode($cards); !!};
</script>
</section>