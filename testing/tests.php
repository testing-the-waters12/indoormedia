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

				// Detail pages.  These don't require any api calls, as they use the data present
				base+'view-video.php?video=http://www.rtui.com/images/videos/Mr_Chicken_NE_Ohio.mp4&name=Mr%20Chicken%20NE%20Ohio',
				base+'view-video.php?video=http://www.cartvertising.com/images/videos/ruby_tuesday_hawaii.mp4&name=Ruby%20Tuesday%20Hawaii',

				// The tape testimonials and the raw data that feeds it
				base+'tape-testimonials.php',
				'https://couponsapi.rtui.com/testimonials/tape',

				// The cart testimonials and the raw data that feeds it
				base+'cart-testimonials.php',
				'https://couponsapi.rtui.com/testimonials/cart',

				// The tape video testimonials and the raw data that feeds it
				base+'tape-video-testimonials.php',
				'https://couponsapi.rtui.com/testimonials/tape/video',

				// The cart video testimonials and the raw data that feeds it
				base+'cart-video-testimonials.php',
				'https://couponsapi.rtui.com/testimonials/cart/video',

				// The local coupons summary and the raw data that feeds it
				base+'local-coupons.php',
				'https://couponsapi.rtui.com/couponsGeneral',

				// The coupons detail and the the raw data that feeds it
				base+'view-coupon.php?id=401544-shawn-s-smokehouse-bbq-martins.html',
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
