<header class="{{ classNames([
    'site-header',
    'type-fixed'  => $nav_type == 'fixed',
    'type-shy'    => $nav_type == 'shy',
  ]) }}"
  data-controller="header"
  data-header-type-value="{{ $nav_type }}"
  data-action="resize@window->header#getHeights"
  aria-label="Site Navigation header"
>
  @include('partials.alert-bar')
  <div class="{{ classNames([
      'site-header--wrapper',
      'has-alert' => $alert,
    ]) }}" 
    id="site-header--wrapper"
    data-header-target="header"
  >
    <div class="site-header--container">
      <div class="site-brand">
        <a href="{{ home_url('/') }}" data-header-target="logo">
          @if(CURRENT_LANGUAGE === 'es')
            @svg('images.logo-nav-es', 'brand--logo', ['data-header-target' => 'logoSvg'])
          @else
            @svg('images.logo-nav', 'brand--logo', ['data-header-target' => 'logoSvg'])
          @endif
        </a>
      </div>

      @if (has_nav_menu('secondary_navigation'))
        <nav class="site-nav secondary-nav--wrapper" aria-label="{{ wp_get_nav_menu_name('secondary_navigation') }}">
          <div class="{{ $secondary_nav_class }}" id="secondary-navigation" data-header-target="second_nav">
            {!! wp_nav_menu([
              'theme_location'  => 'secondary_navigation',
              'container'       => false,
              'menu_class'      => $secondary_menu_class,
              'walker'          => new PrimaryNavigationWalker()
            ]) !!}
          </div>
        </nav>
      @endif

      <button class="hamburger hamburger--squeeze" type="button"
            aria-label="Mobile Menu button" aria-controls="navigation" data-header-target="toggler"
            data-action="header#toggleNav">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
      <div class="header-scroll-screen"></div>
      @if (has_nav_menu('primary_navigation'))
        <nav class="site-nav primary-nav--wrapper" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
          @if (has_nav_menu('primary_navigation'))
            <div class="{{ $nav_class }}" id="navigation" data-header-target="nav">
              {!! wp_nav_menu([
                'theme_location'  => 'primary_navigation',
                'container'       => false,
                'menu_class'      => $menu_class,
                'walker'          => new PrimaryNavigationWalker()
              ]) !!}
            </div>
          @endif
        </nav>
      @endif
    </div>
  </div>
</header>
  