<?

/*
Plugin Name: Fancy Edit Links
Plugin URI: http://designforhumans.co.uk
Description: Allows user to create fancy edit links
Author: Ashley Ward
Version: 1.0
Author URI: http://designforhumans.co.uk
*/

/*

some examples:

      new_edit_link(54); 														//edit post with an ID of 54;
      new_edit_link(54, 'Modify this text'); 									//edit post with an ID of 54, the link text says 'Modify this text';
      new_edit_link(); 															//edit post whichever is the current post in the loop ';
	  new_edit_link(array('new' => 'windows'), 'Add New'); 						//create new post, of custom post type 'windows' - text reads 'Add New'
	  new_edit_link(array('post_type' => 'windows')); 							//view custom post list of type  'windows',
	  new_edit_link(array('delete' => '53', 'fadeparent' => '.product')); 		//delete post with ID 53, then fadeout it's first parent with jquery selector '.product',
	  new_edit_link(array('media' => '53'), 'Upload a New Image');				//show the media uploader for the post with ID 53, text is 'Upload a new image'

you will need to drop this function into the <head> of your site: load_editlink_scripts();
the first parameter either loads fancybox or not, obviously if you already have it you don't need to load it twice.

*/


function load_editlink_scripts($nofancybox = false){
//if your site already loads fancybox - add 'no-fancybox' as the first parameter of this script.

if(!current_user_can('administrator')){ return false; }

$plugin_folder = get_bloginfo('url').'/wp-content/plugins/fancy-edit-links/scripts/';

$str = '';

if(!$nofancybox){
$str .='<script type="text/javascript" src="'.$plugin_folder.'fancybox/jquery.fancybox-1.3.4.pack.js"></script>';
$str .='<link rel="stylesheet" href="'.$plugin_folder.'fancybox/jquery.fancybox-1.3.4.css" type="text/css" />';
}

$str .='<script type="text/javascript" src="'.$plugin_folder.'fancy-edit-links.js"></script>';

echo $str;
	
	}
	
function new_edit_link($uri = false, $text = 'Edit This', $class = ''){

if(!current_user_can('administrator')){ return false; }

$admin_url = get_admin_url();
$newclass = '';

if(!$uri){
	
	global $post;
	$segment = 'post.php?post='.$post->ID.'&action=edit&sidex=none';
	
	}
	elseif(isset($uri['id']) || is_numeric($uri)){
	
	$id = isset($uri['id']) ? $uri['id'] : $uri;
	
	$segment = 'post.php?post='.$id.'&action=edit&sidex=none';
	
	}
	elseif(isset($uri['post_type'])){
	
	$segment = 'edit.php?post_type='.$uri['post_type'].'&sidex=none';
	
	}
	elseif(isset($uri['attachment_id'])){
	
	$segment = 'media.php?attachment_id='.$uri['attachment_id'].'&action=edit&sidex=none';
	
	}
	elseif(isset($uri['new'])){
	
	$segment = 'post-new.php?post_type='.$uri['new'];
	
	}
	elseif(isset($uri['delete'])){
	
	if(!is_numeric($uri['delete'])){ return; }
	
	$nonce = wp_create_nonce('del_nonce_'.$uri['delete']);
	
	$newlink = $admin_url."admin-ajax.php?action=fancydelete&_wpnonce=".$nonce."&post=".$uri['delete'];
		
	$link = '<a data-fade-parent="'.@$uri['fadeparent'].'" class="fancy_edit_link fancy_edit_delete '.$class.'" href="'.$newlink.'">'.$text.'</a>';

	return $link;

	}
	elseif(isset($uri['media'])){
	
	$segment = 'media-upload.php?post_id='.$uri['media'];
	$newclass = 'fancy_edit_media '.$class;
	
	}
	elseif(is_string($uri)){
		
	$segment = $uri.'&sidex=none';
		
	}
	else{}
	
	if($newclass == ''){$newclass = 'fancy_edit_frame '.$class; }
	
	$link = '<a class="fancy_edit_link '.$newclass.'" href="'.$admin_url.$segment.'">'.$text.'</a>';
	
	return $link;
}


add_action( 'wp_ajax_fancydelete', 'myajax_fancydelete' );
 
function myajax_fancydelete() {
	
	 if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'del_nonce_'.$_GET['post'] ) ){echo 'incorrect nonce', die(); }
	
	$postid = $_GET['post'];
	
	wp_delete_post($postid);
	
	echo 'done'; exit();
	
	
}


add_action('admin_head', 'fancy_hide_sidebar');

function fancy_hide_sidebar()
{
	
	//if($_GET['sidex=none']);	
	echo '<script type="text/javascript">
	
	jQuery(function($){
					
					if (window!=window.top){
						
						$("#adminmenu").hide();
						$("#wpbody").css("margin-left","15px");
						$(".update-nag").hide();
						$("#wphead").hide();
						$("#message.updated").hide();
						}
					
					});
	
	</script>';
	
}	

?>