<?php

require 'functions/dgk-recent-posts.php';

remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('template_redirect', 'rest_output_link_header', 11);
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

add_action('init', function () {
	add_shortcode('dgk_recent', 'dgk_recent_posts');
});
