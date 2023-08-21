const domainURL = document.location.origin;

jQuery(document).ready(function ($) {
	$('.table').DataTable();

	$('.js-example-basic-multiple').select2();

	$(document).on("click", ".delete", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Testimonial. Confirm to proceed!", $(this));
	});

	$(document).on("click", ".delete-addon", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Addon. Confirm to proceed!", $(this));
	});
	
	$(document).on("click", ".delete-property", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Property. Confirm to proceed!", $(this));
	});

	$(document).on("click", ".delete-package", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Package. Confirm to proceed!", $(this));
	});

	$(document).on("click", ".delete-thumbnail", function(){
		showConfirmModalforThumbnail("Are you sure?", "This action will delete you selected Thumbnail. Confirm to proceed!", $(this));
	});


	function showConfirmModal($title, $text, element){
		swal({
			title: $title,
			text: $text,
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((confirmed) => {
			if (confirmed) {
				$id = element.data("id");
				window.location = window.location.href + '/delete/' + $id;
			}else{
				// nothing to do
			}
		});
	}
	

	function showConfirmModalforThumbnail($title, $text, element){
		swal({
			title: $title,
			text: $text,
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((confirmed) => {
			if (confirmed) {
				$id = element.data("id");
				window.location = domainURL + '/admin/packages/delete-thumbnail/' + $id;
			}else{
				// nothing to do
			}
		});
	}
	

	/**** Add or Remove Itineraries  */


	$(document).on("change", "#numberofDays", function(){
		const numberofDays = $(this).val();
		const currentItems = $("#packageItinerariesItems").find(".itinerary-item").length;
		if(numberofDays < currentItems){
			removeExtraItineraries(numberofDays);
		}else{
			const addNewdays = (numberofDays - currentItems);
			$.ajax({
				url: domainURL+"/admin/packages/get-accordion",
				method: "POST",
				data: { addNewdays, currentItems },
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				
				success : function(response){
					$('.accordion').append(response.content);
				}
			});	
		}
	});
	
});



function removeExtraItineraries(numberofDays){
	$("#packageItinerariesItems .itinerary-item").each(function(index,element){
		if( (index+1) > numberofDays){
			$(this).remove();
		}
	})
}



/***** File Reading */

function PreviewImage() {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);

	oFReader.onload = function (oFREvent) {
		document.getElementById("uploadPreview").src = oFREvent.target.result;
		document.getElementById("uploadPreview").classList.remove("d-none");
		document.querySelector(".imgMessage").classList.add("d-none");
	};
};

/******* Tiny MCE textarea */
tinymce.init({
	selector: '.post-description', 
	plugins: 'code table lists',
	toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
});

/** Multiple image Preview */

const preview = (file) => {
	const fr = new FileReader();
	fr.onload = () => {
	  const img = document.createElement("img");
	  img.src = fr.result; 
	  img.alt = file.name;
	  
	  document.querySelector('#preview').append(img);
	};
	fr.readAsDataURL(file);
};
  
document.querySelector("#thumbnail").addEventListener("change", (ev) => {
	if (!ev.target.files) return; 
	[...ev.target.files].forEach(preview);
});


// $(function () {
// 	$('[id*=fuUpload1]').change(function () {
// 		if (typeof (FileReader) != "undefined") {
// 			var dvPreview = $("[id*=dvPreview]");
// 			var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
// 			$($(this)[0].files).each(function () {
// 				var file = $(this);
// 				if (regex.test(file[0].name.toLowerCase())) {
// 					var reader = new FileReader();
// 					reader.onload = function (e) {
// 						var img = $("<img />");
// 						img.attr("style", "max-height:250px;width: 150px");
// 						img.attr("src", e.target.result);
// 						var div = $("<div style='float:left;' />");
// 						$(div).html("<span style='float:right;' class='closeDiv'>X<span>");
// 						div.append(img);

// 						dvPreview.append(div);
// 					}
// 					reader.readAsDataURL(file[0]);
// 				} else {
// 					alert(file[0].name + " is not a valid image file.");
// 					dvPreview.html("");
// 					return false;
// 				}
// 			});
// 		} else {
// 			alert("This browser does not support HTML5 FileReader.");
// 		}
// 	});

// 	$('body').on('click', '.closeDiv', function () {
// 		$(this).closest('div').remove();
// 	});
// });