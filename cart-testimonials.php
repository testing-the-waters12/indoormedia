<?php

	include('resources/library/misc.php');

	showContentBrowser(
		array(
			'title' => 'CARTVERTISING TESTIMONIAL',
			'summary' => 'https://couponsapi.rtui.com/testimonials/cart?',
			'getShortcut' => function($info) {
				return $info->alias;
			}
		)
	);
?>
