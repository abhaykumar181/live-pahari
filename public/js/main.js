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

	$(document).on("click", ".delete-page", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Page. Confirm to proceed!", $(this));
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

/******* Tiny MCE Textarea */
tinymce.init({
	height : "380",
	branding: false,
	selector: '.post-description', 
	plugins: 'code table lists',
	toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
});

/** Multiple image Preview */

// document.querySelector('#preview').find(img).remove();
const preview = (file) => {
	const img = document.createElement("img");
	img.src = URL.createObjectURL(file);
	img.alt = file.name;
	document.querySelector('#preview').append(img);
};
  
document.querySelector("#thumbnail").addEventListener("change", (ev) => {
	document.querySelector("#startUpload").classList.remove('d-none');
	if (!ev.target.files) return;
	jQuery('#preview').html('');
	[...ev.target.files].forEach(preview);
	
	console.log([...ev.target.files]);
});

