<?php include_once('resources/library/misc.php') ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Local and direct response advertising for businesses. </title>
        <meta name="description" content="Local and direct response advertising for businesses who need exposure at a local level. Call us today for free information.  1-800-247-4793" />
        <meta name="keywords" content="local advertising,direct response advertising" />
		<?php include_once('resources/templates/styles-and-scripts.php'); ?>
	</head>
	<body>
<form action="getting-started.php" target="gettingStarted">
	<div class="startTodayForm">
		<?php
			if ( fieldIsSet('getStartedEmail')
				 && fieldIsSet('getStartedName') 
				 && fieldIsSet('getStartedZip') 
				 && fieldIsSet('getStartedProduct') && $_GET['getStartedProduct'] != 0 ) 
			{
				echo '<h4 class="text-center">';
				if ( processGetStartedForm($_GET) ) {
					echo 'Submission Complete<br />Thank You!';
				}
				else {
					echo 'We had a problem<br />with your request.<br />Please try again.';
				}
				echo '</h4>';
			}
			else {
				?>
				<h4 class="text-center">Get Started</h4>
				<?php 
					showFormInput('email', 'getStartedEmail', 'Email');
					showFormInput('text', 'getStartedName', 'Name');
					showFormInput('text', 'getStartedZip', 'Zip Code');
				?>
				<div class="form-group">
  					<select class="form-control center-block" name="getStartedProduct" id="getStartedProduct" <?=highlightFormFieldIfMissing('getStartedProduct')?>>
						<?php
							$productLabels = array(
								'Select a Product...',
								'Tape',
								'Cart',
								'Tape and Cart',
								'Custom Print'
							);
							foreach($productLabels as $productIndex=>$productLabel) {
								$selected = $productIndex == $_GET['getStartedProduct'] ? 'selected=\"selected\"' : '';
								echo "<option value=\"$productIndex\" $selected>$productLabel</option>";
							}
						?>
					</select>
    			</div>
				<input type="hidden" value="1" name="submitted" />
				<button class="btn btn-default pull-right" type="submit">Submit</button>
			<?php
			}
			?>
	</div>
</form>
</body>
</html>
