$(function(){
		   
		   $('.fancy_edit_frame').fancybox({ 'type' : 'iframe', 'width' : '85%', 'height' : '85%', 'overlayColor' : '#000', 'padding' : '0', 'centerOnScroll' : true, 
										  
										  'onClosed' :  function(){
											   window.location.reload();
											   }
										  });
		   
		   
		   $('.fancy_edit_delete').click(function(e){
												  e.preventDefault();
												  el = $(this);
												  href = el.attr('href');
												  fadeparent = el.attr('data-fade-parent');
												 	$.post(href, function(){
																														
													 if(fadeparent)
													{
													el.parents(fadeparent).first().fadeOut();
																			
													}
																		  
																		  
																		  });
												
												  
												  });
		   
		   $('.fancy_edit_media').fancybox({ 'type' : 'iframe', 'width' : 650, 'height' : 560, 'autoDimensions' : false, 'overlayColor' : '#000', 'padding' : '0', 'centerOnScroll' : true, 
										  
										  'onClosed' :  function(){
											   window.location.reload();
											   }
										  });
		  
		   
		   });
