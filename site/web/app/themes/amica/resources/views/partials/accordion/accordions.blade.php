<div class="accordion--panels w-full">
  @if(count($panels) != 0)
    <ul class="ml-0 mt-4 md:mt-8 lg:mt-0 list-none" data-controller="accordion" data-accordion-open-first-value="false" aria-label="{!! $headline !!}">
      @foreach ($panels as $index => $panel)
        <li class="accordion 
          relative -mt-px transition-all
          w-[calc(100%+2rem)] -ml-4
          before:accordion-border before:top-0
          last:after:accordion-border last:after:bottom-0
        ">
          <button class="accordion--title
              relative w-full flex justify-between items-baseline text-left p-4 transition z-content
              hover:bg-var-btn-bg hover:text-var-btn-text
              -outline-offset-[.125rem] focus:outline-[.125rem] outline-var-btn-solid-fill
            "
            id="accordion-{{ sanitize_title($headline) }}-{{ $index }}"
            data-action="accordion#togglePanel" 
            data-panel-index="{{ $index }}" 
            aria-expanded="false"
            aria-controls="panel-{{ $index + 1 }}"
            data-accordion-target="button" >
            <x-subhead
              html="h3"
              size="2"
              class="flex mb-0 transition space-x-narrow"
            >
              @if($show_numbers)<span>{{ sprintf("%02d", $index + 1) }}</span>@endif
              <span>{{ $panel['headline'] }}</span>
            </x-subhead>

            <div class="indicator w-10 flex self-center justify-end">
              {!! getSvg('icons/x') !!}
            </div>
          </button>

          @if(isset($panel['copy']))
            <article 
              id="panel-{{ sanitize_title($headline) }}-{{ $index + 1 }}" 
              class="accordion--copy transition-all overflow-hidden leading-6 text-[1.15rem] flex flex-col lg:flex-row px-4 gap-wide" 
              data-accordion-target="panel" 
              data-index="{{ $index }}" 
              style="max-height: 0px;"
              aria-describedby="accordion-{{ sanitize_title($headline) }}-{{ $index }}"
            >
              <div class="copy flex-1">
                @if($panel['subhead'])
                  <x-subhead size="3" html="h4" class="mb-min">
                    {!! $panel['subhead'] !!}
                  </x-subhead>
                @endif
                <div class="body body-1">{!! $panel['copy'] !!}</div>
                @if($panel['cta'])
                  <p class="mt-inner">
                    <x-button
                      html="a"
                      class="mb-1"
                      type="link"
                      icon="arrow-right"
                      href="{{ $panel['cta']['url'] }}"
                      target="{{ $panel['cta']['target'] }}"
                      >
                      {!! $panel['cta']['title'] !!}
                    </x-button>
                  </p>
                @endif
              </div>
              @if($panel['image'])
                <div class="image flex-1">@image($panel['image']['ID'], 'medium', ['class'  => 'w-full'])</div>
              @endif
            </article>
          @endif
        </li>
      @endforeach
    </ul>
  @endif
</div>