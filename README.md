# Fancy Edit Links for Wordpress

http://www.designforhumans.co.uk

## Description

This plugin allows WordPress sites to be edited from the front end, to save the hassle of visiting **/wp-admin** everytime your clients want to edit part of your site. Once a user is logged in it loads the wordpress admin panel in an overlay (using the FancyBox jQuery script: <http://fancybox.net/>), you trigger the overlay using links placed in your templates, these links only show once a user is logged in (in a similar manner to the default wordpress edit links)

## Roadmap

Really this plugin should:

a) Ensure the JS hooks into the wp_head action
b) Ensure that the edit links don't have to be called using their own function, but instead hook into the existing wordpress edit links which simply redirect to the wp-admin

## Installation

Install the plugin through wordpress in the usual way, then ensure that in your **&lt;head&gt;** you call the function
	
	load_editlink_scripts($load_fancybox = true);

The first parameter is boolean - if false it will not load fancybox.js, obviously if you already have it in your site you don't need to load it twice.

## Functions

	new_edit_link(54); //edit post with an ID of 54;
	new_edit_link(54, 'Modify this text'); //edit post with an ID of 54, the link text says 'Modify this text';
	new_edit_link(); //edit post whichever is the current post in the loop ';
	new_edit_link(array('new' => 'windows'), 'Add New'); //create new post, of custom post type 'windows' - text reads 'Add New'
	new_edit_link(array('post_type' => 'windows')); //view custom post list of type 'windows',
	new_edit_link(array('delete' => '53', 'fadeparent' => '.product')); //delete post with ID 53, then fadeout it's first parent with jquery selector '.product',
	new_edit_link(array('media' => '53'), 'Upload a New Image');

### Login Link

You can generate a link to load the wp-admin login box - also from the front end - place this function in your templates somewhere:

	fancy_login_link($intext = 'Login', $outtext = 'Logout', $class = '')

### Examples

[Click here to view an example of the edit links in action](http://www.designforhumans.co.uk/blog/imgs/overlay.png)
[Click here to view an example of the login overlay ](http://www.designforhumans.co.uk/blog/imgs/login.png)