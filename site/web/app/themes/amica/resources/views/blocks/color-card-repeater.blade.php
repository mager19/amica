@if(count($cards) > 0 || $block->preview)


@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'border'  => false,
    'left' => false,
    'top'  => true
  ])
@endif

<section class="{{ classNames([
    'section--color-card-repeater',
    'bg-' . $background,
    'has-tab' => $folder_tab == true,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  @if(!$is_headline_hidden)
    @include('partials.one-column', [
      'headingLevel' => 'h2',
      'subhead'      => $subhead,
      'layout'       => 'center',
      'mb'           => 'half'
    ])
  @else
    <x-subhead class="sr-only" html="h2">{!! $headline !!}</x-subhead>
  @endif
  <div class="fluid-container">
    <ul class="{{ classNames([
      'grid list-none ml-0',
      'pt-half' => $subhead || $headline,
      'gap-wide' => $cards_count < 3,
      'gap-narrow' => $cards_count >= 3,
      'grid-12 lg:grid-cols-none lg:auto-cols-fr lg:grid-flow-col' => $cards_count <= 4 && $cards_count > 1,
      'grid-12' => $cards_count > 4 || $cards_count == 1,
    ]) }}">
      @foreach($cards as $key => $card)
        @php
          $index = $key + 1;
        @endphp
        <li class="{{ classNames([
          'col-span-full',
          'lg:col-narrow'     => $cards_count === 1,
          'md:col-span-6'     => $cards_count !== 1,
          'lg:col-auto'       => $cards_count <= 4 && $cards_count > 1,
          'lg:col-span-full'  => $cards_count > 4  && $index >  ( $cards_count - $cards_count%4 ) && $cards_count%4 == 1, // one extra card
          // ''               => $cards_count > 4  && $index >  ( $cards_count - $cards_count%4 ) && $cards_count%4 == 2, // two extra cards
          'lg:col-span-4'     => $cards_count > 4  && $index >  ( $cards_count - $cards_count%4 ) && $cards_count%4 == 3, // three extra cards
          'lg:col-span-3'     => $cards_count > 4  && $index <= ( $cards_count - $cards_count%4 ), // 4 extra cards
        ]) }}">
          <x-card
            repeater="true"
            eyebrow="{{ $card['eyebrow'] }}"
            padding="inner"
            subhead="{{ $card['headline'] }}"
            subheadEl="h3"
            copy="{!! $card['copy'] !!}"
            totalCards="{{ $cards_count }}"
            :cta="$card['cta']"
        ></x-card>
        </li>
      @endforeach
    </ul>
  </div>
</section>
@endif