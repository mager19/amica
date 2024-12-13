{{--
  Template Name: Narrow w/ Page Title Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <div class="fluid-container">
      <div class="lg:w-3/4 lg:mx-auto">
      @include('partials.page-header', [
        'style'  => 'plain'
      ])
        @include('partials.content-page')
      </div>
    </div>
  @endwhile
@endsection
