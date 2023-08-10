jQuery(document).ready(function ($) {
	$('.table').DataTable();
	$('.js-example-basic-multiple').select2();
	$(document).on("click", ".delete", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Testimonial. Confirm to proceed!", $(this));
	});

	$(document).on("click", ".delete-addon", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Addon. Confirm to proceed!", $(this));
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