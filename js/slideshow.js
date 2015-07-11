// JavaScript Document

$(document).ready(function(){
	
	$("img[rel]").overlay();
	
	$("#slideshow > div:gt(0)").hide();
	
	setInterval(function() { 
	  $('#slideshow > div:first')
		.fadeOut(1000)
		.next()
		.fadeIn(1000)
		.end()
		.appendTo('#slideshow');	  
	},  6000);
});

/* http://css-tricks.com/snippets/jquery/simple-auto-playing-slideshow/ */

// Other functions - utils
function loadPage(page){
	$("#paginas").attr("src",page);
}

function submitForm(formid){
	document.getElementById(formid).submit();
}




