@include("site.inc.header")
<section class="sell_now_s">
    <div class="container">
        <h2 class="s_top_grey_title">{{ Language::lang('How It Works?') }}</h3>
        @foreach($howWorksCategories as $category)
        <div class="s_title_wrpr_45">
            <h3 class="s_title">{{ Language::lang($category->title) }}</h3>
        </div>
        <div class="card-items item-3 sell_now_s">
            @foreach($category->items as $item)
                <div class="card-item">
                <div class="item_works">
                    <div class="icon">
                        <img src="{{ $item->image }}" class="hiw"/>
                    </div>
                    <div class="title">{{ Language::lang($item->title) }}</div>
                    <div class="text">{{ Language::lang($item->description) }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</section>
@include("site.inc.footer")