<?php
	include('resources/library/misc.php');

	$id = array_key_exists('id',$_GET) 
			? $_GET['id'] 
			:  pathinfo( basename($_SERVER['REQUEST_URI']), PATHINFO_FILENAME);

	$url = "https://couponsapi.rtui.com/coupons/$id";
	$details = getCurlJSON($url);
	$coupon = $details->coupon;
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<title><?=$coupon->title?></title>
        <meta charset="utf-8" />
		<meta name="description" content="Coupons,<?=$coupon->title?>,RTUI" />
		<style>
			div.coupon_details, .details_panel {
				padding: 10px;
				margin: 10px;
			}
		</style>
        <?php include("resources/templates/includes.php"); ?>
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-2">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 coupon_details">
				<h4><?=$coupon->title?></h4>
				<img src="http://www.rtui.com/uploads/coupons/<?=$coupon->filename?>" class="img-responsive center-block" />
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 coupon_details">
				<?php
					showDetailsPair('Featured By', $coupon->store);

					$url = $coupon->website;
					if ( $url ) {
						$matches = array();
						if ( preg_match('/:\/\/(.*)$/i',$url, $matches) ) {
							$url = $matches[1];
						}
						$website = sprintf('<a href="http://%s" target="_blank">%s</a>',$url, $url);
						showDetailsPair('Website', $website);
					}
				
					$address = join(' ', array($coupon->address,$coupon->city,$coupon->state,$coupon->zip));
					showDetailsPair('Main Address', $address);

					showDetailsPair('Phone', $coupon->phone);
				?>
				<a href="https://www.google.com/maps/place/<?=$address?>/" target="_blank">
					<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?=$address?>&size=300x300&markers=color:red|<?=$address?>" style="border:1px solid lightgray;margin-top:10px;" />
				</a>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-2">
			</div>
		</div>

        <?php 
			include("resources/templates/footer.php"); 
		?>
    </body>
</html>
