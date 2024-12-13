<div {{ $attributes->merge([
  'class' => 'alert alert-' . $type . ' ' . $background . ' h-12 text-center flex items-center justify-center z-40 leading-none subhead-1 lg:leading-none'
]) }}>

  @if($url)
    <a class="" href="{{ $url }}">
  @endif

    <div class="w-4 h-4 mr-2 inline-block">   
      <svg width="auto" height="100%" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.93359 5.01172L8 6.94531L6.06641 5.01172L5.01172 6.06641L6.94531 8L5.01172 9.93359L6.06641 10.9883L8 9.05469L9.93359 10.9883L10.9883 9.93359L9.05469 8L10.9883 6.06641L9.93359 5.01172ZM8 0.511719C3.85156 0.511719 0.511719 3.85156 0.511719 8C0.511719 12.1484 3.85156 15.4883 8 15.4883C12.1484 15.4883 15.4883 12.1484 15.4883 8C15.4883 3.85156 12.1484 0.511719 8 0.511719ZM8 14.0117C4.69531 14.0117 1.98828 11.3047 1.98828 8C1.98828 4.69531 4.69531 1.98828 8 1.98828C11.3047 1.98828 14.0117 4.69531 14.0117 8C14.0117 11.3047 11.3047 14.0117 8 14.0117Z" fill="currentColor"/>
      </svg>   
    </div>
    <span>{!! $message ?? $slot !!}</span>

  @if($url)
    </a>
  @endif
</div>

