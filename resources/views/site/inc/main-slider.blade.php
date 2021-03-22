<section class="main_slider_s">
    <div class="container">
        <div class="main_slider">
            @foreach($slider as $slide)
                @if(\App\Option::existsSlideImage($slide->image_url))
                <div class="slider_item" style="background-image: url({{ $slide->image_url }});">
                    <div class="slider_inner">
                        <div class="slider_content">
                            <div class="slider_main_title">{!! Language::lang($slide->slider_content) !!}</div>
                            @if(isset($slide->url_name) && !empty($slide->url_name))
                                <div class="btn_wrpr">
                                <a href="{{ $slide->url_link }}" class="btn bordr_btn">{{ Language::lang($slide->url_name) }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>