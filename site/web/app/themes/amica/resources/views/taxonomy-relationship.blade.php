@extends('layouts.app')

@section('content')
@php
    if( is_tax() ) {
      global $wp_query;
      $term = $wp_query->get_queried_object();
      $tax_name = $term->name;
      $tax_description = $term->description;
  }
@endphp
  <section class="{{ classNames([
      'section--one-column',
      'bg-white',
    ]) }}" aria-label="{!! $tax_name !!}">
    @include('partials.one-column', [
      'headline' => $tax_name,
      'subhead' => $tax_description,
      'headingLevel' => 'h1',
    ])
  </section>
  <section class="">
    <div class="fluid-container grid-posts">
      @while (have_posts()) @php the_post() @endphp
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content-single'])
      @endwhile
    </div>
  </section>
@endsection