{{--
  Template Name: 4th Circuit Cases
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @includeFirst(['partials.content-page', 'partials.content'])
  @endwhile
@endsection
