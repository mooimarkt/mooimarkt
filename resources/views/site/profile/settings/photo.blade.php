@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css" crossorigin="anonymous">
    <style>
        .profile-modal {
            width: 70%;
            height: 70%;
            margin:0 auto;
            margin-top: 80px!important;
        }
    </style>
@endsection

@include("site.inc.header")

<section class="sell_now_s">
    <div class="container">
        <div class="wrap_content_box clearfix">
            <div class="left_box sidebar_settings">
                <div class="s_title_wrpr">
                    <h3 class="s_title s_title_2">{{ Language::lang('Settings') }}</h3>
                </div>
                @include('site.profile.settings.inc.sidebar')
            </div>
            <div class="right content_box dropzone_right height_100vh">
                @include('site.inc.flush-messages')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.settings.profile_photo') }}" id="my-awesome-dropzone2"
                      class="dropzone dropzone2 input_file_container" method="post">
                    {{ @csrf_field() }}
                    <input type="hidden" name="file" id="file_input_two" class="file_input_dropzone"/>
                    <div class="wrap_btn_dropzone">
                        <div class="settings_dropzone">
                            <div class="icon_profile"
                                 style="background: #FBFBFB url({{ empty($user->avatar) ? '/mooimarkt/img/photo_camera.svg' : $user->avatar  }}) no-repeat center center;"></div>
                            <div class="wrap_dropzone">
                                <div class="dropzone_inner">
                                    <label data-target-form="my-awesome-dropzone2" class="input_file_btn btn def_btn">
                                    <?xml version="1.0" encoding="iso-8859-1"?>
                                    <!-- Generator: Adobe Illustrator 19.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 486.3 486.3" style="enable-background:new 0 0 486.3 486.3;" xml:space="preserve">
<g>
    <g>
        <path d="M395.5,135.8c-5.2-30.9-20.5-59.1-43.9-80.5c-26-23.8-59.8-36.9-95-36.9c-27.2,0-53.7,7.8-76.4,22.5
			c-18.9,12.2-34.6,28.7-45.7,48.1c-4.8-0.9-9.8-1.4-14.8-1.4c-42.5,0-77.1,34.6-77.1,77.1c0,5.5,0.6,10.8,1.6,16
			C16.7,200.7,0,232.9,0,267.2c0,27.7,10.3,54.6,29.1,75.9c19.3,21.8,44.8,34.7,72,36.2c0.3,0,0.5,0,0.8,0h86
			c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-85.6C61.4,349.8,27,310.9,27,267.1c0-28.3,15.2-54.7,39.7-69
			c5.7-3.3,8.1-10.2,5.9-16.4c-2-5.4-3-11.1-3-17.2c0-27.6,22.5-50.1,50.1-50.1c5.9,0,11.7,1,17.1,3c6.6,2.4,13.9-0.6,16.9-6.9
			c18.7-39.7,59.1-65.3,103-65.3c59,0,107.7,44.2,113.3,102.8c0.6,6.1,5.2,11,11.2,12c44.5,7.6,78.1,48.7,78.1,95.6
			c0,49.7-39.1,92.9-87.3,96.6h-73.7c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h74.2c0.3,0,0.6,0,1,0c30.5-2.2,59-16.2,80.2-39.6
			c21.1-23.2,32.6-53,32.6-84C486.2,199.5,447.9,149.6,395.5,135.8z" fill="#E0B1A3"/>
        <path d="M324.2,280c5.3-5.3,5.3-13.8,0-19.1l-71.5-71.5c-2.5-2.5-6-4-9.5-4s-7,1.4-9.5,4l-71.5,71.5c-5.3,5.3-5.3,13.8,0,19.1
			c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l48.5-48.5v222.9c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5V231.5l48.5,48.5
			C310.4,285.3,318.9,285.3,324.2,280z" fill="#E0B1A3"/>
    </g>
</g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
                                            <g>
                                            </g>
</svg>

                                        {{ Language::lang('Choose a file or drag it here.') }}</label>
{{--                                    <span class="input_file_text">{{ Language::lang('or drag in') }}</span>--}}
                                </div>
                                <div class="dz-default dz-message">
                                    <span>{{ Language::lang('Drop files here to upload') }}</span></div>
                            </div>
                        </div>
                        <div class="wrap_btn_form">
                            <button type="submit" class="btn def_btn save">{{ Language::lang('save') }}</button>
                            <button type="button" class="btn bordr_btn cancel">{{ Language::lang('Cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@section('bottom-footer')
    <script src="https://unpkg.com/cropperjs/dist/cropper.js" crossorigin="anonymous"></script>
@endsection

@include("site.inc.footer")
