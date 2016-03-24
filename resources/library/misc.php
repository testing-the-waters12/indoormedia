<?php

define('NO_PRODUCT', 0);
define('TAPE', 1);
define('CART', 2);
define('TAPE_AND_CART', 3);
define('CUSTOM_PRINT', 4);



function viewTestimonial ($info) {
	return "view-testimonial.php?id=$info->alias";
}

function viewVideo($value) {
	return "view-video.php?video=$value->alias&name=$value->name";
}


function getCurl($url) {
	$data = false;
	try {
		$ch = curl_init($url);
                    
        if (FALSE === $ch)
			echo('No Init');
                    
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
                    
        if (!$data) {
			echo curl_error($ch);

		}
                   
        curl_close($ch);
	} 
	catch (Exception $e) {
		echo('failed:'.$e->getCode().'---'.$e->getMessage());
	}        

	return $data;            

}



/**
* 2016-03-16 INFO: AHH
*	Returns  a PHP object corresponding to the JSON data found at $url.
*/
function getCurlJSON($url) {
	return json_decode( getCurl($url) );
}


/**
* 2016-03-16 INFO: AHH
*	Shows $tag, $value formatted as per the display rules for coupon details
*/
function showDetailsPair($tag, $value) {
	/**
	* 2016-03-16 INFO: AHH
	* Don't use <p> to space because the style sheet changes the color on a p
	*/
	echo "<div style=\"padding-top:20px;\">$tag<br />$value</div>";
}


/**
* 2016-03-16 INFO: AHH
*	Shows the Get Started form with the product corresponding to $selectedProductIndex
*	selected by default.
*/
function showGettingStartedForm($selectedProductIndex = NO_PRODUCT) {
	?>
	<iframe src="getting-started.php?getStartedProduct=<?=$selectedProductIndex?>" frameborder="0" name="gettingStarted" style="height:290px;width:255px;overflow:hidden;" scrolling="no">
	</iframe>
	<?php
}


/**
* 2016-03-17 INFO: AHH
* Creates a form input control in the desired style and highlights it if any data is missing.
*/
function showFormInput($type, $name, $placeholder) {
	?>
	<div class="form-group">
  		<input 
			type="<?=$type?>" 
			class="form-control center-block" 
			name="<?=$name?>" 
			id="<?=$name?>" 
			placeholder="<?=$placeholder?>" 
			value="<?= array_key_exists($name,$_GET) ? $_GET[$name] : '' ?>" 
			<?=highlightFormFieldIfMissing($name)?>
		/>
	</div>
	<?php
}


/**
* 2016-03-17 INFO: AHH
* Returns an error highlight the form input field $name is missing and we're in submit
* mode.  Otherwise, returns a blank string.
*/
function highlightFormFieldIfMissing($name) {
	return  sprintf('style="%s"', array_key_exists('submitted',$_GET) && !$_GET[$name] ? 'background-color:pink':'');
}


/**
* 2016-03-17 INFO: AHH
* Returns true if a field is set, false otherwise
*/

function fieldIsSet($field) {
	return array_key_exists($field,$_GET) && $_GET[$field]; 
}


/**
* 2016-03-17 INFO: AHH
* Processes the fields in $array for the get started operation.  Returns true if
* everything went ok, returns false otherwise.  This function is intended for
* end use, so the only status assumed needed is failure, to support a generic
* failed message.
*/
function processGetStartedForm($array) {
	$email = $array['getStartedEmail'];
	$zipcode = $array['getStartedZip'];
	$name = $array['getStartedName'];
	$product = $array['getStartedProduct'];

	$rawURL = "https://couponsapi.rtui.com/add-lead/$name/$email/$zipcode/$product";
	$encodedURL = str_replace(' ', '+', $rawURL);
	$results = getCurlJSON($encodedURL);
	return $results->success;
}



/**
* 2016-03-18 INFO: AHH
* Shows a thumbnail using the details in $value and $shortcut to zoom into details.
*/
function showCouponStyleContentThumbnail($detailsURL, $previewBase, $imageBase, $thumbnailInfo) {
	$image = $thumbnailInfo->filename;
	$thumbnailURL = $previewBase ? "$previewBase/$image" : $image;
	$imageURL = $imageBase ? "$imageBase/$image" : $image;
	$customer = $thumbnailInfo->name;
	$store = getPropertyValue($thumbnailInfo, 'store');
	$fullAddress = array(
		getPropertyValue($thumbnailInfo, 'address'), 
		getPropertyValue($thumbnailInfo, 'city'), 
		getPropertyValue($thumbnailInfo, 'state'), 
		getPropertyValue($thumbnailInfo, 'zip')
	);
	$address = join(' ', $fullAddress);
?>
	<div id="container76" class="coupcontainer reset-15 col-xs-12 col-md-6 col-lg-4">
		<div class="cp_img">
			<a href="<?=$detailsURL?>" title="<?=$customer?>" class="screenshot" rel="<?=$thumbnailURL?>">
				<img src="<?=$imageURL?>" alt="<?=$customer?>" class="img-responsive" style="width:100%;">            
			</a>
        </div>
        <div class="couppicr panel panel-default">
			<div class="coupcontl panel-body">
				<div class="cp_info">
					<div class="couptit ellipsis">
						<span>
							<a href="<?=$detailsURL?>" title="<?=$customer?> - <?=$store?>">
								<?=$customer?>
							</a>
                        </span>
                    </div>
					<div>
						<small class="coupaddress">
							<?=$address?>
						</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}


/**
* 2016-03-22 INFO: AHH
* Shows a thumbnail using the details in $value and $shortcut to zoom into details.
*/
function showTestimonialStyleContentThumbnail($detailsURL, $previewBase, $imageBase, $thumbnailInfo) {
	$image = $thumbnailInfo->filename;
	$thumbnailURL = $previewBase ? "$previewBase/$image" : $image;
	$imageURL = $imageBase ? "$imageBase/$image" : $image;
	$customer = $thumbnailInfo->name;
	$store = getPropertyValue($thumbnailInfo, 'store');
	$fullAddress = array($thumbnailInfo->address, $thumbnailInfo->city, $thumbnailInfo->state, $thumbnailInfo->zip);
	$address = join(' ', $fullAddress);
?>
	<div id="container76" class="coupcontainer reset-15 col-xs-12 col-md-10 col-lg-10 couppicr panel panel-default" style="margin-bottom:20px;padding-bottom:10px;">
		<table width="100%">
			<tr>
				<td valign="top" width="60%">
					<a href="<?=$detailsURL?>" title="<?=$customer?> - <?=$store?>">
						<?=$customer?>
					</a>
					<br />
    				<small class="coupaddress" style="color:gray">
						<?=$address?>
					</small>
					<br />
    				<?=$thumbnailInfo->testimonial?>
				</td>
				<td width="6%"></td>
				<td width="33%" valign="top">
					<a href="<?=$detailsURL?>" title="<?=$customer?>" class="screenshot" rel="<?=$thumbnailURL?>">
						<img src="<?=$imageURL?>" alt="<?=$customer?>" class="img-responsive" align="right">            
					</a>
				</td>
			</tr>
		</table>
    </div>
<?php
}






/**
* 2016-03-18 INFO: AHH
* Shows typical search controls
*/
function showSearchControls() {
	?>
                <form action="#" method="post">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 reset-2">
                            <div class="row reset-2">
                                <div class="form-group reset-2 col-xs-12">
                                    <label class="sr-only" for="filter_search">Enter your keywords</label>
                                    <input class="form-control input-sm" type="text" name="filter_search" placeholder="Enter your keywords" id="filter_search" value="<?=getKeyValue($_REQUEST,'filter_search','');?>" title="Keywords">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row reset-2">
                        <div class="col-xs-12 col-md-6 reset-2">
                            <div class="row reset-2">
                                <div class="form-group reset-2 col-xs-12 col-sm-5">
                                    <label class="sr-only" for="filter_business_city">City</label>
                                    <input class="form-control input-sm" type="text" name="filter_business_city" id="filter_business_city" placeholder="City" value="<?=getKeyValue($_REQUEST,'filter_business_city','')?>" title="City" autocomplete="off" style="cursor: auto; background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; background-repeat: no-repeat;">
                                </div>
                                <div class="form-group reset-2 col-xs-12 col-sm-2">
                                    <label class="sr-only" for="filter_business_state">State</label>
                                    <input class="form-control input-sm" type="text" name="filter_business_state" id="filter_business_state" placeholder="State" value="<?=getKeyValue($_REQUEST,'filter_business_state','')?>" title="State">
                                </div>
                                <div class="form-group reset-2 col-xs-12 col-sm-2">
                                    <label class="sr-only" for="zipsearch">Zip/Postal Code</label>
                                    <input class="form-control input-sm" name="zipsearch" type="text" id="zipsearch" placeholder="Zip/Postal Code" value="<?=getKeyValue($_REQUEST,'zipsearch','')?>" size="7" maxlength="7">
                                </div>
                                <div class="form-group reset-2 col-xs-12 col-sm-3">
                                    <label class="sr-only" for="distance">Distance</label>
                                    <select id="distance" name="distance" class="form-control input-sm" size="1" style="display: block;">
                                        <option value="0" <?php if($_REQUEST['distance'] == "0") { echo "selected=\"selected\""; } ?>>Distance</option>
                                        <option value="1" <?php if($_REQUEST['distance'] == "1") { echo "selected=\"selected\""; } ?>>1 mile</option>
                                        <option value="2" <?php if($_REQUEST['distance'] == "2") { echo "selected=\"selected\""; } ?>>2 miles</option>
                                        <option value="5" <?php if($_REQUEST['distance'] == "5") { echo "selected=\"selected\""; } ?>>5 miles</option>
                                        <option value="10" <?php if($_REQUEST['distance'] == "10") { echo "selected=\"selected\""; } ?>>10 miles</option>
                                        <option value="15" <?php if($_REQUEST['distance'] == "15") { echo "selected=\"selected\""; } ?>>15 miles</option>
                                        <option value="25" <?php if($_REQUEST['distance'] == "25") { echo "selected=\"selected\""; } ?>>25 miles</option>
                                        <option value="50" <?php if($_REQUEST['distance'] == "50") { echo "selected=\"selected\""; } ?>>50 miles</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 reset-2">
                            <div class="row reset-2">
                                <div class="form-group reset-2 col-xs-12 col-sm-4">
                                    <label class="sr-only" for="filter_business_country">Country</label>
                                    <select id="filter_business_country" name="filter_business_country" class="form-control input-sm">
                                        <option value="" <?php if($_REQUEST['filter_business_country'] == "") { echo "selected=\"selected\""; } ?>>All</option>
                                        <option value="US" <?php if($_REQUEST['filter_business_country'] == "US") { echo "selected=\"selected\""; } ?>>US</option>
                                        <option value="Canada" <?php if($_REQUEST['filter_business_country'] == "Canada") { echo "selected=\"selected\""; } ?>>Canada</option>
                                    </select>
                                </div>
                                <div class="form-group reset-2 col-xs-12 col-sm-5">
                                    <label class="sr-only" for="filter_category_id">Category</label>
                                    <select name="filter_category_id" id="filter_category_id" class="form-control input-sm" onchange="formsubmit();">
                                        <option value="">- Select Category -</option>
                                        <option value="8" <?php if($_REQUEST['filter_category_id'] == "8") { echo "selected=\"selected\""; } ?>>Auto</option>
                                        <option value="17" <?php if($_REQUEST['filter_category_id'] == "17") { echo "selected=\"selected\""; } ?>>- Maintenance/Oil Change</option>
                                        <option value="18" <?php if($_REQUEST['filter_category_id'] == "18") { echo "selected=\"selected\""; } ?>>- Repair</option>
                                        <option value="19" <?php if($_REQUEST['filter_category_id'] == "19") { echo "selected=\"selected\""; } ?>>- Car Wash</option>
                                        <option value="20" <?php if($_REQUEST['filter_category_id'] == "20") { echo "selected=\"selected\""; } ?>>- Body Shop</option>
                                        <option value="21" <?php if($_REQUEST['filter_category_id'] == "21") { echo "selected=\"selected\""; } ?>>- Parts/Accessories</option>
                                        <option value="22" <?php if($_REQUEST['filter_category_id'] == "22") { echo "selected=\"selected\""; } ?>>- Dealerships</option>
                                        <option value="9" <?php if($_REQUEST['filter_category_id'] == "23") { echo "selected=\"selected\""; } ?>>Beauty</option>
                                        <option value="26" <?php if($_REQUEST['filter_category_id'] == "24") { echo "selected=\"selected\""; } ?>>- Hair</option>
                                        <option value="27" <?php if($_REQUEST['filter_category_id'] == "25") { echo "selected=\"selected\""; } ?>>- Nail</option>
                                        <option value="28" <?php if($_REQUEST['filter_category_id'] == "26") { echo "selected=\"selected\""; } ?>>- Tanning</option>
                                        <option value="29" <?php if($_REQUEST['filter_category_id'] == "27") { echo "selected=\"selected\""; } ?>>- Massage</option>
                                        <option value="30" <?php if($_REQUEST['filter_category_id'] == "28") { echo "selected=\"selected\""; } ?>>- General</option>
                                        <option value="10" <?php if($_REQUEST['filter_category_id'] == "10") { echo "selected=\"selected\""; } ?>>Entertainment</option>
                                        <option value="31" <?php if($_REQUEST['filter_category_id'] == "31") { echo "selected=\"selected\""; } ?>>- Music</option>
                                        <option value="32" <?php if($_REQUEST['filter_category_id'] == "32") { echo "selected=\"selected\""; } ?>>- Movies</option>
                                        <option value="33" <?php if($_REQUEST['filter_category_id'] == "33") { echo "selected=\"selected\""; } ?>>- Activities</option>
                                        <option value="34" <?php if($_REQUEST['filter_category_id'] == "34") { echo "selected=\"selected\""; } ?>>- Travel</option>
                                        <option value="35" <?php if($_REQUEST['filter_category_id'] == "35") { echo "selected=\"selected\""; } ?>>- Bowling</option>
                                        <option value="36" <?php if($_REQUEST['filter_category_id'] == "36") { echo "selected=\"selected\""; } ?>>- Bingo</option>
                                        <option value="37" <?php if($_REQUEST['filter_category_id'] == "37") { echo "selected=\"selected\""; } ?>>- Putt Putt</option>
                                        <option value="38" <?php if($_REQUEST['filter_category_id'] == "38") { echo "selected=\"selected\""; } ?>>- Games</option>
                                        <option value="39" <?php if($_REQUEST['filter_category_id'] == "39") { echo "selected=\"selected\""; } ?>>- Skating Rink</option>
                                        <option value="11" <?php if($_REQUEST['filter_category_id'] == "11") { echo "selected=\"selected\""; } ?>>General</option>
                                        <option value="40" <?php if($_REQUEST['filter_category_id'] == "40") { echo "selected=\"selected\""; } ?>>- Communication</option>
                                        <option value="41" <?php if($_REQUEST['filter_category_id'] == "41") { echo "selected=\"selected\""; } ?>>- Maid Services</option>
                                        <option value="42" <?php if($_REQUEST['filter_category_id'] == "42") { echo "selected=\"selected\""; } ?>>- Child Care</option>
                                        <option value="43" <?php if($_REQUEST['filter_category_id'] == "43") { echo "selected=\"selected\""; } ?>>- Education</option>
                                        <option value="12" <?php if($_REQUEST['filter_category_id'] == "12") { echo "selected=\"selected\""; } ?>>Health</option>
                                        <option value="44" <?php if($_REQUEST['filter_category_id'] == "44") { echo "selected=\"selected\""; } ?>>- Fitness</option>
                                        <option value="45" <?php if($_REQUEST['filter_category_id'] == "45") { echo "selected=\"selected\""; } ?>>- Nutrition</option>
                                        <option value="46" <?php if($_REQUEST['filter_category_id'] == "46") { echo "selected=\"selected\""; } ?>>- Medicine</option>
                                        <option value="47" <?php if($_REQUEST['filter_category_id'] == "47") { echo "selected=\"selected\""; } ?>>- Weight Loss</option>
                                        <option value="48" <?php if($_REQUEST['filter_category_id'] == "48") { echo "selected=\"selected\""; } ?>>- Martial Arts</option>
                                        <option value="49" <?php if($_REQUEST['filter_category_id'] == "49") { echo "selected=\"selected\""; } ?>>- Doctor/Dentist</option>
                                        <option value="50" <?php if($_REQUEST['filter_category_id'] == "50") { echo "selected=\"selected\""; } ?>>- Lipo/Botox</option>
                                        <option value="13" <?php if($_REQUEST['filter_category_id'] == "13") { echo "selected=\"selected\""; } ?>>Home</option>
                                        <option value="51" <?php if($_REQUEST['filter_category_id'] == "51") { echo "selected=\"selected\""; } ?>>- Maintenance</option>
                                        <option value="52" <?php if($_REQUEST['filter_category_id'] == "52") { echo "selected=\"selected\""; } ?>>- Repair</option>
                                        <option value="53" <?php if($_REQUEST['filter_category_id'] == "53") { echo "selected=\"selected\""; } ?>>- Lawn/Garden</option>
                                        <option value="54" <?php if($_REQUEST['filter_category_id'] == "54") { echo "selected=\"selected\""; } ?>>- General</option>
                                        <option value="14" <?php if($_REQUEST['filter_category_id'] == "14") { echo "selected=\"selected\""; } ?>>Professional</option>
                                        <option value="55" <?php if($_REQUEST['filter_category_id'] == "55") { echo "selected=\"selected\""; } ?>>- Financial</option>
                                        <option value="56" <?php if($_REQUEST['filter_category_id'] == "56") { echo "selected=\"selected\""; } ?>>- Veterinarian</option>
                                        <option value="57" <?php if($_REQUEST['filter_category_id'] == "57") { echo "selected=\"selected\""; } ?>>- Mortgage</option>
                                        <option value="58" <?php if($_REQUEST['filter_category_id'] == "58") { echo "selected=\"selected\""; } ?>>- Chiropractor</option>
                                        <option value="59" <?php if($_REQUEST['filter_category_id'] == "59") { echo "selected=\"selected\""; } ?>>- Realtor</option>
                                        <option value="60" <?php if($_REQUEST['filter_category_id'] == "60") { echo "selected=\"selected\""; } ?>>- General</option>
                                        <option value="61" <?php if($_REQUEST['filter_category_id'] == "61") { echo "selected=\"selected\""; } ?>>- Legal</option>
                                        <option value="62" <?php if($_REQUEST['filter_category_id'] == "62") { echo "selected=\"selected\""; } ?>>- Insurance</option>
                                        <option value="15" <?php if($_REQUEST['filter_category_id'] == "15") { echo "selected=\"selected\""; } ?>>Restaurants</option>
                                        <option value="63" <?php if($_REQUEST['filter_category_id'] == "63") { echo "selected=\"selected\""; } ?>>- Fine Dining</option>
                                        <option value="64" <?php if($_REQUEST['filter_category_id'] == "64") { echo "selected=\"selected\""; } ?>>- Pizza</option>
                                        <option value="65" <?php if($_REQUEST['filter_category_id'] == "65") { echo "selected=\"selected\""; } ?>>- Sandwiches</option>
                                        <option value="66" <?php if($_REQUEST['filter_category_id'] == "66") { echo "selected=\"selected\""; } ?>>- Cultural</option>
                                        <option value="67" <?php if($_REQUEST['filter_category_id'] == "67") { echo "selected=\"selected\""; } ?>>- American</option>
                                        <option value="68" <?php if($_REQUEST['filter_category_id'] == "68") { echo "selected=\"selected\""; } ?>>- Chicken</option>
                                        <option value="69" <?php if($_REQUEST['filter_category_id'] == "69") { echo "selected=\"selected\""; } ?>>- Fast Food</option>
                                        <option value="70" <?php if($_REQUEST['filter_category_id'] == "70") { echo "selected=\"selected\""; } ?>>- Ice Cream/Coffee</option>
                                        <option value="16" <?php if($_REQUEST['filter_category_id'] == "16") { echo "selected=\"selected\""; } ?>>Shops</option>
                                        <option value="71" <?php if($_REQUEST['filter_category_id'] == "71") { echo "selected=\"selected\""; } ?>>- Dry Cleaners</option>
                                        <option value="72" <?php if($_REQUEST['filter_category_id'] == "72") { echo "selected=\"selected\""; } ?>>- Liquor</option>
                                        <option value="73" <?php if($_REQUEST['filter_category_id'] == "73") { echo "selected=\"selected\""; } ?>>- Video</option>
                                        <option value="74" <?php if($_REQUEST['filter_category_id'] == "74") { echo "selected=\"selected\""; } ?>>- Check Cashing</option>
                                        <option value="75" <?php if($_REQUEST['filter_category_id'] == "75") { echo "selected=\"selected\""; } ?>>- Jewelry</option>
                                        <option value="76" <?php if($_REQUEST['filter_category_id'] == "76") { echo "selected=\"selected\""; } ?>>- General</option>
                                        <option value="77" <?php if($_REQUEST['filter_category_id'] == "77") { echo "selected=\"selected\""; } ?>>- Clothing</option>
                                        <option value="78" <?php if($_REQUEST['filter_category_id'] == "78") { echo "selected=\"selected\""; } ?>>- Pets</option>
                                    </select>
                                </div>
                                <div class="form-group reset-2 col-xs-12 col-sm-3">
                                    <button id="searchbutton" type="submit" class="btn btn-sm btn-inverse btn-block pull-right">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row reset-2">
                        <div class="form-group col-xs-9 col-sm-10 col-md-11 reset-2 text-right text-strong">
                        </div>
                        <div class="form-group col-xs-3 col-sm-2 col-md-1 reset-2">
                            <button type="button" class="btn btn-sm btn-default pull-right" onclick="$('#filter_search').val('');$('#zipsearch').val('');$('#filter_business_city').val('');$('#filter_business_state').val('');$('#filter_category_id').selectedIndex=0;$('#filter_business_country').val('');this.form.submit();">
                        Clear
                            </button>
                        </div>
                    </div>
                </form>
	<?php
}


function getPropertyValue($object, $property, $default='') {
	return property_exists($object,$property) 
				? $object->$property
				: $default;
}



function getKeyValue($array, $key,$default=null) {
	return array_key_exists($key,$array) 
				? $array[$key] 
				: $default;
}


/**
* 2016-03-18 INFO: AHH
* Multiple pieces of functionality follow the content browser pattern, that
* is a pattern in which smaller versions of content are shown in a grid layout
* with filter controls at the top.  This was originally a coupons page, and it's
* been refactored and generalized, so there may still be coupon specific functionality
* while this is going on.
*/
function showContentBrowser($options) { 
	$title = $options['title'];
	$url = $options['summary'];
	?>
	<!DOCTYPE html>
	<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Local and direct response advertising for businesses. </title>
        <meta name="description" content="Local and direct response advertising for businesses who need exposure at a local level. Call us today for free information.  1-800-247-4793" />
        <meta name="keywords" content="local advertising,direct response advertising" />
        <?php include_once("resources/templates/includes.php"); ?>
        <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
        
        <script type="text/javascript">
            $(function () {
                $container = $('<div/>').attr('id', 'imgPreviewWithStyles').append('<img/>').hide().css('position', 'absolute').appendTo('body'),
                $img = $('img', $container),
                $('.screenshot').mousemove(function (e) {
                    $container.css({
                        top: e.pageY + 10 + 'px',
                        left: e.pageX - 50 + 'px'
                    });
                }).hover(function () {
                    var link = this;
                    $container.show();
                    $img.load(function () {
                        $img.addClass('img-rounded');
                        $img.show();
                    }).attr('src', $(link).attr('rel')).attr('style', 'max-width:400px');
                }, function () {
                    $container.hide();
                    $img.unbind('load').attr('src', '').hide();
                });

                $('#zipsearch').blur(function (e) {
                    if ($('#zipsearch').val() != '') {
                        $('#distance').show();
                        $('#distance').focus();
                    }
                    else {
                        $('#distance').hide();
                    }
                });

                $('#zipsearch').keyup(function (e) {
                    if ($('#zipsearch').val() != '') {
                        $('#distance').show();
                    }
                    else {
                        $('#distance').hide();
                    }
                });

                if ($('#zipsearch').val() == '' && ($('#filter_search').val() == '' && $('#filter_business_city').val() == '' && $('#filter_business_state').val() == '' && $('#filter_category_id').val() == '')) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(detectionSuccess);
                    }
                }

                function detectionSuccess(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    codeLatLng(lat, lng)
                }

                function codeLatLng(lat, lng) {
                    var geocoder = new google.maps.Geocoder();
                    var latlng = new google.maps.LatLng(lat, lng);
                    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[1]) {
                                //console.log(results[0].formatted_address)
                                var searchAddressComponents = results[0].address_components;
                                $.each(searchAddressComponents, function () {
                                    //console.log(this.types[0] + ' - ' + this.short_name);
                                    if (this.types[0] == "postal_code") { searchPostalCode = this.short_name; $('#zipsearch').val(searchPostalCode); }
                                    if (this.types[0] == "locality") { locality = this.short_name; $('#filter_business_city').val(locality); }
                                    if (this.types[0] == "administrative_area_level_1") { state = this.short_name; $('#filter_business_state').val(state); }
                                    if (this.types[0] == "country") { country = this.short_name; $('#filter_business_country').val(country); }
                                    $('#distance').show();
                                    $('#distance').val(5);
                                    //$('#searchbutton').click();
                                });

                                //$('#address').val(results[0].formatted_address);
                            } else {
                                console.log("No results found");
                            }
                        } else {
                            console.log("Geocoder failed due to: " + status);
                        }
                    });
                }

            });
        </script>

    </head>
    <body>
        <div class="header">
            <div class="container">
                <?php
					if ( !array_key_exists('hideSearch',$options) || !$options['hideSearch'] ) {
						showSearchControls();
					}

                    if ( getKeyValue($_REQUEST,'distance') )
                       $url .= 'dst='.$_REQUEST['distance'].'&';

                    if ( getKeyValue($_REQUEST,'zipsearch') )
                        $url .= 'zip='.$_REQUEST['zipsearch'].'&';
                    
                    if ( getKeyValue($_REQUEST,'filter_search') )
                        $url .= 'search='.$_REQUEST['filter_search'].'&';
                    
                    if ( getKeyValue($_REQUEST,'filter_category_id') )
                        $url .= 'ctg='.$_REQUEST['filter_category_id'].'&';
                    
                    if ( getKeyValue($_REQUEST,'filter_business_state') )
                        $url .= 'filter_business_state='.$_REQUEST['filter_business_state'].'&';

                    if ( getKeyValue($_REQUEST,'filter_business_country') )
                        $url .= 'country='.$_REQUEST['filter_business_country'].'&';
                    
                    if ( getKeyValue($_REQUEST,'filter_business_city') )
                        $url .= 'filter_business_city='.$_REQUEST['filter_business_city'].'&';
                    
                    //echo "<h3>$url</h3>";
                    
					$data = getCurlJSON($url);
                ?>
                <div id="home" class="row reset-15 tab-pane fade in active">
                    <?php
						$previewBase = getKeyValue($options, 'previewBase');
						$imageBase = getKeyValue($options, 'imageBase');
						if ( !is_object($data) || !$data->error ) {
							?>
			                <div class="row">
						        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<h3><?=$title?> RESULTS (<?=count($data)?>)</h3>
								</div>
							</div>
							<?php
	                        foreach ($data as $value) {
								if ( property_exists($value,'testimonial') ) {
									showTestimonialStyleContentThumbnail(
										$options['getShortcut']($value), 
										$previewBase,
										$imageBase,
										$value
									);
								}
								else {
									showCouponStyleContentThumbnail(
										$options['getShortcut']($value), 
										$previewBase,
										$imageBase,
										$value
									);
								}
							}
						}
						else {
							printf('<div style="color:red;text-align:center;"><h1>ERROR: %s</h1></div>',
										$data->error->message ? 
											ucwords($data->error->message) : 
											'An unknown error occurred'
							);
						}
                    ?>
                </div>
            </div>
        </div>
        <?php include_once("resources/templates/footer.php"); ?>
    </body>
	</html>
<?php } ?>



