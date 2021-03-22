<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>B4MX - home</title>
    <link rel="shortcut icon" href="/img/logo/favicon.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="/newthemplate/css/reset.css" rel="stylesheet">
    <link href="/newthemplate/css/fonts.css" rel="stylesheet">
    <link href="/newthemplate/css/header.css" type="text/css" rel="stylesheet"/>
    <link href="/newthemplate/css/footer.css" type="text/css" rel="stylesheet"/>
    <link href="/newthemplate/bower_components/swiper/dist/css/swiper.min.css" rel="stylesheet" />
    <link href="/newthemplate/css/StyleSheet.css" rel="stylesheet" />
    <link href="/newthemplate/css/max.css" rel="stylesheet">
    <link href="/newthemplate/css/ruslan.css" rel="stylesheet">
    <link href="/newthemplate/css/vasya.css" rel="stylesheet">
</head>
<body>
<!-- MODAL ALL PAGE -->
<div class="modal_all_page">
    <section id="login-section" class="login-section">
        <div class="close_modal">&times;</div>
        <div class="modal_block">
             <h6>
                <span>@php echo \App\Language::GetText(19); @endphp</span>
                B4MX
             </h6>
             <form action="#" id="auth-form-popup" class="auth-form">
               {{csrf_field()}}
               <input type="email" name="email" class="user-input" placeholder="{{ \App\Language::GetText(11) }}">
               <input type="password" name="password" class="user-input" placeholder="{{ \App\Language::GetText(12) }}">
               <div class="user-checkbox">
                 <input type="checkbox"><label></label><span>@php echo \App\Language::GetText(13); @endphp</span>
               </div>
               <input type="submit" value="{{ \App\Language::GetText(19) }}" class="user-submit">
               <a href="#" class="user-link register_page_modal_popup">@php echo \App\Language::GetText(14); @endphp</a>
               <a href="#" class="user-link">@php echo \App\Language::GetText(15); @endphp</a>
               <span class="or">@php echo \App\Language::GetText(23); @endphp</span>
               <a href="/GoogleRedirect" class="login-google">@php echo \App\Language::GetText(16); @endphp</a>
               <a href="/FacebookRedirect" class="login-facebook">@php echo \App\Language::GetText(17); @endphp</a>
             </form>
             <form action="#" id="register-form-popup" class="auth-form" style="display: none;">
               {{csrf_field()}}
               <input type="email" name="email" class="user-input" placeholder="{{ \App\Language::GetText(11) }}">
               <input type="password" name="password" class="user-input" placeholder="{{ \App\Language::GetText(12) }}">
               <input type="password" name="password_confirmation" class="user-input" placeholder="{{ \App\Language::GetText(18) }}">
               <input type="submit" value="{{ \App\Language::GetText(14) }}" class="user-submit">
               <a href="#" class="user-link register_page_modal_popup">@php echo \App\Language::GetText(19); @endphp</a>
               <span class="or">@php echo \App\Language::GetText(23); @endphp</span>
               <a href="/GoogleRedirect" class="login-google">@php echo \App\Language::GetText(20); @endphp</a>
               <a href="/FacebookRedirect" class="login-facebook">@php echo \App\Language::GetText(21); @endphp</a>
             </form>
        </div>

    </section>
</div>
<!-- END MODAL -->
<!--header -->
<header>
    <div class="container container-header">
        <div class="menu-phone">
            <a class="menu-button" href="#">
                <span></span>
            </a>
            <div class="item-nav-logo">
                <a class="brand" href="/"><img src="/newthemplate/img/logo.svg" /></a>
            </div>
        </div>
        <div class="login">
            <a class="open_modal"><img src="/newthemplate/img/icon-p.svg" /></a>
            <a href="#" class="bt_blu">@php echo \App\Language::GetText(31); @endphp</a>
        </div>
        <div class="drop-down">
            <div class="main-nav-mobail">
                <div class="accordion-container">
                    @foreach ($navbarCaregories as $category)
                    <section class="accordion">
                        <div class="accordion-header">
                            <p>{{ $category->categoryName }}</p>
                            <p>{{ $category->adsnum }}</p>
                            <span class="arrow"></span>
                        </div>
                        <div class="accordion-body" style="display: none;">
                            <ul>
@foreach ($navbarSubCaregories as $subCaregory)
@if ($subCaregory->categoryId == $category->id)
                                        <li><a href="{{ route('ads.add-listing', ['subCategoryId' => $subCaregory->id]) }}" class="border-a">{{ $subCaregory->subCategoryName }}</a> <p>{{ $subCaregory->adsnum }}</p></li>
@endif
@endforeach
                            </ul>
                        </div>
                    </section>
                    @endforeach
                    {{-- <section class="accordion">
                        <div class="accordion-header"><p>Bikes</p> <p>36</p> <span class="arrow"></span></div>
                        <div class="accordion-body" style="display: none;">
                            <ul>
                                <li><a href="#" class="border-a">Engine tools</a> <p>36</p></li>
                                <li><a href="#" class="border-a">Hand tools</a> <p>142</p></li>
                                <li><a href="#" class="border-a">liquid handling</a> <p>1</p></li>
                                <li><a href="#" class="border-a">power tools</a> <p>113</p></li>
                                <li><a href="#" class="border-a">security</a> <p>64</p></li>
                                <li><a href="#" class="border-a">Stands & transport</a> <p>85</p></li>
                                <li><a href="#" class="border-a">tents & Awnings</a> <p>367</p></li>
                                <li><a href="#" class="border-a">tyre & rim tools</a> <p>1436</p></li>
                                <li><a href="#" class="border-a">work clothing</a> <p>44</p></li>
                            </ul>
                        </div>
                    </section>
                    <section class="accordion">
                        <div class="accordion-header"><p>Quads</p> <p>24</p> <span class="arrow"></span></div>
                        <div class="accordion-body" style="display: none;">
                            <ul>
                                <li><a href="#" class="border-a">Engine tools</a> <p>36</p></li>
                                <li><a href="#" class="border-a">Hand tools</a> <p>142</p></li>
                                <li><a href="#" class="border-a">liquid handling</a> <p>1</p></li>
                                <li><a href="#" class="border-a">power tools</a> <p>113</p></li>
                                <li><a href="#" class="border-a">security</a> <p>64</p></li>
                                <li><a href="#" class="border-a">Stands & transport</a> <p>85</p></li>
                                <li><a href="#" class="border-a">tents & Awnings</a> <p>367</p></li>
                                <li><a href="#" class="border-a">tyre & rim tools</a> <p>1436</p></li>
                                <li><a href="#" class="border-a">work clothing</a> <p>44</p></li>
                            </ul>
                        </div>
                    </section>
                    <section class="accordion">
                        <div class="accordion-header"><p>Vehicles</p> <p>1532</p> <span class="arrow"></span></div>
                        <div class="accordion-body active" style="display: none;">
                            <ul>
                                <li><a href="#" class="border-a">Engine tools</a> <p>36</p></li>
                                <li><a href="#" class="border-a">Hand tools</a> <p>142</p></li>
                                <li><a href="#" class="border-a">liquid handling</a> <p>1</p></li>
                                <li><a href="#" class="border-a">power tools</a> <p>113</p></li>
                                <li><a href="#" class="border-a">security</a> <p>64</p></li>
                                <li><a href="#" class="border-a">Stands & transport</a> <p>85</p></li>
                                <li><a href="#" class="border-a">tents & Awnings</a> <p>367</p></li>
                                <li><a href="#" class="border-a">tyre & rim tools</a> <p>1436</p></li>
                                <li><a href="#" class="border-a">work clothing</a> <p>44</p></li>
                            </ul>
                        </div>
                    </section>
                    <section class="accordion">
                        <div class="accordion-header"><p>Gear</p> <p>13</p> <span class="arrow"></span></div>
                        <div class="accordion-body active" style="display: none;">
                            <ul>
                                <li><a href="#" class="border-a">Engine tools</a> <p>36</p></li>
                                <li><a href="#" class="border-a">Hand tools</a> <p>142</p></li>
                                <li><a href="#" class="border-a">liquid handling</a> <p>1</p></li>
                                <li><a href="#" class="border-a">power tools</a> <p>113</p></li>
                                <li><a href="#" class="border-a">security</a> <p>64</p></li>
                                <li><a href="#" class="border-a">Stands & transport</a> <p>85</p></li>
                                <li><a href="#" class="border-a">tents & Awnings</a> <p>367</p></li>
                                <li><a href="#" class="border-a">tyre & rim tools</a> <p>1436</p></li>
                                <li><a href="#" class="border-a">work clothing</a> <p>44</p></li>
                            </ul>
                        </div>
                    </section>
                    <section class="accordion">
                        <div class="accordion-header"><p>Casual</p> <p>153</p> <span class="arrow"></span></div>
                        <div class="accordion-body" style="display: none;">
                            <ul>
                                <li><a href="#" class="border-a">Engine tools</a> <p>36</p></li>
                                <li><a href="#" class="border-a">Hand tools</a> <p>142</p></li>
                                <li><a href="#" class="border-a">liquid handling</a> <p>1</p></li>
                                <li><a href="#" class="border-a">power tools</a> <p>113</p></li>
                                <li><a href="#" class="border-a">security</a> <p>64</p></li>
                                <li><a href="#" class="border-a">Stands & transport</a> <p>85</p></li>
                                <li><a href="#" class="border-a">tents & Awnings</a> <p>367</p></li>
                                <li><a href="#" class="border-a">tyre & rim tools</a> <p>1436</p></li>
                                <li><a href="#" class="border-a">work clothing</a> <p>44</p></li>
                            </ul>
                        </div>
                    </section>
                    <section class="accordion">
                        <div class="accordion-header"><p>Parts</p> <p>325</p> <span class="arrow"></span></div>
                        <div class="accordion-body" style="display: none;">
                            <ul>
                                <li><a href="#" class="border-a">Engine tools</a> <p>36</p></li>
                                <li><a href="#" class="border-a">Hand tools</a> <p>142</p></li>
                                <li><a href="#" class="border-a">liquid handling</a> <p>1</p></li>
                                <li><a href="#" class="border-a">power tools</a> <p>113</p></li>
                                <li><a href="#" class="border-a">security</a> <p>64</p></li>
                                <li><a href="#" class="border-a">Stands & transport</a> <p>85</p></li>
                                <li><a href="#" class="border-a">tents & Awnings</a> <p>367</p></li>
                                <li><a href="#" class="border-a">tyre & rim tools</a> <p>1436</p></li>
                                <li><a href="#" class="border-a">work clothing</a> <p>44</p></li>
                            </ul>
                        </div>
                    </section>
                    <section class="accordion">
                        <div class="accordion-header"><p>Accessories</p> <p>123</p> <span class="arrow"></span></div>
                        <div class="accordion-body" style="display: none;">
                            <ul>
                                <li><a href="#" class="border-a">Engine tools</a> <p>36</p></li>
                                <li><a href="#" class="border-a">Hand tools</a> <p>142</p></li>
                                <li><a href="#" class="border-a">liquid handling</a> <p>1</p></li>
                                <li><a href="#" class="border-a">power tools</a> <p>113</p></li>
                                <li><a href="#" class="border-a">security</a> <p>64</p></li>
                                <li><a href="#" class="border-a">Stands & transport</a> <p>85</p></li>
                                <li><a href="#" class="border-a">tents & Awnings</a> <p>367</p></li>
                                <li><a href="#" class="border-a">tyre & rim tools</a> <p>1436</p></li>
                                <li><a href="#" class="border-a">work clothing</a> <p>44</p></li>
                            </ul>
                        </div>
                    </section> --}}
                </div>
            </div>

        </div>

    </div>

</header>
<div class="overlay-blok"><div class="overlay"></div>
    <!-- header end -->