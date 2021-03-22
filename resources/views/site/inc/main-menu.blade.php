<ul>
    @foreach($mainCategories as $category)
        <li>
            <a href="#" data-toggle="subcategory" class="{{ request()->categoryId == $category->id ? 'active' : '' }}">
                {{ Language::lang($category->categoryName) }}
            </a>

            <div class="sub_category_content">
                <div class="sub_category">
                    <span data-intend="link">
                        <a href="{{ route('adsByCategory', $category->id) }}">
                            {{ Language::lang('All') }}
                        </a>
                    </span>
                    @foreach($category->subCategories as $subCategorie)
                        @if($subCategorie->filterType() !== null && $subCategorie->filterType()->children->isNotEmpty())
                            <span class="category_item {{ !empty(request()->subCategoryId) && (request()->categoryId == $category->id) ? (request()->subCategoryId == $subCategorie->id) ? 'active' : '' : ($loop->first ? 'active' : '') }}"
                                  data-id="{{ $subCategorie->id }}">
                                {{ Language::lang($subCategorie->subCategoryName) }}
                            </span>
                        @else
                            <span data-intend="link"
                                  class="category_no_item {{ !empty(request()->subCategoryId) && (request()->categoryId == $category->id) ? (request()->subCategoryId == $subCategorie->id) ? 'active' : '' : ($loop->first ? 'active' : '') }}"
                                  data-id="{{ $subCategorie->id }}">
                                <a href="{{ route('adsByCategory', [$category->id, $subCategorie->id]) }}">
                                    {{ Language::lang($subCategorie->subCategoryName) }}
                                </a>
                            </span>
                        @endif
                    @endforeach
                </div>

                <div class="catalogs">
                    @foreach($category->subCategories as $subCategorie)
                        <div class="catalogs-content {{ !empty(request()->subCategoryId) && (request()->categoryId == $category->id) ? (request()->subCategoryId == $subCategorie->id  && $subCategorie->filterType() !== null && $subCategorie->filterType()->children->isNotEmpty()) ? 'active' : '' : ($loop->first && $subCategorie->filterType() !== null && $subCategorie->filterType()->children->isNotEmpty() ? 'active' : '') }}"
                             data-id="{{ $subCategorie->id }}">
                            <ul>
                                @if($subCategorie->filterType() !== null && $subCategorie->filterType()->children->isNotEmpty())
                                    <li>
                                        <a href="{{ route('adsByCategory', ['categoryId' => $category->id, 'subCategoryId' => $subCategorie->id]) }}">
                                            {{ Language::lang('All') }}
                                        </a>
                                    </li>
                                @endif
                                @foreach(($subCategorie->filterType()->children ?? []) as $type)
                                    <li>
                                        <a href="{{ route('adsByCategory', ['categoryId' => $category->id, 'subCategoryId' => $subCategorie->id, 'filters' => '["'.$type->id.'"]']) }}"
                                           class="{{ isset(request()->filters[$subCategorie->filterType()->id]) && request()->filters[$subCategorie->filterType()->id] == $type->id ? 'active' : '' }}">
                                            {{ Language::lang($type->name) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </li>
    @endforeach

    <li>
        <a href="/our-story">{{ Language::lang('Our story') }}</a>
    </li>
</ul>