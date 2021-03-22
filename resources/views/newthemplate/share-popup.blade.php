@include('newthemplate.header')

<section id="blank-sample" class="blank-sample"></section>

<section id="" class="popup open">
    <div class="container">
        <div class="popup-inner">
            <a href="#" class="close-popup">+</a>
            <h6><span>@php echo \App\Language::GetText(139); @endphp</span> @php echo \App\Language::GetText(170); @endphp</h6>
            <p>@php echo \App\Language::GetText(171); @endphp</p>
            <ul class="share-list">
                <li><a href="#" class="round-icon round-fb"></a></li>
                <li><a href="#" class="round-icon round-vk"></a></li>
                <li><a href="#" class="round-icon round-tw"></a></li>
                <li><a href="#" class="round-icon round-yt"></a></li>
                <li><a href="#" class="round-icon round-tg"></a></li>
                <li><a href="#" class="round-icon round-in"></a></li>
                <li><a href="#" class="round-icon round-pt"></a></li>
                <li><a href="#" class="round-icon round-gh"></a></li>
            </ul>
        </div>
    </div>
    <div class="overlay" id="popup-overlay"></div>
</section>
@include("newthemplate.footer")