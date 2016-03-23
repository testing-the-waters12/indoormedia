<?php

	include('resources/library/misc.php');

	showContentBrowser(
		array(
			'title' => 'REGISTER TAPE TESTIMONIAL',
			'summary' => 'https://couponsapi.rtui.com/testimonials/tape?',
			'getShortcut' => function($info) {
				return "https://www.rtui.com/$info->alias";
			}
		)
	);
?>
