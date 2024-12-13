    @if($list)
      <ul class="sticky--list list-none ml-0 flex flex-col gap-full">
        @foreach ($list as $index => $item)
          <li class="flex flex-col gap-4">
            @if($item['image'])
              <div class="media">
                @image($item['image']['ID'], 'wide', ['class'  => 'w-full mb-2 !aspect-2/1'])
              </div>
            @endif
            @if($show_numbers)<x-eyebrow>{{ sprintf("%02d", $index + 1) }}</x-eyebrow>@endif
            @include('partials.copy', [
              'padding'       => 'min',
              'eyebrow'       => false,
              'headline'      => false,
              'card_headline' => $item['subhead'],
              'headline_size' => 2,
              'headingLevel'  => 'h3',
              'subhead'       => false,
              'copy'          => $item['copy'],
              'copy_size'     => 2,
              'cta'           => null,
            ])
            @if($item['cta'] !== '' && $item['cta']['title'] !== false)
              <p class="sticky--copy-cta">
                <x-button
                  type="link"
                  icon="arrow-right"
                  html="a"
                  href="{{ $item['cta']['url'] }}"
                  target="{{ $item['cta']['target'] }}"
                >
                  {!! $item['cta']['title'] !!}
                </x-button>
              </p>
            @endif
          </li>
        @endforeach
      </ul>
    @endif