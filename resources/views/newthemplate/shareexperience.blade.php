@include("newthemplate.header")
<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
	</div>

	<div class="row">
		<!-- Share Experience Section -->
		<div class="col-lg-12 col-md-12 col-xs-12 header-div">
			<h6 class="header-title">@php echo \App\Language::GetTextSearch(trans('label-terms.contactusbysendingemailto')) @endphp</h6>
				<a href="mailto:support@b4mx.com" target="_top" class="bt-blue-support">support@b4mx.com</a>
		</div>

		<div class="col-lg-12 col-md-12 col-xs-12" style="text-align: center;">
			<h6 class="header-title" style="color:#002450; font-weight: 600;">
				@php echo \App\Language::GetTextSearch(trans('label-terms.or').' '.trans('instruction-terms.filluptheformbelow')) @endphp
			</h6>
		</div>

		@if (count($errors) > 0)
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li style=" text-align: center; list-style: none; margin-bottom: 20px; color: #bb0505; ">{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		@if (\Session::has('success'))
		    <div class="alert alert-success">
		        <ul>
		            <li style=" text-align: center; list-style: none; margin-bottom: 20px; color: green; ">{!! \Session::get('success') !!}</li>
		        </ul>
		    </div>
		@endif

		<form method="POST" action="sendFeedbackEmail" enctype="multipart/form-data" id="feedbackForm">
			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<label for="feedbackName">@php echo \App\Language::GetTextSearch(trans('label-terms.contactdetails')) @endphp</label>
				<input type="text" placeholder="@php echo \App\Language::GetTextSearch(trans('label-terms.name')) @endphp" class="form-control user-input" name="txtFeedbackName" id="feedbackName" required />
			</div>



			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<input type="text" placeholder="@php echo \App\Language::GetTextSearch(trans('label-terms.phone')) @endphp" class="form-control user-input" name="txtFeedbackPhone" required />
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<input type="text" placeholder="@php echo \App\Language::GetTextSearch(trans('label-terms.email')) @endphp" class="form-control user-input" name="txtFeedbackEmail" required />
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<br/>
				<div class="form-group">
				    <label for="subjectTxt">@php echo \App\Language::GetTextSearch(trans('label-terms.subject')) @endphp</label>
				    <select class="form-control user-input" id="subjectTxt" name="txtFeedbackSubject" required>
				    	<option value="Managing My Ad">@php echo \App\Language::GetTextSearch('Managing My Ad') @endphp</option>
				    	<option value="My B4MX Account">@php echo \App\Language::GetTextSearch('My B4MX Account') @endphp</option>
				    	<option value="B4MX Messenger">@php echo \App\Language::GetTextSearch('B4MX Messenger') @endphp</option>
				    	<option value="Payment Query">@php echo \App\Language::GetTextSearch('Payment Query') @endphp</option>
				    	<option value="Report a User">@php echo \App\Language::GetTextSearch('Report a User') @endphp</option>
				    	<option value="Security & Fraud">@php echo \App\Language::GetTextSearch('Security & Fraud') @endphp</option>
				    	<option value="Share your B4MX experience">@php echo \App\Language::GetTextSearch('Share your B4MX experience') @endphp</option>
				    	<option value="Banner advertising">@php echo \App\Language::GetTextSearch('Banner advertising') @endphp</option>
				    	<option value="Other">@php echo \App\Language::GetTextSearch('Other') @endphp</option>
				    </select> 
			  	</div>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<div class="form-group">
				    <label for="descriptionTxt">@php echo \App\Language::GetTextSearch(trans('label-terms.description')) @endphp</label>
				    <textarea class="form-control" rows="5" id="descriptionTxt" name="txtFeedbackDescription" required></textarea>
			  	</div>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<label for="photoLabel">@php echo \App\Language::GetTextSearch(trans('label-terms.photos')) @endphp</label>
				<div class="form-group">
					<div class="file-input-div">			    
						<label for="uploadPhotoTxt" id="photoLabel" class="label-buttons">@php echo \App\Language::GetTextSearch(trans('instruction-terms.choosephototoupload')) @endphp</label>
						<label class="label-buttons" onclick="clearImages();">@php echo \App\Language::GetTextSearch('Clear') @endphp</label>
						<span class="place-ads-photo-message">@php echo \App\Language::GetTextSearch(trans('instruction-terms.addupto10photos')) @endphp</span>
						<div id="gallerySection" class="gallery"></div>
						<input type="file" multiple="multiple" id="uploadPhotoTxt" name="feedback_img_path[]" maxLimit="6" class="inputfile" style="display: none;" accept="image/*" onchange="addNewImages(this);"/>
						<input type="hidden" id="imageCounter" name="imageCounter" value="0"/>
						<div class="full-width">
							<div id="imagePreviewerBox">
							</div>
						</div>
					</div>
				</div>

				<div class="submit-line">
					<a id="clearFormBtn" class="btn btn-primary btn-block delete-buttons-feedback uppercase-text">@php echo \App\Language::GetTextSearch(trans('buttons.reset')) @endphp</a>
					<button id="submitFormBtn" class="btn btn-primary btn-block submit-buttons uppercase-text">@php echo \App\Language::GetTextSearch(trans('buttons.submit')) @endphp</button>
				</div>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
</div>

<script src="/newthemplate/js/jquery.3.3.1.js"></script>
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

            	$('#imagePreviewerBox').append('<div id="' + $("#imageCounter").val() + '" class="col-lg-2 col-md-2 col-xs-6 image-editing-box" data-src="' + event.target.result + '" style="background-image: url(' + event.target.result + '); background-size: cover; height: 270px; background-position: 50% 50%;"><input id="image' + $("#imageCounter").val() + '" name="hiddenImageBase64[]" class="hiddenUploadImages" type="hidden" value="' + event.target.result + '"/><i id="deleteSign" class="fa fa-times" aria-hidden="true" style="float: right; font-size: 25pt; margin-top: 5px; color: red;" onclick="deleteImage(' + $("#imageCounter").val() + ');"></i></div>');

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

@include("newthemplate.footer")