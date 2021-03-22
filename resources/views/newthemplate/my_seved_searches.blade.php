@include("newthemplate.header")

<!--MY SEVED SERCHES START-->
<div class="container">
    <div class="tabs-wrapper">
        <div class="tabs saved-tabs">
            <span class="tab active">Saved alerts</span>
            <span class="tab">Saved users</span>
        </div>
        <div class="tab_content saved-tab-content">
            <div class="tab_item active">
                <div class="sev_serch_container">
                    @foreach($Searches as $search)

                        <div class="sev_serch_block">
                        <a class="sev_serch_1" target="_blank" href="/add-listing?{{

                                    implode("&", array_filter(
                                    [
                                        $search->s != "null" ? "search=".$search->s : false,
                                        !is_null($search->Category) ? "categoryId=".$search->Category->id : false,
                                        !is_null($search->SubCategory) ? "subCategoryId=". $search->SubCategory->id : false,
                                        property_exists($search->search,"tags") ? http_build_query(["tags"=>$search->search->tags]) : false
                                    ]
                                    ))

                                }}">
                            <img src="/newthemplate/img/serch_bl.svg" alt="Alternate Text" />
                        </a>
                        <div class="sev_serch_2">
                            <div class="serch_capt">{{$search->s != "null" ? $search->s : "*no search string*"}}</div>
                            <div class="serch_text">
                                {{

                                    implode(", ", array_filter(
                                    [
                                        !is_null($search->Category) ? $search->Category->categoryName : false,
                                        !is_null($search->SubCategory) ? $search->SubCategory->Category->categoryName ." > ". $search->SubCategory->subCategoryName : false,
                                        property_exists($search->search,"tags") ? implode(", ",$search->search->tags) : false
                                    ]
                                    ))

                                }}
                            </div>
                        </div>
                        <div class="sev_serch_3">
                            <div class="serch_select">
                                <img class="img_select" src="{{$search->notify ?  "/newthemplate/img/Rounded_ic.svg" : "/newthemplate/img/Rounded_ic_dis.svg"}}" alt="Alternate Text" />
                                <img class="arr_bl_sel" src="/newthemplate/img/arr_bl_bott.svg" alt="Alternate Text" />
                            </div>
                            <div class="serch_drop_select">
                                <a class="srh_img_block" target="_blank" href="/add-listing?{{

                                    implode("&", array_filter(
                                    [
                                        $search->s != "null" ? "search=".$search->s : false,
                                        !is_null($search->Category) ? "categoryId=".$search->Category->id : false,
                                        !is_null($search->SubCategory) ? "subCategoryId=". $search->SubCategory->id : false,
                                        property_exists($search->search,"tags") ? http_build_query(["tags"=>$search->search->tags]) : false
                                    ]
                                    ))

                                }}">
                                    <img class="sel_img" src="/newthemplate/img/serch_bl.svg" alt="Alternate Text" />
                                </a>
                                <div class="srh_img_block">
                                    <img class="sel_img{{$search->notify ? " notif_on" : ""}}" data-notify-ss="{{$search->id}}" src="{{$search->notify ? "/newthemplate/img/Rounded_ic_dis.svg" : "/newthemplate/img/Rounded_ic.svg"}}" alt="Alternate Text" />
                                </div>
                                <div class="srh_img_block" data-remove-ss="{{$search->id}}">
                                    <img class="sel_img" src="/newthemplate/img/close_red.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                        <div class="sev_serch_4" data-remove-ss="{{$search->id}}">
                            <img src="/newthemplate/img/close_red.svg" alt="Alternate Text" />
                        </div>
                    </div>
                    @endforeach
                    <div class="creat_bl">
                        <a href="/add-listing" class="blue_btn blue_cr_btn">Create</a>
                    </div>
                </div>
            </div>
            <div class="tab_item">
                <div class="good-van">
                    <div class="container container-good-van">
                        <div class="good-item-1">
                            <img src="/newthemplate/img/Mask.jpg">
                            <p>Elon<br> <span>Musk</span></p>
                        </div>
                        <div class="good-item-2">
                            <a href="#"><img src="/newthemplate/img/arrow-next.svg"></a>
                        </div>
                    </div>
                </div>
                <div class="good-van">
                    <div class="container container-good-van">
                        <div class="good-item-1">
                            <img src="/newthemplate/img/Mask.jpg">
                            <p>Elon<br> <span>Musk</span></p>
                        </div>
                        <div class="good-item-2">
                            <a href="#"><img src="/newthemplate/img/arrow-next.svg"></a>
                        </div>
                    </div>
                </div>
                <div class="good-van">
                    <div class="container container-good-van">
                        <div class="good-item-1">
                            <img src="/newthemplate/img/Mask.jpg">
                            <p>Elon<br> <span>Musk</span></p>
                        </div>
                        <div class="good-item-2">
                            <a href="#"><img src="/newthemplate/img/arrow-next.svg"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MY SEVED SERCHES END-->
@include("newthemplate.footer")