@include("site.inc.header")

<section class="sell_now_s">
    <div class="container">
        <h3 class="s_top_grey_title">{{ Language::lang($page->title) }}</h3>

        <div class="purchase-item">
            @include('site.inc.flush-messages')

            <form action="{{ route('send_contact_email') }}" class="form-payment-card" method="post"
                  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ @csrf_token() }}">

                <div class="inputs_flex">
                    <div class="item contact" style="display: {{ auth()->check() ? 'none' : '' }}">
                        <label for="email">Email</label>
                        <input type="text" class="text_input" name="email" id="email"
                               placeholder="Please type your email"
                               value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                        <span class="error_input_text"></span>
                    </div>
                    <div class="item contact">
                        <label for="messageText">Message text</label>
                        <textarea class="text_input" name="message_text" id="messageText"
                                  placeholder="Please type your message"
                                  required></textarea>
                        <span class="error_input_text"></span>
                    </div>
                    <div class="item contact">
                        <label for="file">File</label>
                        <input type="file" class="text_input" name="file" id="file"
                               placeholder="Please type your email">
                        <span class="error_input_text"></span>
                    </div>
                </div>

                <input type="submit" class="btn complete_purchase" style="margin-top: 25px;" value="Send">
            </form>
        </div>

        <div class="paragraph_block">
            {!! Language::lang($page->content) !!}
        </div>
    </div>
</section>

@include("site.inc.footer")