@include("site.inc.header")
<section class="sell_now_s">
    <div class="container">
        <h2 class="s_top_grey_title">{{ Language::lang('Questions & Answers') }}</h3>
        <div class="accordion">
            <section class="accordion_item">
                <a href="/qa" class="getting_started">
                        <span class="icon">
                            @php(include ("mooimarkt/img/getting_started.svg"))
                        </span>
                {{ Language::lang($QACategory->title) }}</a>
            </section>
            @foreach($QAItems as $item)
            <section class="accordion_item">
                @if ($item->question !== null)
                    <h3 class="title_block">{{ Language::lang($item->question) }}</h3>
                @endif
                <div class="info" style="display: {{ $item->question !== null ? 'none' : 'block' }}">
                    <p class="info_item">{!! Language::lang($item->answer) !!}</p>
                </div>
            </section>
            @endforeach
        </div>
    </div>
</section>
@include("site.inc.footer")