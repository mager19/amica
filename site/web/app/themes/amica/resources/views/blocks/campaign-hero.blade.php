<section data-block="{{ isset($block) ? 'true' : 'false' }}" class="{{ classNames([
    'section--campaign-hero py-full',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title(get_bloginfo()) }}-campaign-hero"
  aria-label="{!! get_bloginfo() !!}">
  <div class="fluid-container flex flex-col">
    @image('image', 'large', ['class' => 'grid-narrow-center rounded-image aspect-hero w-full object-cover'])
    @if(CURRENT_LANGUAGE === 'es')
    @svg('images.logo-es', ['class' => 'grid-narrow-center self-center text-center -mt-[8%] w-3/4 h-auto'])
    @else
    @svg('images.logo', ['class' => 'grid-narrow-center self-center text-center -mt-[8%] w-3/4 h-auto'])
    @endif

  </div>
</section>