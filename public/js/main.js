// jQuery(document).ready(function ($) {
// 	$('.table').DataTable();
// });

jQuery(document).ready(function ($) {
	$('.table').DataTable();

	$(document).on("click", ".delete", function(){
		showConfirmModal("Are you sure?", "This action will delete you selected Testimonial. Confirm to proceed!", $(this));
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
			window.location = element.data("href");
		}else{
			// nothing to do
		}
	});
}
