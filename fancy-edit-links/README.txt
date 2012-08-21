README:

some examples:

      new_edit_link(54); 														//edit post with an ID of 54;
      new_edit_link(54, 'Modify this text'); 									//edit post with an ID of 54, the link text says 'Modify this text';
      new_edit_link(); 															//edit post whichever is the current post in the loop ';
	  new_edit_link(array('new' => 'windows'), 'Add New'); 						//create new post, of custom post type 'windows' - text reads 'Add New'
	  new_edit_link(array('post_type' => 'windows')); 							//view custom post list of type  'windows',
	  new_edit_link(array('delete' => '53', 'fadeparent' => '.product')); 		//delete post with ID 53, then fadeout it's first parent with jquery selector '.product',
	  new_edit_link(array('media' => '53'), 'Upload a New Image');				//show the media uploader for the post with ID 53, text is 'Upload a new image'

you will need to drop this function into the <head> of your site: load_editlink_scripts();
the first parameter is boolean - if false it will not load fancybox.js, obviously if you already have it in your site you don't need to load it twice.

