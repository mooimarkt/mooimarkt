@include("site.inc.header")
@include("site.inc.main-banner")
<!-- @include("site.inc.main-slider") -->

<section class="cards_sections_wrpr">
    <section class="s-liked-items">
        <div class="container">
            <div class="s_title_wrpr">
                <h3 class="s_title">{{ Language::lang('Most liked items') }}</h3>
            </div>
            
            <div class="card-items item-5 more-most-liked-home-container">
            </div>

            <div class="btn_wrpr">
                <button type="button" class="btn def_btn more-most-liked-home">{{ Language::lang('See more') }}</button>
            </div>
        </div>
    </section>

    <section class="s-liked-items">
        <div class="container">
            <div class="s_title_wrpr">
                <h3 class="s_title">{{ Language::lang('Newest Items') }}</h3>
            </div>

            <div class="card-items item-5 more-newest-home-container">
            </div>

            <div class="btn_wrpr">
                <button type="button" class="btn def_btn more-newest-home">{{ Language::lang('See more') }}</button>
            </div>
        </div>
    </section>
</section>

@include("site.inc.notification")

@section('bottom-footer')
    <script src="/mooimarkt/js/ads-load.js"></script>
@endsection

@include("site.inc.footer")
