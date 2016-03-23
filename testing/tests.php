<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script   src="https://code.jquery.com/jquery-1.12.2.min.js"   integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk="   crossorigin="anonymous"></script>
</head>
<body>
<h1>
	<span id="content">
	</span>
</h1>
<script>
    window.onload = function() {
		var base = 'http://127.0.0.1/indoormedia/',
			urls = [

				// Basic pages
		        base+'index.php?s=ahmed.hammad',
				base+'cart-advertising.php?s=summer.xiao',
				base+'tape-advertising.php?s=eric.shafer',
				base+'custom-print-advertising.php?s=unknown.user',
				base+'restaurant-advertising.php',
				base+'nail-hair-salons.php',
				base+'realtor-advertising.php',
				base+'contact-us.php',

				// Summary pages
				base+'local-coupons.php',
				base+'tape-testimonials.php',
				base+'tape-video-testimonials.php',
				base+'cart-testimonials.php',
				base+'cart-video-testimonials.php',

				// Detail pages
				base+'view-coupon.php?id=401544-shawn-s-smokehouse-bbq-martins.html',
				base+'view-video.php?video=http://www.rtui.com/images/videos/Mr_Chicken_NE_Ohio.mp4&name=Mr%20Chicken%20NE%20Ohio',
				base+'view-video.php?video=http://www.cartvertising.com/images/videos/ruby_tuesday_hawaii.mp4&name=Ruby%20Tuesday%20Hawaii',

				// API pages
				'https://couponsapi.rtui.com/testimonials/tape',
				'https://couponsapi.rtui.com/testimonials/cart',
				'https://couponsapi.rtui.com/testimonials/tape/video',
				'https://couponsapi.rtui.com/testimonials/cart/video',
				'https://couponsapi.rtui.com/couponsGeneral',
				'https://couponsapi.rtui.com/coupons/401544-shawn-s-smokehouse-bbq-martins'
			];

		urls.forEach( function(url) {
			window.open(url, '_blank' );
		});

		$('#content').html('Opened ' + urls.length + ' pages in separate tabs');
    }
</script>
</body>
</html>
