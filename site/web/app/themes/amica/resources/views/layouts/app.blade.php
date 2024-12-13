<a class="sr-only focus:not-sr-only focus:absolute" href="#main">
  {{ __('Skip to content') }}
</a>

@include('sections.header')

<main id="main" class="{{ classNames(
  'main wrap flex-1',
)}}">
  @yield('content')

  @hasSection('modal')
    @yield('modal')
  @endif
</main>

@include('sections.footer')
