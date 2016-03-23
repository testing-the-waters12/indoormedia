<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<script>
    window.onload = function() {
		var base = 'http://127.0.0.1/indoormedia/',
			urls = [
		        'index.php',
				'cart-advertising.php',
				'tape-advertising.php',
				'custom-print-advertising.php',
				'restaurant-advertising.php',
				'nail-hair-salons.php',
				'realtor-advertising.php',
				'local-coupons.php',
				'tape-testimonials.php',
				'tape-video-testimonials.php',
				'cart-testimonials.php',
				'cart-video-testimonials.php',
				'contact-us.php',
				'view-coupon.php?id=401544-shawn-s-smokehouse-bbq-martins.html',
				'view-video.php?video=http://www.rtui.com/images/videos/Mr_Chicken_NE_Ohio.mp4&name=Mr%20Chicken%20NE%20Ohio',
				'view-video.php?video=http://www.cartvertising.com/images/videos/ruby_tuesday_hawaii.mp4&name=Ruby%20Tuesday%20Hawaii'
			];

		urls.forEach( function(url) {
			window.open( base+url, '_blank' );
		});
    }
</script>
</body>
</html>
