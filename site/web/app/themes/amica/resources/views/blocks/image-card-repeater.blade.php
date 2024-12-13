@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'border'  => false,
    'left' => false,
    'top'  => true
  ])
@endif
<section class="{{ classNames([
    'section--image-card-repeater',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  @include('partials.one-column', [
    'headingLevel'  => 'h2',
    'subhead'       => false,
    'card_subhead'  => $subhead,
    'layout'        => 'center',
    'mb'            => 'half',
    'class'         => 'pb-0'
  ])
  <div class="fluid-container">
    <ul class="{{ classNames([
      'grid list-none ml-0 pt-half',
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
          'col-span-full lg:col-narrow  aspect-8/5' => $cards_count === 1, // 1 Card
          '', // 2 cards
          'col-span-full lg:col-auto'   => $cards_count === 3, // 3 Cards
          'col-span-full md:col-span-6' => $cards_count > 3 && $index <= ( $cards_count - $cards_count%2 ), // 4 cards +, full row of 2
          'col-span-full'               => $cards_count > 3 && $index > ( $cards_count - $cards_count%2 ) && $cards_count%2 == 1, // 4 cards + remainder of 1 card
        ]) }}">

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
            cardHeadline="{!! !$is_folder_tab ? $app->truncateText($card['headline'], 80) : '' !!}"
            subhead="{!! $is_folder_tab ? $card['headline'] : '' !!}"
            copy="{!! $card['copy'] !!}"
            totalCards="{{ $cards_count }}"
            :cta="$card['cta']"
          ></x-card>
        </li>
      @endforeach
    </ul>
  </div>
</section>
