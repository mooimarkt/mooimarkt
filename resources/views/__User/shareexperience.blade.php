@extends('layouts.app')

@section('content')

<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
		<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
	</div>

	<div class="row">
		@if (count($errors) > 0)
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		@if (\Session::has('success'))
		    <div class="alert alert-success">
		        <ul>
		            <li>{!! \Session::get('success') !!}</li>
		        </ul>
		    </div>
		@endif
		<!-- Share Experience Section -->
		<div class="col-lg-12 col-md-12 col-xs-12 header-div">
			<h6 class="header-title">{{trans('label-terms.contactusbysendingemailto')}}</h6>
				<a href="mailto:support@b4mx.com" target="_top" style="font-size: 20pt; text-decoration: underline;">support@b4mx.com</a>
		</div>

		<div class="col-lg-12 col-md-12 col-xs-12" style="text-align: center;">
			<h6 class="header-title" style="color:#002450; font-weight: 600;">
				{{trans('label-terms.or')}} {{trans('instruction-terms.filluptheformbelow')}}
				</h6>
		</div>

		<form method="POST" action="sendFeedbackEmail" enctype="multipart/form-data" id="feedbackForm">
			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<label for="feedbackName">{{trans('label-terms.contactdetails')}}</label>
				<input type="text" placeholder="{{trans('label-terms.name')}}" class="form-control" name="txtFeedbackName" id="feedbackName" required />
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<input type="text" placeholder="{{trans('label-terms.phone')}}" class="form-control" name="txtFeedbackPhone" required />
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<input type="text" placeholder="{{trans('label-terms.email')}}" class="form-control" name="txtFeedbackEmail" required />
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<br/>
				<div class="form-group">
				    <label for="subjectTxt">{{trans('label-terms.subject')}}</label>
				    <select class="form-control" id="subjectTxt" name="txtFeedbackSubject" required>
				    	<option value="Managing My Ad">Managing My Ad</option>
				    	<option value="My B4MX Account">My B4MX Account</option>
				    	<option value="B4MX Messenger">B4MX Messenger</option>
				    	<option value="Payment Query">Payment Query</option>
				    	<option value="Report a User">Report a User</option>
				    	<option value="Security & Fraud">Security & Fraud</option>
				    	<option value="Share your B4MX experience">Share your B4MX experience</option>
				    	<option value="Banner advertising">Banner advertising</option>
				    	<option value="Other">Other</option>
				    </select> 
			  	</div>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<div class="form-group">
				    <label for="descriptionTxt">{{trans('label-terms.description')}}</label>
				    <textarea class="form-control" rows="5" id="descriptionTxt" name="txtFeedbackDescription" required></textarea>
			  	</div>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<label for="photoLabel">{{trans('label-terms.photos')}}</label>
				<div class="form-group">
					<div class="file-input-div">			    
						<label for="uploadPhotoTxt" id="photoLabel" class="label-buttons">{{trans('instruction-terms.choosephototoupload')}}</label> <label class="label-buttons" onclick="clearImages();">Clear</label>
						<h6 class="place-ads-photo-message">{{trans('instruction-terms.addupto10photos')}}</h6>
						<div id="gallerySection" class="gallery"></div>
						<input type="file" multiple="multiple" id="uploadPhotoTxt" name="feedback_img_path[]" maxLimit="6" class="inputfile" style="display: none;" accept="image/*" onchange="addNewImages(this);"/>
						<input type="hidden" id="imageCounter" name="imageCounter" value="0"/>
						<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
							<div id="imagePreviewerBox">
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-xs-12 form-rows">
					<a id="clearFormBtn" class="btn btn-primary btn-block delete-buttons-feedback uppercase-text">{{trans('buttons.reset')}}</a>
				</div>

				<div class="col-lg-6 col-md-6 col-xs-12 form-rows">
					<button class="btn btn-primary btn-block submit-buttons uppercase-text">{{trans('buttons.submit')}}</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
</div>

<script>

	$( document ).ready(function() {

		$('#testBtn').click(function(){

			jsonObj = [];
			var imagePaths = $('.image-editing-box');

        	for(var i = 0; i < imagePaths.length; i++){				  

			    item = { source:  $(imagePaths[i]).attr('data-src') };
			    console.log($(imagePaths[i]).attr('data-src'));
		        jsonObj.push(item);
			}

			var imageData = JSON.stringify(jsonObj);

			$.ajax({

				type: "POST",
				url: 'postIp',
				contentType: false,
				processData: false,
				enctype: 'multipart/form-data',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: imageData,
				dataType: "html",
				success: function(data) {

				if(data.success = "success"){					
				}
				else{
					
				}
				  
				},
				error: function() {
				  alert("{{trans('message-box.somethingwrong')}}");
				}
		    });
		});
	});
	
	function addNewImages(fileUploader){
	if (fileUploader.files) {
		var count = $("#imageCounter").val();
        var filesAmount = fileUploader.files.length;

        for (i = 0; i < filesAmount; i++) {

            var reader = new FileReader();

            reader.onload = function(e) {

            	$('#imagePreviewerBox').append('<div id="' + $("#imageCounter").val() + '" class="col-lg-2 col-md-2 col-xs-6 image-editing-box" data-src="' + event.target.result + '" style="background-image: url(' + event.target.result + '); background-size: cover; height: 150px; border: 5px solid white; background-position: 50% 50%;"><input id="image' + $("#imageCounter").val() + '" name="hiddenImageBase64[]" class="hiddenUploadImages" type="hidden" value="' + event.target.result + '"/><i id="deleteSign" class="fa fa-times" aria-hidden="true" style="float: right; font-size: 25pt; margin-top: 5px; color: red;" onclick="deleteImage(' + $("#imageCounter").val() + ');"></i></div>');

            	$("#imageCounter").val((parseInt($("#imageCounter").val())+1));
	        }

	        if($("#imageCounter").val() <= 10){
		        reader.readAsDataURL(fileUploader.files[i]); 
		    }
        }
    }
}

function clearImages(){
	$('.image-editing-box').remove();
	$("#imageCounter").val(0);
}

function deleteImage(imageId){
	if($('#primaryImageIdHidden').val() == imageId){
		if($('#imageCounter').val() == 1){
			clearImages();
		}
		else{
			alert("{{trans('message-box.unabletodeleteimage')}}");
		}
	}
	else{
		$('#'+imageId).remove();
		$('#imageCounter').val($('#imageCounter').val() - 1);
	}
}

function outImage(imageId){
	$('#deleteSign').remove();
}

	$(document).ready(function(){
		$('#clearFormBtn').click(function(e){
			e.preventDefault();

			$("[name='txtFeedbackName']").val('');
			$("[name='txtFeedbackPhone']").val('');
			$("[name='txtFeedbackEmail']").val('');
			$("[name='txtFeedbackSubject']").val('');
			$("[name='txtFeedbackDescription']").val('');
			clearImages();
		});
	});

</script>
	
@endsection
