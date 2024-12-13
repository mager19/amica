@extends('layouts.app')

@section('content')
@php
// Blog Post page query and content
$post = get_queried_object();
setup_postdata( $post );
@endphp
<section class="fluid-container">
  @include('blocks.one-column', [
    'eyebrow' => __('Archive', 'amica'),
    'headline' => $post->name,
    'background' => 'white',
    'layout' => 'center',
    'class' => 'pb-4'
  ])
@php
wp_reset_postdata();
@endphp
  <x-category-filter></x-category-filter>

  <div class="grid-posts">
    @while(have_posts()) @php(the_post())
    @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
    @endwhile
  </div>

</section>

  {{-- <div class="my-wide">{!! get_the_posts_navigation() !!}</div> --}}
@endsection
