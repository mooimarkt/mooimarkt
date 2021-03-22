@include("site.inc.header")
    <section class="sell_now_s">
        <div class="container">
            <h2 class="s_top_grey_title">{!! Language::lang('Our story') !!}</h3>
            <div class="paragraph_block">
                {!! Language::lang(strip_tags($page->content)) !!}
            </div>
        </div>
    </section>
@include("site.inc.footer")
