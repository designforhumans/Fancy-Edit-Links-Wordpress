$(function(){
		   
		   		$('.fancylogin_signin').fancybox({ 'type' : 'iframe', 'width' : 410, 'height' : 450, 'overlayColor' : '#000', 'padding' : '0', 'scrolling': 'no', 'centerOnScroll' : true, 
										  
										  'onClosed' :  function(){
											   window.location.reload();
											   }
										  });
		  
		   
		   });