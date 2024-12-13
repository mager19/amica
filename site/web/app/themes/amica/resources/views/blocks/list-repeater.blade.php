@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'border'  => false,
    'left' => false,
    'top'  => true
  ])
@endif
@if(count($list) > 0)
<section class="{{ classNames([
    'section--list-repeater',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  @include('partials.copy', [
    'headingLevel'  => 'h2',
    'headline_size' => '1',
    'mb'            => 'full',
    'class'         => 'fluid-container'
  ])
  <div class="fluid-container">
    <ul class="list-repeater--list flex flex-col gap-full list-none ml-0">
      @foreach($list as $key => $item)
        @php
          $index = $key + 1;
        @endphp
        <li class="grid lg:grid-12 gap-y-inner gap-x-full">
          <div class="foldertab z-higher-content relative h-min col-span-full lg:col-span-3 border-b-[6px]
                      text-var-text border-var-text
          ">
            <svg class="hidden text-inherit lg:flex -mb-px" width="58" height="14" viewBox="0 0 58 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M54.3855 3.96646C53.5281 1.58654 51.2702 0 48.7406 0H0V14H58L54.3855 3.96646Z" fill="currentColor"/>
            </svg>

            <svg class="hidden text-inherit md:flex lg:hidden -mb-px" width="80" height="14" viewBox="0 0 80 14"  fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M76.3855 3.96646C75.5281 1.58654 73.2702 0 70.7406 0H0V14H80L76.3855 3.96646Z" fill="currentColor"/>
            </svg>

            <svg class="flex text-inherit md:hidden -mb-px" width="88" height="16" viewBox="0 0 88 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M78.334 0H0V16H88L84.5314 4.01284C83.8509 1.66078 81.2861 0 78.334 0Z" fill="currentColor"/>
            </svg>
          </div>

          @include('partials.copy', [
            'class' => 'col-span-full lg:col-span-9',
            'headline' => $item['headline'],
            'copy' => $item['copy'],
            'cta' => $item['cta'],
            'subhead' => false,
            'card_subhead' => false,
            'headline_size' => 3,
            'cta_type' => 'link',
            'cta_icon' => 'arrow-right',
          ])
        </li>
      @endforeach
    </ul>
  </div>
</section>
@endif