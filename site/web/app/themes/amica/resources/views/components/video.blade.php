<div {{ $attributes->merge(['class' => 'component--video w-full h-full']) }}>
  @if($video_file)
    <div class="plyr-video component--video_plyr" data-controller="plyr">
      <video id="player" playsinline controls captions data-poster="{{ $poster_file }}" data-plyr-config="{{ json_encode($settings) }}" aria-label="{!! $label !!}">
        <source src="{{ $video_file }}" type="video/mp4" />
        <p>
          Your browser doesn't support HTML video. Here is a
          <a href="{{ get_field('video', false, false) ?: $video_file }}" download="{{ $video_file }}">link to the video</a> instead.
        </p>
        @if($captions_file)<track kind="captions" label="English captions" src="{{ $captions_file }}" srclang="en" default />@endif
      </video>
    </div>
  @elseif($video_embed)
    <div class="plyr-video component--video_plyr" 
        data-controller="plyr"
        data-plyr-settings-value="{{ json_encode($settings) }}">
        {!! $video_embed !!}
    </div>
  @endif
</div>