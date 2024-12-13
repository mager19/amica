@set($repeater, isset($repeater) ? $total_cards > 1 : false)

<{{ $html }} {{ $attributes->class([$component_class]) }} {{ $attributes }}>
{{-- component--card --}}
  @if($cta)
    <a href="{!! $cta['url'] !!}" target="{{ isset($cta['target']) ? $cta['target'] : '' }}" aria-label="{!! $headline ?: $card_headline !!}"
  @else
    <div
  @endif
    class="{{ classNames([
      'card group',
      'card-solid'   => $image == null,
      'card-image'   => $image !== null,
      'card-folder'  => $is_folder_tab,
      'bg-image'     => $imageBg,
      'aspect-[5/4]' => $imageBg && $total_cards == 2,
      'aspect-[4/5]' => $imageBg && $total_cards >= 3,
      'lg:flex-row'  => $total_cards == 1,
    ]) }}"
    >
    @if (isset($image['ID']) && $image['ID'])
      <div class="{{ classNames([
        'component--card-image',
        'lg:order-2'  => $total_cards == 1,
        'aspect-64/37 lg:w-1/2'  => $repeater == false && !$imageBg, //card-inset
        'aspect-8/5'  => $repeater == true && !$imageBg, // card-top
        'w-full h-full absolute top-0 left-0 z-under-content' => $imageBg,
      ]) }}">
        @set($imageClass, 'w-full h-full')
        @image($image['ID'], 'card-background', ['class'=> $imageClass .' object-cover transition duration-[0.420s] lg:group-hover:scale-[1.0420] lg:group-focus:scale-[1.0420]'])
      </div>
    @endif
    @if($is_folder_tab && $total_cards > 1)
      @include('partials.foldertab', [
        'color' => 'background',
        'left' => false,
        'top'  => true
      ])
    @endif
    @include('partials.copy', [
      'class'     => classNames([
        'in-card component--card-copy z-content p-half ',
        'lg:order-1'        => $total_cards == 1 && !$is_folder_tab,
        'lg:w-1/2 is-solo'  => $repeater == false,
        'h-full'            => $imageBg,
      ]),
      'layout'    => 'stretch',
      'padding'       => $padding,
      'eyebrow'       => $eyebrow,
      'headline'      => $headline,
      'card_headline' => $card_headline,
      'headingLevel'  => $headingLevel,
      'subhead'       => $subhead,
      'card_subhead'  => $card_subhead,
      'subhead_el'    => $subhead_el,
      'copy'          => $copy,
      'copy_size'     => 2,
      'cta'           => isset($cta['show']) && $cta['show'] == false ? null : [
        'title'   => isset($cta['title']) &&  $cta['title'] !== null ? $cta['title'] : null,
        'url'     => isset($cta['url']) ? $cta['url'] : '',
        'target'  => '',
      ],
      'cta_size'  => isset($cta_size) ? $cta_size : 'large',
      'cta_type'  => isset($cta_type) ? $cta_type : null,
      'cta_html'      => 'span',
      'cta_icon'  => isset($cta_icon) ? $cta_icon : null,
    ])


  @if($cta)
    </a>
  @else
    </div>
  @endif
</{{ $html }}>