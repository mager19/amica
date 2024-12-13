@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())
    <x-alert class="my-wide" type="warning">
      {!! __('Sorry, no results were found.', 'sage') !!}
    </x-alert>

    <div class="my-wide">{!! get_search_form(false) !!}</div>
  @endif

  @while(have_posts()) @php(the_post())
    <div class="my-wide">@include('partials.content-search')</div>
  @endwhile

  <div class="my-wide">{!! get_the_posts_navigation() !!}</div>
@endsection
