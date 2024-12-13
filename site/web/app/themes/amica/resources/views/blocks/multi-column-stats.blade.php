@set($emptyFields, true)
@foreach($columns as $col)
  @if(
    !empty($col['stat']) ||
    !empty($col['subhead']) ||
    !empty($col['copy'])
  )
    @set($emptyFields, false)
    @break
  @endif
@endforeach

@if(
  $block->preview ||
  (
    count($columns) >= 2 &&
    !$emptyFields
  )
)

{{--
  define the variables if they're empty
  to provide content in Preview mode
--}}
@if(
  $emptyFields
)
  @set($columns, [
    [
      'stat'  => 'Stat',
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
    ],
    [
      'stat'  => 'Stat',
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
    ]
  ])
@endif


@if($folder_tab == true)
  @include('partials.foldertab', [
    'color' => $background,
    'border'  => false,
    'left' => false,
    'top'  => true
  ])
@endif

<section class="{{ classNames([
    'section--multi-column-stats',
    'bg-' . $background,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  <div class="fluid-container flex flex-col gap-full">
    @if($eyebrow || $headline || $subhead || $copy)
      <div class="copy">
        @include('partials.one-column', [
          'headingLevel' => 'h2',
          'headline_size' => 2,
          'eyebrow' => $eyebrow,
          'headline' => $headline,
          'subhead' => $subhead,
          'copy' => $copy,
          'layout' => 'center',
          'mb'      => 'half',
        ])
      </div>
    @endif
    <ul class="{{ classNames([
      'grid lg:auto-cols-fr lg:grid-flow-col list-none ml-0 gap-half lg:gap-narrow'
    ]) }}" data-controller="content-responsive">
      @if($columns)
        @foreach($columns as $column)
          <li class="flex gap-inner" data-content-responsive-target="vessel">
            <div class="copy flex flex-col">
              <x-display size="1" html="h3" class="mb-inner inline-block flex items-end h-full lg:max-h-24" data-content-responsive-target="content">
                {!! $column['stat'] !!}
              </x-display>
              @include('partials.copy', [
                'headline'  => null,
                'subhead'   => $column['subhead'],
                'eyebrow'   => null,
                'copy'      => $column['copy'],
                'copy_size' => 2,
                'cta'     => $column['cta'],
              ])
            </div>
          </li>
        @endforeach
      @else
        <li>
          <x-display size="1">Stat</x-display>
          @include('partials.copy', [
            'headline'  => 'Subhead',
            'copy'      => 'Copy goes here.',
            'cta'       => [
              'url'    => '#',
              'title'  => 'Button action',
              'target' => '_self',
            ],
            'cta_type' => 'link'
          ])
        </li>
      @endif
    </ul>
  </div>
</section>
@endif