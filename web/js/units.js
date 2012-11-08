function changeUnitType(value){
	if(value=='html'){
	$('#unit_image_div')[0].style.display='none';
	$('#unit_link_div')[0].style.display='none';
	$('#unit_html_div')[0].style.display='';
	}
	else {
	$('#unit_image_div')[0].style.display='';
	$('#unit_link_div')[0].style.display='';
	$('#unit_html_div')[0].style.display='none';	
	}
}