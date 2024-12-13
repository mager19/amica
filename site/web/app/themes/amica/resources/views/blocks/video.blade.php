<section class="{{ classNames([
    'section--video relative',
    'bg-' . $background,
    'pb-0' => $layout == 'fullscreen',
    'pt-0' => $layout == 'fullscreen' && $is_headline_hidden,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  @if( !$is_headline_hidden )
    @include('partials.one-column', [
      'headline_size'      => 1,
      'headingLevel' => 'h2',
      'layout'  => 'center',
      'mb'      => 'full'
    ])
  @else
  <h2 class="sr-only">{!! $headline !!}</h2>
  @endif
  <div class="{{ classNames([
    'section-video--embed',
    'w-full' => $layout === 'fullscreen',
    'container grid-12 col-span-full z-content' => $layout == 'default',
  ])}}">
  @if($layout == 'default')
    <div class="col-narrow text-center">
  @endif
      @if ($video_embed || $video_file)
        <div class="{{ classNames([
          'col-span-full md:col-span-10 md:col-start-2 overflow-hidden',
        ])}}">
          <x-video
            videoFile="{{ $video_file }}"
            captionsFile="{{ $captions_file }}"
            posterFile="{{ $poster_file }}"
            :videoEmbed="$video_embed"
            :settings="$settings"
            label="{!! $headline !!}"
          ></x-video>
        </div>
      @else
        @if($block->preview)
          <div class="col-span-6 col-start-4 p-inner">
            <p>Upload video in the sidebar.</p>
          </div>
        @endif
      @endif
  @if($layout == 'default')
    </div>
  @endif
  </div>
</section>
