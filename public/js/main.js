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

	/**** Add or Remove Itineraries  */

	$(document).on("change", "#days", function(){
		const numberofDays = $(this).val();
		$.ajax({
			url: "get-accordion",
			method: "GET",
			data: {days: numberofDays },
			success : function(response){
				console.log(response[1] + " " + numberofDays);
				if(response[1] < numberofDays){
					$('.accordion').last().remove();
				}
				else{
					$('.accordion').append(response);
				}
				
			}
		});
	});

	
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
