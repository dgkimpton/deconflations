<?php

require 'functions/gallery-listing.php';
require 'functions/gallery.php';
require 'functions/recent-posts.php';
require 'functions/external-links.php';

remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('template_redirect', 'rest_output_link_header', 11);
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

add_action('init', function () {
	add_shortcode('dgk_recent', 'dgk\recent_posts');
	add_shortcode('dgk_gallery_listing', 'dgk\gallery_listing');
	add_shortcode('dgk_gallery', 'dgk\gallery');
});

add_filter('the_content', 'dgk\external_links', 1000);
add_filter('syntax_highlighting_code_block_styling', '__return_false');
