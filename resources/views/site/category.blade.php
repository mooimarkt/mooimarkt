@include("site.inc.header")

<input type="hidden" value="{{ optional($curCategory)->id }}" id="cur_category">
<input type="hidden" value="{{ $curSubCategory !== null ? $curSubCategory->id : (request()->sub_category ?? '') }}"
       id="cur_sub_category">

<form action="{{ route('adsByCategory', ['categoryId' => optional($curCategory)->id, 'subCategoryId' => $curSubCategory !== null ? $curSubCategory->id : '']) }}">
    <section class="s-category">
        <div class="container">
            <div class="category-wrap">
                <div class="category-box">
                    <div class="top-info">
                        <ul class="breadcrumbs">
                            <li><a href="/">{{ Language::lang('Home') }}</a></li>
                            <li>/</li>
                            <li><a href="/catalog">{{ Language::lang('Catalog') }}</a></li>
                            @if ($curCategory !== null)
                                <li>/</li>
                                <li>
                                    <a href="{{ route('adsByCategory', optional($curCategory)->id) }}">{{ Language::lang(optional($curCategory)->categoryName) }}</a>
                                </li>
                            @endif
                            @if ($curSubCategory !== null)
                                <li>/</li>
                                <li>{{ Language::lang($curSubCategory->categoryName ) }}</li>
                            @endif
                        </ul>
                        <h1 class="top-title">
                            @if ($curSubCategory !== null)
                                {{ Language::lang($curSubCategory->subCategoryName) }}
                            @elseif ($curCategory !== null)
                                {{ Language::lang(optional($curCategory)->categoryName) }}
                            @else
                                {{ Language::lang('Catalog') }}
                            @endif
                        </h1>
                    </div>

                    @if ($curSubCategory !== null && $curCategory !== null)
                        <div class="select-items" id="search_form">
                            <span class="filter-items">
                                <ul>
                                    @foreach($filters as $filter)
                                        <li class="filter-item" data-id="{{ $filter->id }}"
                                            style="{{ $exceptFilters->contains($filter->id) ? 'display: none' : '' }}" {{ $exceptFilters->contains($filter->id) ? 'data-filter=size' : '' }}>
                                            <span class="title">
                                                <span class="label">{{ $filter->name }}</span>
                                                <svg viewBox="0 0 16 16"><path d="M8 12L2 6h12z"></path></svg>
                                            </span>
                                            @switch($filter->template)
                                                @case('type')
                                                <div class="filter_content">
                                                    <div class="items">
                                                        <div class="back">
                                                            @php(include ("mooimarkt/img/getting_started.svg"))
                                                            <label></label>
                                                        </div>
                                                        @foreach($filter->children as $subFilter)
                                                            @if ($subFilter->children()->count() > 0)
                                                                <div class="parent_item "
                                                                     data-ids="{{ $subFilter->children->pluck('id')->push($subFilter->id) }}">
                                                                <span class="parent_main"
                                                                      data-title="{{ Language::lang($subFilter->name) }}"
                                                                      style="font-weight : {{ !empty(array_intersect ($filters_data, $subFilter->children->pluck('id')->push($subFilter->id)->toArray())) ? 'bold' : 'inherit'  }}">
                                                                    <label>{{ Language::lang($subFilter->name) }}</label>
                                                                    @php(include ("mooimarkt/img/arrow_right_icon.svg"))
                                                                </span>

                                                                <div class="children_items">
                                                                    <span data-size="{{ $subFilter->filterSize->size_id ?? null }}"
                                                                          class="children_filter_item">
                                                                        <label for="filter_{{ $filter->id  }}_all_{{ $subFilter->id }}"
                                                                               class="c-checkbox">{{ Language::lang('All') }}</label>
                                                                        <input type="checkbox"
                                                                               name="filter[{{ $filter->id  }}]"
                                                                               id="filter_{{ $filter->id  }}_all_{{ $subFilter->id }}"
                                                                               value="{{ $subFilter->id }}"
                                                                               data-type="type" data-action="all"
                                                                               data-filter="{{ $filter->id }}"
                                                                               data-title="{{ Language::lang($subFilter->name) }}" {{ array_search($subFilter->id, $filters_data) !== false ? 'checked' : '' }}>
                                                                    </span>
                                                                    @foreach($subFilter->children as $children)
                                                                        <span data-size="{{ $subFilter->filterSize->size_id ?? null }}">
                                                                            <label for="filter_{{ $filter->id  }}_{{ $children->id  }}"
                                                                                   class="c-checkbox">{{ Language::lang($children->name) }}</label>
                                                                            <input type="checkbox"
                                                                                   name="filter[{{ $filter->id  }}]"
                                                                                   id="filter_{{ $filter->id  }}_{{ $children->id  }}"
                                                                                   value="{{ $children->id  }}"
                                                                                   data-type="type"
                                                                                   data-filter="{{ $filter->id }}"
                                                                                   data-title="{{ Language::lang($children->name) }}" {{ array_search($children->id, $filters_data) !== false ? 'checked' : '' }}>
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            @else
                                                                <span class="parent_item"
                                                                      data-size="{{ $subFilter->filterSize->size_id ?? null }}">
                                                                <label for="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                       class="c-checkbox">{{ Language::lang($subFilter->name) }}</label>
                                                                <input type="checkbox" name="filter[{{ $filter->id  }}]"
                                                                       id="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                       value="{{ $subFilter->id  }}"
                                                                       data-type="type" data-filter="{{ $filter->id }}"
                                                                       data-title="{{ Language::lang($subFilter->name) }}" {{ array_search($subFilter->id, $filters_data) !== false ? 'checked' : '' }}>
                                                            </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @break
                                                @case('brand')
                                                <div class="filter_content">
                                                    <div class="items" style="display: inline-block">
                                                        <div class="back">
                                                            @php(include ("mooimarkt/img/getting_started.svg"))
                                                            <label></label>
                                                        </div>
                                                        @foreach($filter->children()->get() as $subFilter)
                                                            @if ($subFilter->name == 'Other')
                                                                <div class="parent_item"
                                                                     data-ids="{{ $subFilter->children->pluck('id') }}">
                                                                    <span class="parent_main"
                                                                          data-title="{{ Language::lang($subFilter->name) }}">
                                                                        <label for="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                               class="c-checkbox">{{ Language::lang($subFilter->name) }}</label>
                                                                        @php(include ("mooimarkt/img/arrow_right_icon.svg"))
                                                                    </span>
                                                                <div class="children_items custom-brand-wrap">
                                                                    <input type="text" minlength="1" name="custom_brand"
                                                                           placeholder="Brand"
                                                                           class="field-custom-brand"
                                                                           value="{{ isset(request()->other_brand) ? request()->other_brand : '' }}"
                                                                           data-parent="{{ $subFilter->id }}">
                                                                    <button type="button"
                                                                            class="add-custom-brand">Add</button>
                                                                </div>
                                                            </div>
                                                            @else
                                                                <span class="parent_item"
                                                                      style="display: inline-block; width: 190px;">
                                                                <label for="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                       class="c-checkbox">{{ Language::lang($subFilter->name) }}</label>
                                                                <input type="checkbox"
                                                                       style="float: right; margin: auto;"
                                                                       name="filter[{{ $filter->id  }}]"
                                                                       id="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                       value="{{ $subFilter->id  }}"
                                                                       data-filter="{{ $filter->id }}"
                                                                       data-title="{{ Language::lang($subFilter->name) }}" {{ array_search($subFilter->id, $filters_data) !== false ? 'checked' : '' }}>
                                                            </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @break
                                                @case('color')
                                                <div class="filter_content">
                                                    <div class="items">
                                                    <div class="list-colors">
                                                        @foreach($filter->children()->get() as $subFilter)
                                                            @php($color = $subFilter->name)

                                                            @switch ($subFilter->name)
                                                                @case('light blue')
                                                                @php($color = '#add8e6')
                                                                @break
                                                                @case('rose')
                                                                @php($color = '#ff007f')
                                                                @break
                                                                @case('haki')
                                                                @php($color = '#78866b')
                                                                @break
                                                                @case('mustard')
                                                                @php($color = '#ffdb58')
                                                                @break
                                                            @endswitch

                                                            <span class="color_item {{ array_search($subFilter->id, $filters_data) !== false ? 'active' : '' }}"
                                                                  style="background: {{ $color }}"
                                                                  data-id="{{ $subFilter->id }}"
                                                                  data-color="{{ $color }}">
                                                                <input type="checkbox"
                                                                       name="filter[{{ $filter->id  }}]"
                                                                       id="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                       value="{{ $subFilter->id  }}"
                                                                       data-type="color"
                                                                       data-color="{{ $color }}"
                                                                       data-filter="{{ $filter->id }}"
                                                                       data-title="{{ Language::lang($subFilter->name) }}" {{ array_search($subFilter->id, $filters_data) !== false ? 'checked' : '' }}>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                    </div>
                                                </div>
                                                @break
                                                @default
                                                <div class="filter_content" style="margin-left: -100px;">
                                                        <div class="items" style="display: inline-block">
                                                        @foreach($filter->children as $subFilter)
                                                                <span class="filter_items"
                                                                      style="display: inline-block; width: 150px;">
                                                                <label for="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                       class="c-checkbox">{{ Language::lang($subFilter->name) }}
                                                                <input type="checkbox"
                                                                       style="float: right; margin: auto;"
                                                                       name="filter[{{ $filter->id  }}]"
                                                                       id="filter_{{ $filter->id  }}_{{ $subFilter->id  }}"
                                                                       value="{{ $subFilter->id  }}"
                                                                       data-filter="{{ $filter->id }}"
                                                                       data-title="{{ Language::lang($subFilter->name) }}" {{ array_search($subFilter->id, $filters_data) !== false ? 'checked' : '' }}>
                                                                </label>

                                                            </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @break
                                            @endswitch
                                        </li>
                                    @endforeach

                                    <li class="filter-item">
                                        <span class="title">
                                            <span class="label">Location</span>
                                            <svg viewBox="0 0 16 16"><path d="M8 12L2 6h12z"></path></svg>
                                        </span>
                                        <div class="filter_content location_content">
                                            <div class="items">
                                                <span class="location_item {{ isset(request()->location) && (request()->location == 'all' || request()->location == '') ? 'active' : '' }}"
                                                      data-value="all">All distances</span>
                                                <span class="location_item {{ isset(request()->location) && request()->location == 3 ? 'active' : '' }}"
                                                      data-value="3">< 3 km</span>
                                                <span class="location_item {{ isset(request()->location) && request()->location == 5 ? 'active' : '' }}"
                                                      data-value="5">< 5 km</span>
                                                <span class="location_item {{ isset(request()->location) && request()->location == 10 ? 'active' : '' }}"
                                                      data-value="10">< 10 km</span>
                                                <span class="location_item {{ isset(request()->location) && request()->location == 15 ? 'active' : '' }}"
                                                      data-value="15">< 15 km</span>
                                                <span class="location_item {{ isset(request()->location) && request()->location == 25 ? 'active' : '' }}"
                                                      data-value="25">< 25 km</span>
                                                <span class="location_item {{ isset(request()->location) && request()->location == 50 ? 'active' : '' }}"
                                                      data-value="50">< 50 km</span>
                                                <span class="location_item {{ isset(request()->location) && request()->location == 75 ? 'active' : '' }}"
                                                      data-value="75">< 75 km</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-item">
                                        <span class="title">
                                            <span class="label">Price</span>
                                            <svg viewBox="0 0 16 16"><path d="M8 12L2 6h12z"></path></svg>
                                        </span>
                                        <div class="filter_content price_content">
                                            <div class="items price-wrap">
                                                <div class="price-item">
                                                    <div class="title">From</div>
                                                    <input type="number" name="price[from]" placeholder="EUR"
                                                           class="field"
                                                           value="{{ isset(request()->price_from) ? request()->price_from : '' }}">
                                                </div>
                                                <div class="price-item">
                                                    <div class="title">To</div>
                                                    <input type="number" name="price[to]" placeholder="EUR"
                                                           class="field"
                                                           value="{{ isset(request()->price_to) ? request()->price_to : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </span>
                        </div>
                    @endif
                </div>

                <div class="category-filter-panel tags">
                    <ul class="tag-items"></ul>
                </div>

                <div class="category-filter-panel">
                    @if ($curSubCategory !== null && $curCategory !== null)
                        <div class="filter-man-wrap">
                            {{--                        <div class="reset-filter apply-filter">{{ Language::lang('Apply') }}</div>--}}
                            <div class="reset-filter"
                                 id="reset-category-filter">{{ Language::lang('Reset filters') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="cards_sections_wrpr">
        <section class="s-results">
            <div class="container">
                <div class="top-panel">
                    <div class="results"></div>
                    <div class="sort-by">
                        <div class="select">
                            <select name="sort_by" class="sort_by">
                                <option value="default" {{ request()->sort_by == 'default' ? 'selected' : '' }}>{{ Language::lang('Sort By') }}</option>
                                <option value="new" {{ request()->sort_by == 'new' ? 'selected' : '' }}>{{ Language::lang('Newest') }}</option>
                                <option value="most_liked" {{ request()->sort_by == 'most_liked' ? 'selected' : '' }}>{{ Language::lang('Most liked') }}</option>
                                <option value="price_low_to_high" {{ request()->price_low_to_high == 'price_low_to_high' ? 'selected' : '' }}>{{ Language::lang('Price: Low to High') }}</option>
                                <option value="price_high_to_low" {{ request()->price_high_to_low == 'price_high_to_low' ? 'selected' : '' }}>{{ Language::lang('Price: High to Low') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-items item-4 filters-ads">
                </div>

{{--                <div class="btn_wrpr">--}}
{{--                    <button type="button" class="btn def_btn more-ads">{{ Language::lang('See more') }}</button>--}}
{{--                </div>--}}
                {{--                {{ $ads->withPath(route('adsByCategory', ['categoryId' => optional($curCategory)->id, 'subCategoryId' => $curSubCategory !== null ? $curSubCategory->id : '']))->appends($_GET)->links() }}--}}

            </div>
        </section>
    </section>
</form>


@section('bottom-footer')
    <script src="/newthemplate/js/TextLoader.js"></script>
    <script src="/newthemplate/js/search.js"></script>
    <script src="/mooimarkt/js/ads-load.js"></script>

    <script>
        $('#reset-category-filter').on('click', function () {
            location.replace('{{ route('adsByCategory', ['categoryId' => optional($curCategory)->id, 'subCategoryId' => $curSubCategory !== null ? $curSubCategory->id : '']) }}');
        });

        $('.adsFilters').on('change', function () {
            let filter = this.value;
            let self = this;

            if ($(self).parent().attr('class').indexOf('select_sub_filter') !== -1) {
                return false;
            }

            $.ajax({
                type: "GET",
                url: '/catalogs-filter',
                data: {filter: filter},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data.status == "success" && data.data == 'Other brand') {
                        $('.other-brand').show();
                    } else {
                        if (data.status == "success" && data.data === 'Brand') {
                            $('.other-brand').hide();
                            $('.other-brand>input').val('');
                        } else {
                            if (data.data == null || data.data.length == 0) {
                                deleteSubFilters();
                            } else {
                                addSubFilters(filter, data.data)
                            }
                        }
                    }

                },
                error: function () {
                    alert('Something Wrong ! Please Try Again');
                }
            });

            function deleteSubFilters() {
                if ($(self).parent().parent().find('.select_sub_filter').length !== 0) {
                    $(self).parent().parent().find('.select_sub_filter').remove()
                }
            }

            function addSubFilters(filter, subFilters) {
                deleteSubFilters()

                $(self).parent().parent().append('' +
                    '<div class="select select_sub_filter">' +
                    '<select name="filters[' + filter + ']" class="adsFilters"\n' +
                    '</select>' +
                    '</div>' +
                    '')
                $.each(subFilters, function (i, val) {
                    $(self).parent().parent().find('.select_sub_filter').find('select').append('<option value="' + val['id'] + '">' + val['name'] + '</option>')
                })
            }

        });

        $('.country').on('change', function () {
            let country_id = this.value;
            let self = this;
            /*if($(self).parent().attr('class').indexOf('select_sub_filter') !== -1) {
                return false;
            }*/
            if (country_id === '') {
                deleteCities();
            } else {
                $.ajax({
                    type: "POST",
                    url: '/get-cities/' + country_id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (response) {
                        if (response.success) {
                            if (response.data.length != 0) {
                                addCities(response.data)
                            } else {
                                deleteCities();
                            }
                        }

                    },
                    error: function () {
                        alert('Something Wrong ! Please Try Again');
                    }
                });
            }


            function deleteCities() {
                if ($('.city').length !== 0) {
                    $('.city').remove()
                }
            }

            function addCities(cities) {
                deleteCities()
                $(self).parent().parent().append('' +
                    '<div class="select city">' +
                    '<select name="city"\n' +
                    '</select>' +
                    '</div>' +
                    '')
                $('.city').find('select').append('<option value="">All Cities</option>')

                $.each(cities, function (i, val) {
                    $('.city').find('select').append('<option value="' + val['id'] + '">' + val['name'] + '</option>')
                })
            }

        });

        $('.price_span').click(function () {
            $('.filter-price').show()
            $('.price-value').remove()
            $('.price_span').html(translate('Price'))

        })

    </script>
@endsection

@include("site.inc.notification")
@include("site.inc.footer")

