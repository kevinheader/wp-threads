<?php

// potential future enhancement - abstract to user setting?
function cfthr_enabled_post_types() {
// 	$enabled = array();
// 	$types = get_post_types();
// 	foreach ($types as $type) {
// d($type);
// 	}
// 	return $enabled;
	return array('post');
}

function cfth_register_taxonomy() {
	$types = cfthr_enabled_post_types();
	register_taxonomy(
		'threads',
		$types,
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __('Threads', 'threads'),
				'singular_name' => __('Thread', 'threads'),
				'search_items' => __('Search Threads', 'threads'),
				'popular_items' => __('Popular Threads', 'threads'),
				'all_items' => __('All Threads', 'threads'),
				'parent_item' => __('Parent Thread', 'threads'),
				'parent_item_colon' => __('Parent Thread:', 'threads'),
				'edit_item' => __('Edit Thread', 'threads'),
				'update_item' => __('Update Thread', 'threads'),
				'add_new_item' => __('Add New Thread', 'threads'),
				'new_item_name' => __('New Thread Name', 'threads'),
			),
			'sort' => true,
			'args' => array('orderby' => 'term_order'),
			'public' => false,
			'show_ui' => true,
		)
	);
}
add_action('init', 'cfth_register_taxonomy', 9999);

// Create Thread post type (bound to Threads taxonomy) to save meta
function cfth_tax_bindings($configs) {
	$configs[] = array(
		'taxonomy' => 'threads',
		'post_type' => array(
			'thread',
			array(
				'public' => true,
				'show_ui' => true,
				'label' => __('Threads', 'cfth'),
				'rewrite' => array(
					'slug' => 'thread',
					'with_front' => true,
					'feeds' => false,
					'pages' => false
				),
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
					'revisions'
				)
			)
		),
		'slave_title_editable' => false,
		'slave_slug_editable' => false,
	);
	return $configs;
}
add_filter('cftpb_configs', 'cfth_tax_bindings');

function cfth_hide_tax_nav() {
?>
<script>
jQuery(function($) {
	$('#newthreads_parent').remove();
	$('a[href*="edit-tags.php?taxonomy=threads"]').hide();
});
</script>
<?php
}
add_action('admin_footer', 'cfth_hide_tax_nav');
