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

      new_edit_link(54); 																//edit post with an ID of 54;
      new_edit_link(54, 'Modify this text'); 											//edit post with an ID of 54, the link text says 'Modify this text';
      new_edit_link(); 																	//edit post whichever is the current post in the loop ';
	  new_edit_link(array('new' => 'windows'), 'Add New'); 								//create new post, of custom post type 'windows' - text reads 'Add New'
	  new_edit_link(array('post_type' => 'windows')); 									//view custom post list of type  'windows',
	  new_edit_link(array('delete' => '53', 'fadeparent' => '.product')); 				//delete post with ID 53, then fadeout it's first parent with jquery selector '.product',
	  new_edit_link(array('media' => '53'), 'Upload a New Image');						//show the media uploader for the post with ID 53, text is 'Upload a new image'
	  new_edit_link(array('post_type' => 'snippet', 'post_name' => 'product info'));	//edit post titled 'product info' with a post type of 'snippet'
	  new_edit_link(array(post_name' => 'contact us'));									//edit post titled 'contact us'
	  
	  

you will need to drop this function into the header or footer of your site: load_editlink_scripts();
the first parameter either loads fancybox or not, obviously if you already have it you don't need to load it twice.

*/


function load_editlink_scripts($nofancybox = false){
//if your site already loads fancybox - add 'no-fancybox' as the first parameter of this script.


$plugin_folder = get_bloginfo('url').'/wp-content/plugins/fancy-edit-links/scripts/';

$str = '';

if(!$nofancybox){
$str .='<script type="text/javascript" src="'.$plugin_folder.'fancybox/jquery.fancybox-1.3.4.pack.js"></script>';
$str .='<link rel="stylesheet" href="'.$plugin_folder.'fancybox/jquery.fancybox-1.3.4.css" type="text/css" />';
}

$str .='<script type="text/javascript" src="'.$plugin_folder.'fancy-edit-links-public.js"></script>';

if(current_user_can('editor') || current_user_can('administrator')){ $str .='<script type="text/javascript" src="'.$plugin_folder.'fancy-edit-links.js"></script>'; }


echo $str;
	
	}
	
function new_edit_link($uri = false, $text = 'Edit This', $class = ''){

if(!(current_user_can('editor') || current_user_can('administrator'))){ return false; }

$admin_url = get_admin_url();
$newclass = '';

if(!$uri){
	
	global $post;
	$segment = 'post.php?post='.$post->ID.'&action=edit&sidex=none';
	
	}
	elseif(!is_numeric($uri) && is_string($uri)){

	$segment = $uri;

	}
	elseif(is_numeric($uri)){

	$segment = 'post.php?post='.$uri.'&action=edit';

	}
	elseif(array_key_exists('id', $uri)){
	
	$id = isset($uri['id']) ? $uri['id'] : $uri;
	
	$segment = 'post.php?post='.$id.'&action=edit';
	
	}
	elseif(isset($uri['post_type']) && isset($uri['name'])){
	
	$page = get_page_by_title( $uri['name'], 'OBJECT', $uri['post_type'] );
	$segment = 'post.php?post='.$page->ID.'&action=edit';
	
	}
	elseif(isset($uri['post_type'])){
	
	$segment = 'edit.php?post_type='.$uri['post_type'].'&sidex=none';
	
	}
	elseif(isset($uri['name'])){
	
	$page = get_page_by_title($uri['name']);
	$segment = 'post.php?post='.$page->ID.'&action=edit';
	
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
						$("#wpcontent").css({"margin-left": "15px", "padding-top" : "0px"});
						$(".update-nag").hide();
						$("#adminmenuback").hide();
						$("#wpadminbar").hide();
						$("#wphead").hide();
						$("#message.updated").hide();
						$("#footer").css({"margin-left": "15px"});
						}
					
					});
	
	</script>';
	
}	

function fancy_login_link($intext = 'Login', $outtext = 'Logout', $class = ''){
	
	$class = 'fancylogin '.$class;

	if(is_user_logged_in()){ 
	
	echo '<a href="'.wp_logout_url(home_url()).'"  class="'.$class.'" title="Logout">'.$outtext.'</a>';
	return;
	}else{
	
	
	echo '<a href="'.get_admin_url().'admin.php?page=fl-close-login.php" class="fancylogin_signin '.$class.'">'.$intext.'</a>';
	
	}
	
	}
	
	function myplugin_render_edit_page() {
    ?>
    
 
<script type="text/javascript">

	jQuery(function($){

if (window!=window.top){
						
						$("#adminmenu").hide();
						$("#wpbody").css("margin-left","15px");
						$("#wpcontent").css({"margin-left": "15px", "padding-top" : "0px"});
						$(".update-nag").hide();
						$("#adminmenuback").hide();
						$("#wpadminbar").hide();
						$("#wphead").hide();
						$("#message.updated").hide();
						$("#footer").hide();
						}
					
				
					
parent.$.fancybox.close();


});

</script>

<p style="font-family:'Helvetica Neue', Arial, Helvetica, sans-serif; font-weight:300; font-size:20px; padding:20px; color:#888;">Loading...</p>

    
    <?
	
	}

/**
 * Manage menu items and pages.
 */
	function myplugin_register_admin_page() {
    global $_registered_pages;

    $menu_slug = plugin_basename('fl-close-login.php');
    $hookname = get_plugin_page_hookname($menu_slug,'');
    if (!empty($hookname)) {
        add_action($hookname, 'myplugin_render_edit_page');
    }
    $_registered_pages[$hookname] = true;
	}
	add_action('admin_menu', 'myplugin_register_admin_page');

add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo()
{
	echo '<style type="text/css">
	
	#login { padding-top:40px!important;} #backtoblog{display:none!important;}
	
	</style>';
	
}

?>