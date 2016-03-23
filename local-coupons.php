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
				return "view-coupon.php/$alias.html";
				//return "view-coupon.php?id=$alias";
			}
		)
	);
?>
