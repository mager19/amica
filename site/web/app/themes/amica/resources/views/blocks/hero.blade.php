@if(isset($block) &&
  $block->preview ||
  (
    $eyebrow ||
    $headline ||
    $subhead
  )
)

{{--
  define the variables if they're empty
  to provide content in Preview mode
--}}
@if(
  empty($eyebrow) &&
  empty($headline) &&
  empty($subhead)
)
  @set($eyebrow, 'Eyebrow')
  @set($headline, 'Headline')
  @set($subhead, 'Subhead copy goes here')
@endif

<section data-block="{{ isset($block) ? 'true' : 'false' }}" class="{{ classNames([
    'section--hero',
    'section--hero-' . $layout,
    'bg-' . $background => $layout != 'folder' || $layout != 'overlay-full',
    'grid-half' => $layout == 'right' || $layout == 'left',
    'text-center auto-rows-min !min-h-auto' => $layout == 'overlay-megatext',
    'p-0' => $layout == 'folder',
    'pt-0 pb-max' => $layout == 'overlay-full',
    'py-max' => $layout == 'contained' || $layout == 'overlay-megatext',
    'py-0' => $layout == 'right' || $layout == 'left',
    'pt-full pb-max' => $layout == 'overlay-contained' || $layout == 'megatext',
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}" 
  @if( $layout == 'overlay-full' && isset($image['url']) ) style="--background-image: url('{!! $image['url'] !!}')"@endif
>
  @if($layout == 'right' || $layout == 'left')
    @include('partials.two-columns', ['headline_size' => strlen($headline) < 70 ? 1 : 2, 'headingLevel' => 'h1'])
  @elseif($layout == 'contained')
    @include('partials.one-column', ['headline_size' => 1, 'headingLevel' => 'h1'])
  @elseif($layout == 'megatext')
    <div class="fluid-container">
      @include('partials.copy', [
        'class' => $folder_tab ? 'pb-full' : null,
        'padding' => 'half',
        'headline_size' => 'super',
        'headingLevel' => 'h1'
      ])

    @if( $folder_tab == true )
      @include('partials.foldertab', [
        'color' => 'dark',
        'border'  => true,
      ])
    @endif
    </div>
  @elseif($layout == 'folder')
    @if( isset($image['url']) ) 
      <div 
        class="bg-image aspect-hero bg-cover flex justify-end items-end"
        style="--background-image: url('{!! $image['url'] !!}')"
      >
        @if(wp_get_attachment_caption($image['id']))<p class="ui-text overlay caption my-0 p-min">{!! wp_get_attachment_caption($image['id']) !!}</p>@endif
      </div>
    @endif
    <div class="bg-{{ $background }} self-end">
      @include('partials.foldertab', ['top' => true, 'border' => false, 'color' => 'background'])
      <div class="grid-container">
        @include('partials.copy', [
          'class' => 'py-full grid-narrow-left',
          'headline_size' => 'super',
          'headingLevel' => 'h1'
        ])
      </div>
    </div>
  @elseif($layout == 'overlay-contained')
    <div class="fluid-container">
      <x-image
        id="{{ $image['ID'] }}"
        size="large"
        class="grid-narrow-center rounded-image aspect-hero w-full object-cover"
        alignY="top"
        alignX="right"
      ></x-image>
      @include('partials.copy', [
        'class' => 'grid-narrow-center text-center mt-overlay-mega' . ($folder_tab ? ' pb-full' : null),
        'headline_size' => 'mega',
        'padding' => 'half',
        'copy_size' => 'secondary-1 lg:narrow-container',
        'headingLevel' => 'h1
      '])
      <div class="grid-narrow-center">
        @if( $folder_tab == true )
          @include('partials.foldertab', [
            'color' => 'dark',
            'border'  => true,
          ])
        @endif
      </div>
    </div>
   
  @elseif($layout == 'overlay-full')
    @if( isset($image['url']) ) 
      <div 
        class="bg-image aspect-hero bg-cover flex justify-end items-end"
        style="--background-image: url('{!! $image['url'] !!}')"
      >
        @if(wp_get_attachment_caption($image['id']))<p class="ui-text overlay caption my-0 p-min">{!! wp_get_attachment_caption($image['id']) !!}</p>@endif
      </div>
    @endif
    <div class="grid-container bg-{{ $background }} self-end -mb-px">
      @include('partials.copy', [
        'class' => 'grid-narrow-left mt-overlay-super',
        'headline_size' => 'super',
        'headingLevel' => 'h1'
      ])
    </div>
  @elseif($layout == 'overlay-megatext')
    <div class="fluid-container mb-[1.25%]">
      @include('partials.copy', [
        'headline_size' => 'mega',
        'headingLevel' => 'h1',
        'eyebrow' => null,
        'cta' => null,
        'subhead' => null,
        'copy' => null,
      ])
    </div>

    <x-image
      id="{{ $image['ID'] }}"
      size="large"
      class="aspect-hero w-full object-cover"
      captionClass="mt-caption overlay caption p-min text-white"
      alignY="bottom"
      alignX="right"
    ></x-image>
    <div class="grid-container pt-full">
      @include('partials.copy', [
        'class' => 'grid-narrow-center',
        'eyebrow' => null, 
        'headline' => null
      ])
    </div>
  @endif
</section>
@endif