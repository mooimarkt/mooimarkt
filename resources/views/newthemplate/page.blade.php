@include("newthemplate.header")

<section id="login-section" class="login-section">
    <div class="container">
		<div class="row">
			<h6 class="policy-title">
                {{ $page->title }}
			</h6>
		</div>
		<div class="row contant-row-page">
            @php echo $page->content; @endphp
		</div>
    </div>
</section>

<style>
    .contant-row-page p {
        margin-bottom: 10px;
        margin-top: 15px;
    }
</style>

@include("newthemplate.footer")