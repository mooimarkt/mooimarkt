@include("site.inc.header")
    <section class="sell_now_s">
        <div class="container">
            <h2 class="s_top_grey_title">{{ Language::lang('Questions & Answers') }}</h3>
            @foreach($QACategories as $qa)
                @if($loop->first)
                    <div class="card-items item-3">
                @endif
                    <div class="card-item">
                            <div class="item_questions_answers">
                                <div class="icon">
                                    <a href="{{ route('pages.qaCategory', $qa->slug) }}">
                                        <img src="{{ $qa->image }}"  />
                                    </a>
                                </div>
                                <a href="{{ route('pages.qaCategory', $qa->slug) }}">
                                    <div class="title">{{ Language::lang($qa->title) }}</div>
                                </a>
                                <div class="text">{!! Language::lang($qa->description) !!}</div>
                                <a href="{{ route('pages.qaCategory', $qa->slug) }}">Learn More</a>
                            </div>
                        </div>
                @if(($loop->iteration % 3) == 0)
                    </div>
                @endif
                @if(($loop->iteration % 3) == 0)
                    <div class="card-items item-3">
                @endif
                @if($loop->last)
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@include("site.inc.footer")