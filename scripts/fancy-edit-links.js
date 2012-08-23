$(function(){
		   
		   check_if_preview();
		   
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
		   
		 

			function check_if_preview()
			{
			
			if($.getUrlVar('preview') === 'true'){ $('.fancy_edit_link').remove(); }
			
				
			}
			
	
		   
		   });


			$.extend({
			  getUrlVars: function(){
				var vars = [], hash;
				var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
				for(var i = 0; i < hashes.length; i++)
				{
				  hash = hashes[i].split('=');
				  vars.push(hash[0]);
				  vars[hash[0]] = hash[1];
				}
				return vars;
			  },
			  getUrlVar: function(name){
				return $.getUrlVars()[name];
			  }
			});
			
			