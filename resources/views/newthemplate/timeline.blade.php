@include("newthemplate.header")
<section id="timeline" class="timeline">
    <div class="container timeline-container">
        <div class="timeline-item">
            <ul class="item">
                <li>
                    <p class="timeline-item-title">15 May 2018</p>
                    <p class="timeline-item-content">@php echo \App\Language::GetText(172); @endphp:</p>
                    <p class="timeline-item-comments">Bad seller. Very Bad.</p>
                </li>
            </ul>
            <ul>
                <li>
                    <p class="timeline-item-title">15 May 2018</p>
                    <p class="timeline-item-content">@php echo \App\Language::GetText(173); @endphp <a href="#" class="border-a">Good Van</a> for EUR 22 000</p>
                </li>
            </ul>
            <ul>
                <li>
                    <p class="timeline-item-title">15 May 2018</p>
                    <p class="timeline-item-content">@php echo \App\Language::GetText(173); @endphp <a href="#" class="border-a">Auto Bump</a> Plan for EUR 6</p>
                </li>
            </ul>
            <ul>
                <li>
                    <p class="timeline-item-title">15 May 2018</p>
                    <p class="timeline-item-content">@php echo \App\Language::GetText(174); @endphp</p>
                </li>
            </ul>
        </div>
    </div>
</section>
@include("newthemplate.footer")?>