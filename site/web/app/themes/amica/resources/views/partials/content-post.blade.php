@php
  $eyebrow = null;
  $cta = [
    'url' => get_permalink(),
    'title' => false,
    'show'  => false,
  ];
  $excerpt = short_get_the_excerpt($post->id);
  $category_class = '';
  foreach ( get_the_category() as $category ) {
    $eyebrow .= $eyebrow ? ", " : '';
    $eyebrow .= $category->name;

    $category_class .= 'category-' . $category->slug . ' ';
  };
  // format date by language
  $dateFormat = apply_filters( 'wpml_current_language', NULL ) !== 'es' ? 'm/d/y' : 'd/m/y';
  $eyebrow = $eyebrow . " - ". get_the_date($dateFormat);
@endphp
<article @php(post_class('partial--content'))>
  {{-- @dump($excerpt) --}}
  <x-card
    :cta="$cta"
    :image="['ID' => get_post_thumbnail_id()]"
    :image-bg="false"
    padding="inner"
    eyebrow="{!! $eyebrow !!}"
    subhead="{!! $title !!}"
    copy="{!! $excerpt !!}"
    total-cards="9"
    class="{{ classNames('justify-end',[
      $category_class => $category_class
    ]) }}"
    repeater="true"
  ></x-card>
</article>
