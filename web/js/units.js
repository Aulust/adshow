function changeUnitType(value) {
		$('#unit_image_div').toggleClass('hidden show');
		$('#unit_link_div').toggleClass('hidden show');
		$('#unit_html_div').toggleClass('show hidden');

}

function changeImageUploadType() {
	if($('#imageUrl')[0].type=='file')
		$('#imageUrl')[0].type='text';
	else
		$('#imageUrl')[0].type='file';
}
