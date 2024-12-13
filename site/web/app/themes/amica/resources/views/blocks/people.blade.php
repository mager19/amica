@if(isset($block) &&
  $block->preview ||
  (
    $headline ||
    $copy
  )
)

{{--
  define the variables if they're empty
  to provide content in Preview mode
--}}
@if(
  empty($headline) &&
  empty($copy)
)
  @set($headline, 'Group Type')
  @set($copy, 'Type description goes here. ')
@endif

<section class="bg-white {{ $block->classes }}" style="{{ $block->inlineStyle }}">

  @if ($headline)
    @include('partials.one-column', [
      'layout' => 'center',
      'headingLevel' => 'h2',
      ])

    @if($items)
<div class="fluid-container mt-full">
    <ul class="{{ classNames([
      'grid list-none ml-0 gap-y-wide gap-x-narrow md:grid-cols-2',
      'lg:grid-cols-' . $columns => $columns,
    ]) }}">
      @if($items)
        @foreach($items as $item)
          <li class="{{ classNames([
              // 'before:border-t-2 before:border-dark before:w-10/12 before:self-center pt-inner' => $has_border,
              'flex flex-col',
              'text-center justify-center' => $term == 'fellowship-partners' || $term == 'local-agency-partners',
            ]) }}">
            <div class="copy flex flex-col gap-y-min">
              @if($item['partner_logo'] && ($term == 'fellowship-partners' || $term == 'local-agency-partners'))
                <div class="component--image-grid--outer rounded-image aspect-square bg-[#FFF] overflow-hidden w-full p-min ]">
                  @image($item['partner_logo']['ID'], 'medium', ['class' => 'w-full h-full object-cover swell-image-scale max-w-[300px', 'alt' => $item['name']])
                </div>
              @else
                @if($item['name'])
                  <x-subhead size="2" html="h3">
                    {!! $item['name'] !!}
                  </x-subhead>
                @endif
                @if($item['title'] || $item['program'])
                  <div class="flex gap-2 flex-col">
                    @if($item['title']) <x-subhead size="3">{!! $item['title'] !!}</x-subhead>@endif
                    @if($item['program']) <p class="body body-2">{!! $item['program'] !!}</p>@endif
                  </div>
                @endif
                @if($item['email'])
                  <p class="m-0 pt-3">
                    <x-button type="link" icon="arrow-right" class="!ui-text" html="a" href="mailto:{{ $item['email'] }}">{{ _e("Message", 'amica') }} {!! $item['name'] !!}</x-button>
                  </p>
                @endif
              @endif
            </div>
          </li>
        @endforeach
      @endif
    </ul>
</div>
    @else
      
    @endif
  @else
    <p class="text-center">{{ $block->preview ? 'Select a type on the right panel' : 'No items found!' }}</p>
  @endif

</section>
@endif