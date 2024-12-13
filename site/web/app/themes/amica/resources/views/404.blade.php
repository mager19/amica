@extends('layouts.app')

@section('content')
  @if (!have_posts())
    @include('blocks.c-t-a-full'
    , ['first_block' => '-mt-header']
    )
  @endif
@endsection
