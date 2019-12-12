$(document).on('ready pjax:success', function() {
	$('.modal-button-01').click(function(e){
		e.preventDefault();
		$('#modal-id-01').modal('show').find('#modal-content-01').load($(this).attr('href'));  
	});
	
	$('.modal-button-02').click(function(e){
		e.preventDefault();
		$('#modal-id-02').modal('show').find('#modal-content-02').load($(this).attr('href'));  
	});
	
	$('.modal-button-03').click(function(e){
		e.preventDefault();
		$('#modal-id-03').modal('show').find('#modal-content-03').load($(this).attr('href'));  
	});
});

//print div
function printContent(pr){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(pr).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}

/********************************************************************/
$( document ).ready(function() {
	$(".notification").on('click', function(event){
		$(".notification").attr("aria-expanded","true");
		$(".notifications-menu").addClass( "open" );
	});
});

$( document ).ready(function() {
	$(".user").on('click', function(event){
		$(".user").attr("aria-expanded","true");
		$(".user-menu").addClass( "open" );
	});
});

/********************************************************************/


/*
$(document).ready(function(){
    $(".dropdown-toggle").dropdown();
});
*/
