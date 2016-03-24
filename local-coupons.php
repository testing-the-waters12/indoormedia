<?php

	include('resources/library/misc.php');

	showContentBrowser(
		array(
			'title' => 'COUPON',
			'summary' => 'https://couponsapi.rtui.com/couponsGeneral?',
			'previewBase' => 'http://www.rtui.com/uploads/coupons', 
			'imageBase' => 'http://www.rtui.com/uploads/couponsthumb',
			'getShortcut' => function($value) {
				$alias = basename($value->alias);

				/**
				* 2016-03-24 INFO: AHH
				* I'm disabling the SEO friendly URL because it changes the baseline URL.  The
				* obvious way around it is to use absolute URLs, but I don't want other maintainers
				* to have to worry about that, so until I change the implementation (e.g.: .htaccess)
				* I'm using query parameters.
				*/
				//return "view-coupon.php/$alias.html";
				return "view-coupon.php?id=$alias";
			}
		)
	);
?>
