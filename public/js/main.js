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

	/**** Add or Remove Itineraries  */

	/** Show itineraries on Load */
	/*$(function () {
		$("#days").change();
	});*/

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
