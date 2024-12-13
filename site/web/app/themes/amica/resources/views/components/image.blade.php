<figure>
  @if($caption && $align_y == 'top')<p class="ui-text caption mb-1.5 mt-0 text-{{ $align_x }} {{ $caption_class }}">{!! $caption !!}</p>@endif
  @image($id, $size, [ 'class'  => $class ])
  @if($caption && $align_y == 'bottom')<p class="ui-text caption my-0 text-{{ $align_x }} {{ $caption_class }}">{!! $caption !!}</p>@endif
</figure>