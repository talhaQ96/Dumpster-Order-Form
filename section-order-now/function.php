<?php

$style_handles = register_blocks_style( THEME_TEXTDOMAIN . '-section-order-now', 'section-order-now.css', [] );

$config = [
	'style_handles' => $style_handles,
	'example' => [
		'attributes' => [
			'mode' => 'preview',
			'data' => [
				'block_preview_images' => [
					get_theme_file_uri('/dist/admin/img/block-previews/block-preview-section-contact.jpg'),
				]
			]
		]
	]
];