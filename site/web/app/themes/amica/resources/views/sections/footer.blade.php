
<footer class="bg-dark">
  @include('partials.foldertab', [
    'color' => 'dark',
    'left' => false,
    'top'  => true
  ])
  <div class="site-footer pt-full -mt-1">
    <div class="footer-nav fluid-container flex items-center justify-between">
      <div class="mx-auto text-center flex flex-wrap flex-col md:flex-row justify-between gap-full lg:text-left">
        <div id="footer--logo" class="pb-inner md:pb-0 w-full lg:w-auto lg:flex-1">
          <a href="{{ home_url('/') }}" class="footer-nav--brand">
            @if(CURRENT_LANGUAGE === 'es')
              @svg('images.logo-es', ['class' => 'brand--logo max-w-72 mx-auto lg:mx-0'])
            @else
              @svg('images.logo', ['class' => 'brand--logo max-w-72 mx-auto lg:mx-0'])
            @endif
          </a>
          @if($socials)
            <div class="w-full max-w-72 mt-half mx-auto lg:mx-0">
              <x-eyebrow html="h2" class="mb-2 sr-only">{{ __('Join Us', 'amica')}}</x-eyebrow>
              <ul class="nav flex flex-row justify-between">
                @foreach($socials as $key => $social)
                  @if($social && !is_array($social))
                    <li>
                      <a href="{{ $social }}" target="_blank" class="leading-normal text-[1.75rem] inline-flex gap-min items-center border-none hover:border-none group">
                        <span class="group-hover:text-var-hover-color {{ getFAIcon(strtolower($key)) }}" aria-hidden="true"></span>
                        <span class="sr-only">{!! $key !!}</span>
                      </a>
                    </li>
                  @elseif(is_array($social))
                    @foreach($social as $custom_social)
                      <li class="!mb-0">
                        <a href="{{ $custom_social['url'] }}" target="_blank" class="font-bold leading-normal inline-flex gap-min items-center border-none hover:border-none group">
                          <span class="custom-social group-hover:text-var-hover-color {{ $custom_social['icon'] }}" aria-hidden="true"></span>
                          <span class="sr-only">{!! $custom_social['name'] !!}</span>
                        </a>
                      </li>
                    @endforeach
                  @endif
                @endforeach
              </ul>
            </div>
          @endif
        </div>
        <div id="footer--contact" class="flex-1">
          <div class="footer--contact-addresses flex flex-col gap-inner">
            @foreach($addresses as $item)
              <address>
                <p>{!! $item['address']['street_line_1'] !!}</p>
                @if(isset($item['address']['street_line_2']))
                  <p>{!! $item['address']['street_line_2'] !!}</p>
                @endif
                <p>{!! $item['address']['city'] !!}, {!! $item['address']['state'] !!}, {!! $item['address']['postal_code'] !!}</p>
              </address>
            @endforeach
          </div>
        </div>
        <div id="footer--details" class="flex-1">
          @if (has_nav_menu('footer_details'))
            <div class="">
              <nav class="w-full" aria-label="{{ wp_get_nav_menu_name('footer_details') }}">
                {!! wp_nav_menu([
                  'container'       => false,
                  'theme_location'  => 'footer_details',
                  'menu_class'      => 'list-none ml-0 flex flex-col gap-2 lg:gap-4',
                  'echo'            => false,
                ]) !!}
              </nav>
            </div>
          @endif
        </div>
        <div id="footer--legal" class="flex-1">
          <p>{{ __('Amica Center is a 501(c)(3) nonprofit organization. Tax EIN: 52-2141497', 'amica') }}</p>
          <p>
            {{ __('Copyright ©', 'amica') }} {{ date('Y')}}, {!! $copyright !!}
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-dark footer-extra">
    <div class="fluid-container py-half">
      <div class="flex flex-col items-center lg:flex-row lg:justify-between gap-y-full">
        @if (has_nav_menu('footer_navigation'))
          <div id="footer-extra--buttons">
            <x-eyebrow html="h2" class="mb-inner sr-only">{{ __('Explore', 'amica') }}</x-eyebrow>
            <nav class="w-full" aria-label="{{ wp_get_nav_menu_name('footer_navigation') }}">
              {!! wp_nav_menu([
                'container'       => false,
                'theme_location'  => 'footer_navigation',
                'menu_class'      => 'list-none ml-0 flex gap-half flex-col md:flex-row',
                'echo'            => false,
                'walker'          => new FooterNavigationWalker()
              ]) !!}
            </nav>
          </div>
        @endif
        @if (count($validation_logos) > 0)
          <ul id="footer-extra--badges" class="list-none ml-0 flex gap-half flex-row flex-wrap">
            @foreach($validation_logos as $logo)
              <li class="!mb-0">
                <a href="{{ $logo['organization']['url'] }}" target="_blank" 
                  class="inline-flex gap-min items-center border-none hover:border-none w-20">
                  @image($logo['icon']['ID'], 'full', $logo['organization']['title'])
                </a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>
</footer>
