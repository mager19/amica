@if($taxonomy_terms && count($taxonomy_terms) > 1)
  <form title="Post Filter" class="button-filters flex flex-wrap items-center justify-center gap-min md:pb-min">
    <span class="flex-none w-full md:w-auto text-center">{{ _e('Filter by:', 'amica') }}</span>
    <x-button
      class="button-filters--button"
      type="border"
      html="button"
      data-filters-target="reset button"
      data-action="filters#filterItems"
      href="{{ get_post_type_archive_link('post') }}#news-section"
    >{{ __('All', 'amica' )}}</x-button>
    @foreach($taxonomy_terms as $term)
      <x-button
        class="button-filters--button"
        data-filters-target="button"
        data-action="filters#buttonPress"
        html="button"
        type="border"
        data-filters-slug-param="{{ $term->slug }}"
      >{!! $term->name_plural !!}</x-button>
    @endforeach
  </form>
@else
  <form id="cases-filters" title="Cases filter" class="cases-filters flex flex-wrap items-center justify-center gap-2 lg:gap-4 md:pb-min">
    <div class="flex flex-col lg:flex-row lg:items-center gap-inner w-full">
      <h3 class="subhead subhead-3 ">{{ _e('Filter by:', 'amica') }}</h3>
      <ul class="flex flex-1 flex-col md:flex-row gap-inner list-none border-b-0 pl-0 ml-0 mb-0"
          id="filter-buttons"
          role="tablist"
      >
        @foreach($taxonomy_slug as $key => $taxonomy)
          @if($taxonomy)
            <li class="dropdown group flex-1 lg:mt-0 relative"
                role="presentation">
              <button class="dropdown flex gap-min w-full justify-between items-center
                            transition ease-in-out border-2 border-black p-5"
                      id="button-{{ $key }}" role="tab"
                      data-action="cases#toggleDropdown" 
                      data-controls="#tabs-{{ $key }}"
                      aria-controls="tabs-{{ $key }}" 
                      aria-selected="false"
                      data-cases-target="dropdown"
              >
                  <span class="taxonomy-name subhead subhead-4" 
                  data-slug="{!! $key !!}">{!! $taxonomy['name'] !!}</span>
                  <span class="taxonomy-count hidden"><span class="counter"> </span> Selected</span>
                  @svg('images.icons.arrow-down', ['class' => '', 'aria-hidden' => 'true'])
              </button>
              <div class="tab-pane fade grid grid-cols-filters border-2 border-black p-5 -my-0.5 overflow-y-scroll min-w-full" id="tabs-{{ $key }}" role="tabpanel" aria-labelledby="tabs-{{ $key }}-tab">
                <fieldset data-cases-target="{{ $key }}" data-taxonomy="{{ $key }}">
                  <legend class="sr-only">{{ $taxonomy['name'] }}</legend>
                  <ul class="flex flex-col gap-y-[10px] ml-0 list-none">
                    @foreach ($taxonomy['values'] as $item)
                      @if($item->parent == '0')
                        <li>
                          <div class="w-full flex items-center gap-min body-2">
                            <input type="checkbox" id="{{ $key }}-{{ $item->slug }}" name="{{ $key }}[]"
                                  value="{{ $item->slug }}" tabindex="-1"
                                  data-name="{!! $item->name !!}"
                                  data-action="cases#toggleCheckbox"
                                  data-parent="{{ $key }}"
                                  data-cases-target="checkbox"
                            >
                            <label for="{{ $key }}-{{ $item->slug }}" class="menu menu-3 flex items-center flex-1">{!! $item->name !!}</label>
                          </div>
                          @if($item->children)
                            <ul class="flex flex-col gap-y-[6px] ml-inner pt-[6px] list-none">
                              @foreach ($item->children as $child)
                                <li class="w-full flex items-center gap-min body-2">
                                  <input type="checkbox" id="{{ $key }}-{{ $item->slug }}-{{ $child->slug }}" name="{{ $key }}[]"
                                        value="{{ $child->slug }}" tabindex="-1"
                                        data-name="{!! $child->name !!}"
                                        data-action="cases#toggleCheckbox"
                                        data-parent="{{ $key }}"
                                        data-cases-target="checkbox"
                                  >
                                  <label for="{{ $key }}-{{ $item->slug }}-{{ $child->slug }}" class="menu menu-3 flex items-center flex-1">{!! $child->name !!}</label>
                                </li>
                              @endforeach
                            </ul>
                          @endif
                        </li>
                      @endif
                    @endforeach
                  </ul>
                </fieldset>
                <button class="col-start-2 row-start-1 self-start flex" 
                        data-parent="{{ $key }}"
                        data-action="cases#resetDropdown"
                        data-cases-target="reset"
                        tabindex="-1"
                >
                  <span class="sr-only">Reset {!! $taxonomy['name'] !!} filters</span>
                  @svg('images.icons.x', ['class' => 'w-4 h-4 rotate-45', 'aria-hidden' => 'true'])
                </button>
              </div>
            </li>
          @endif
        @endforeach 
      </ul>
    </div>
  </form>
@endif
