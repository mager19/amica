@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'left' => false,
    'top'  => true,
    'border' => false,
  ])
@endif

<section class="{{ classNames([
    'section--one-column-embed',
    'bg-' . $background,
    'has-tab' => $folder_tab == true,
  ]) }}" 
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  @if(!$is_headline_hidden)
    @include('partials.copy', [
      'class' => 'mb-half',
      'align' => 'center',
      'headingLevel' => 'h2',
    ])
  @endif
  <div class="fluid-container grid-12 col-span-full mt-0">
    <div class="col-narrow">
      @isset($code)
        <script type='text/javascript' src='https://static.everyaction.com/ea-actiontag/at.js' crossorigin='anonymous'></script>
          {!! $code !!}
      @endisset
      @isset($gravityforms)
        {!! gravity_form($gravityforms['id'], false, false, false, null, false) !!}
      @endisset
    </div>
  </div>
</section>