@include("newthemplate.header")

<section class="my-ads-new">
    <div class="panel-top tab-panel">
        <a href="#tab_1" class="active">All Ads</a>
        <a href="#tab_2">Listed</a>
        <a href="#tab_3">Not listed</a>
    </div>
    <div class="new-container tabs">
        <div class="my-ads-box tab_1 show">

            @forelse($UserAds as $Ad)
			    <?php  $img = \App\AdsImages::where('adsId', $Ad->id)->first() ?>
                <div class="item">
                    <div class="top-block">
                        <div class="left-coll">
                            @if(!is_null($img))
                                <img src="{{$img->imagePath}}" alt="{{$Ad->adsName}}" />
                            @else
                                <img src="/newthemplate/img/logo.svg" alt="{{$Ad->adsName}}" />
                            @endif
                        </div>
                        <div class="right-coll">
                            <div class="ads-information">
                                <div class="name-car" ><a href="/add-details/{{$Ad->id}}">{{$Ad->adsName}}</a></div>
                                <div class="country-car">{{$Ad->adsCountry}}, {{$Ad->adsRegion}}, {{$Ad->adsCity}}</div>
                                <div class="ads-price">{{ $Ad->adsPriceWithType() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-block v-listing">
                        <span class="green"><b>Listed</b> {{$Ad->created_at->diffForHumans()}}</span>
                        <div class="btn-wrapper">
                            <a href="#" class="btn-boost"><i class="flash-icon"></i> Boost</a>
                            <a href="#" class="btn-rm"><i class="edit-icon"></i> Manage</a>
                        </div>
                    </div>
                </div>
            @empty
                no listings
        @endforelse
        </div>
        <div class="my-ads-box tab_2">

            @forelse($UserListedAds as $Ad)
			    <?php  $img = \App\AdsImages::where('adsId', $Ad->id)->first() ?>
                <div class="item">
                    <div class="top-block">
                        <div class="left-coll">
                            @if(!is_null($img))
                                <img src="{{$img->imagePath}}" alt="{{$Ad->adsName}}" />
                            @else
                                <img src="/newthemplate/img/logo.svg" alt="{{$Ad->adsName}}" />
                            @endif
                        </div>
                        <div class="right-coll">
                            <div class="ads-information">
                                <div class="name-car" ><a href="/add-details/{{$Ad->id}}">{{$Ad->adsName}}</a></div>
                                <div class="country-car">{{$Ad->adsCountry}}, {{$Ad->adsRegion}}, {{$Ad->adsCity}}</div>
                                <div class="ads-price">{{ $Ad->adsPriceWithType() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-block v-listing">
                        <span class="green"><b>Listed</b> {{$Ad->created_at->diffForHumans()}}</span>
                        <div class="btn-wrapper">
                            <a href="#" class="btn-boost"><i class="flash-icon"></i> Boost</a>
                            <a href="#" class="btn-rm"><i class="edit-icon"></i> Manage</a>
                        </div>
                    </div>
                </div>
            @empty
                no listings
        @endforelse
        </div>
        <div class="my-ads-box tab_3">

            @forelse($UserNoListedAds as $Ad)
			    <?php  $img = \App\AdsImages::where('adsId', $Ad->id)->first() ?>
                <div class="item">
                    <div class="top-block">
                        <div class="left-coll">
                            @if(!is_null($img))
                                <img src="{{$img->imagePath}}" alt="{{$Ad->adsName}}" />
                            @else
                                <img src="/newthemplate/img/logo.svg" alt="{{$Ad->adsName}}" />
                            @endif
                        </div>
                        <div class="right-coll">
                            <div class="ads-information">
                                <div class="name-car" ><a href="/add-details/{{$Ad->id}}">{{$Ad->adsName}}</a></div>
                                <div class="country-car">{{$Ad->adsCountry}}, {{$Ad->adsRegion}}, {{$Ad->adsCity}}</div>
                                <div class="ads-price">{{ $Ad->adsPriceWithType() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-block v-listing">
                        <span class="green"><b>Listed</b> {{$Ad->created_at->diffForHumans()}}</span>
                        <div class="btn-wrapper">
                            <a href="#" class="btn-boost"><i class="flash-icon"></i> Boost</a>
                            <a href="#" class="btn-rm"><i class="edit-icon"></i> Manage</a>
                        </div>
                    </div>
                </div>
            @empty
                no listings
        @endforelse
        </div>
    </div>
</section>
<script>
    var tabs = [...document.querySelectorAll('.tab-panel a')];
    var panels = [...document.querySelectorAll('.tabs .my-ads-box')];

    tabs.map(el =>{

        el.onclick = function(){

            if(!this.classList.contains('active')){
                tabs.map(tab =>{ tab.classList.remove('active'); });

                this.classList.add('active');

                panels.map(pan=>{
                    if(pan.classList.contains(this.getAttribute('href').slice(1))){

                        pan.classList.add('show');

                    }else{

                        pan.classList.remove('show');

                    }
                });

            }


        }

    });

</script>
@include("newthemplate.footer")