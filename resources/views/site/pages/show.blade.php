@include("site.inc.header")
    <section class="sell_now_s">
        <div class="container">
            <h3 class="s_top_grey_title">{{ Language::lang($page->title) }}</h3>
            <div class="paragraph_block">
            {!! Language::lang($page->content) !!}
            </div>
        </div>
    </section>
@include("site.inc.footer")
