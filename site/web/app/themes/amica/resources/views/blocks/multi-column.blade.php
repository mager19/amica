@set($emptyFields, true)
@if($columns)
@foreach($columns as $col)
@if(
  !empty($col['headline']) ||
  !empty($col['subhead']) ||
  !empty($col['copy'])
)
  @set($emptyFields, false)
  @break
@endif
@endforeach
@endif

@if(
  $block->preview ||
  (
    is_array($columns) && 
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
      'headline'  => 'Headline',
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
      'has_image' => false,
    ],
    [
      'headline'  => 'Headline',
      'subhead'   => 'Subhead',
      'copy'      => 'Copy goes here.',
      'cta'       => null,
      'has_image' => false,
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
    'section--multi-column',
    'bg-' . $background,
    'has-tab' => $folder_tab == true,
  ]) }}"
  id="{{ sanitize_title($headline) }}"
  aria-label="{!! $headline !!}"
>
  <div class="narrow-container flex flex-col gap-full">
    @if($eyebrow || $headline || $subhead || $copy)
      <div class="copy">
        @include('partials.one-column', [
        'headingLevel' => 'h2',
        'eyebrow' => $eyebrow,
        'headline' => $headline,
        'subhead' => $subhead,
        'copy' => $copy,
        'layout' => 'center',
      ])
      </div>
    @endif
    <ul class="{{ classNames([
      'grid lg:auto-cols-fr lg:grid-flow-col list-none ml-0 gap-wide',
      'lg:gap-narrow' => $columns && count($columns) > 3,
    ]) }}">
      @if($columns && is_array($columns))
        @foreach($columns as $column)
          <li class="{{ classNames([
              'before:border-t-2 before:border-dark before:w-10/12 before:self-center pt-inner' => $has_border,
              'flex flex-col gap-inner',
            ]) }}">
            @if($has_image && $column['image']) 
              <div class="media">
                @image($column['image']['ID'], 'card-top', ['class'  => 'w-full'])
              </div>
            @endif
            <div class="copy">
              @include('partials.copy', [
                'repeater'      => true,
                'align'         => $has_border ? 'center' : null,
                'eyebrow'       => null,
                'headline_size' => $has_border ? 3 : 2,
                'headline'      => $has_border ? $column['headline'] : null,
                'card_headline' => !$has_border ? $column['headline'] : null,
                'headingLevel'  => 'h3',
                'subhead'       => false,
                'card_subhead'  => $column['subhead'],
                'copy'          => $column['copy'],
                'copy_size'     => 2,
                'cta'           => $column['cta'],
                'cta_type'      => $has_border ? 'link' : null,
                'cta_icon'      => $has_border ? 'arrow-right' : null,
              ])
            </div>
          </li>
        @endforeach
      @else
        <li>
          @include('partials.copy', [
            'eyebrow'       => null,
            'headline'      => null,
            'card_headline' => 'This is a headline',
            'headingLevel'  => 'h3',
            'subhead'       => null,
            'card_subhead'  => 'This is a subhead',
            'copy'          => 'Lorem ipsum dolor sit amet consectetur. Ut tempus sit quam pellentesque justo viverra.',
            'copy_size'     => 2,
            'cta'           => [
              'url'     => '#',
              'title'   => 'Button action',
              'target'  => '_self',
            ],
          ])
        </li>
      @endif
    </ul>
  </div>
</section>
@endif