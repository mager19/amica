@extends('layouts.app')
@section('content')
  @if (! have_posts())
    <x-alert class="my-wide" type="warning">
      {!! __('Sorry, no posts have been made yet.', 'sage') !!}
    </x-alert>

    <div class="my-wide">{!! get_search_form(false) !!}</div>
  @endif

  @while(have_posts()) @php(the_post())
    @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
  @endwhile

  <div class="my-wide">{!! get_the_posts_navigation() !!}</div>
@endsection

@section('sidebar')
  @include('partials.sidebar')
@endsection
