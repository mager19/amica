<article @php(post_class())>
  <div class="partial--content-single post-content">
    <div class="fluid-container">
      <div class="lg:w-3/4 lg:mx-auto">
        <x-subhead size="2">Decision date: {!! get_field('date') !!}</x-subhead>
        <x-body size="1">{!! get_field('description') !!}</x-body>
        <x-body class="mb-1" size="1">Publication Status: {{ get_field('is_published') ? __('Published', 'amica') : __('Unpublished', 'amica') }}</x-body>
        <x-body class="mb-1" size="1">Case judge: {!! getPostTaxonomies($post, 'judge', 'inline')['names'] !!}</x-body>
        <x-body class="mb-0" size="1">Decision: <a href="{!! get_field("case_pdf")['url'] !!}" target="_blank">{!! get_field("case_pdf")['title'] !!}</a></x-body>
      </div>
    </div>
  </div>
</article>
