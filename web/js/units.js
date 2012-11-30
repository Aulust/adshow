function changeUnitType(value) {
		$('#unitImageDiv').toggleClass('hidden');
		$('#unitLinkDiv').toggleClass('hidden');
		$('#unitHtmlDiv').toggleClass('hidden');

}

function changeImageUploadType() {
	if($('#imageUrl')[0].type=='file')
		$('#imageUrl')[0].type='text';
	else
		$('#imageUrl')[0].type='file';
}

$(document).ready(function(){
    $('#unitType').change( function() {
        changeUnitType(this.value);
    });
    $('#changeTypeBtn').click( function() {
        changeImageUploadType();
    });
});
