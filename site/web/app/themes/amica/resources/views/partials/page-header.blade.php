
 <div class="post--header mx-auto px-narrow {{ get_post_type($post) === 'case' ? 'pt-full' : '' }}">
  <div class="fluid-container">
    <div class="lg:w-3/4 lg:mx-auto">
      @if($post_image)
        <div class="post--image py-full">
          @image($post_image['ID'], 'full', [
            'class' => 'mx-auto w-full aspect-64/37 object-cover position-bottom',
            'alt' => $post_image['alt']
          ])
        </div>
      @endif
      @include('partials.copy', [
        'class' => 'post--hero-copy',
        'eyebrow' => $byline,
        'headline' => $title,
        'subhead' => has_excerpt() ? get_the_excerpt() : null,
      ])
    </div>
  </div>
</div>
