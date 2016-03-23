<?php 
	require_once('resources/library/misc.php'); 
	require_once('styles-and-scripts.php'); 
?>
</head>
<body>
<div class="menu">
    <div class="container">
        <div class="row">
            <div class="col-md-1 col-md-offset-1">
                <a href="index.php">
                    <img src="img/indoormedia.png" alt="indoor media" class="center-block todo" />
                </a>
            </div>

            <div class="col-md-9 col-md-offset-1">

                <h4 class="text-right">
					<?php
						$contact = '1-800-247-4793';
						if ( array_key_exists('s',$_GET) ) {
							$user = getCurlJSON("https://couponsapi.rtui.com/user-info/$_GET[s]");
							if ( $user->displayName && $user->telephoneNumber ) {
								$contact = "Call $user->displayName at $user->telephoneNumber";
							}
						}
						echo $contact;
					?>
				</h4>

                <nav class="main_menu">
                    <ul>
                        <li>
							<a href="#">ADVERTISING  SOLUTIONS</a>
                            <ul>
                                <li><a href="cart-advertising.php">Cartvertising</a></li>
                                <li><a href="tape-advertising.php">Register Tapes</a></li>
                                <li><a href="custom-print-advertising.php">Custom Print</a></li>
                                <li><a href="restaurant-advertising.php">Restaurant Advertising</a></li>
                                <li><a href="nail-hair-salons.php">Hair and Nail Salon Advertising</a></li>
                                <li><a href="realtor-advertising.php">Realtor Advertising</a></li>                                
                            </ul>
                        </li>

                        <li><a href="local-coupons.php">FREE COUPONS</a></li>

                        <li>
							<a href="#">TESTIMONIALS</a>
                            <ul>
                                <li><a href="tape-testimonials.php">Tape Testimonials</a></li>
                                <li><a href="tape-video-testimonials.php">Tape Video Testimonials</a></li>
                                <li><a href="cart-testimonials.php">Cart Testimonials</a></li>
                                <li><a href="cart-video-testimonials.php">Cart Video Testimonials</a></li>
                            </ul>
						</li>

                        <li><a href="https://www.ziprecruiter.com/candidate/search?search=RTUI">CAREER</a></li>

                        <li><a href="contact-us.php">CONTACT US</a></li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>
