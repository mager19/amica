<{{ $html }} {{ $attributes->class([$component_class]) }} {{ $attributes }}>
  @if(isset($icon) && $icon && !$slot->isEmpty())
    <span class="text">
  @endif
  {!! $slot !!}
  @if(isset($icon) && $icon)
    @if(!$slot->isEmpty())
    </span>
    @endif
    <span class="img">
      @svg('images.icons.' . $icon)
    </span>
  @endif
</{{ $html }}>