@include("site.inc.header")

<section class="cards_sections_wrpr">
    <section class="s-liked-items">
        <div class="container">
            <div class="s_title_wrpr">
                <h3 class="s_title">{{ Language::lang('Favorites items') }}</h3>
            </div>
            <div class="card-items item-5">
                @include('site.inc.ads-list')
            </div>
        </div>
    </section>
</section>
@include("site.inc.notification")
@include("site.inc.footer")
