<?php save_progress(); ?>
<!DOCTYPE html>
<html>
<head>
<title><?php page_title(); ?></title>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" media="all" href="<?php echo $settings->site_url; ?>/<?php echo SCHOOL_DIR; ?>/themes/base.css" />
<link rel="stylesheet" media="all" href="<?php stylesheet(); ?>" />
<link rel="stylesheet" media="all" href="<?php echo $settings->site_url; ?>/<?php echo INCLUDES_DIR; ?>/cropper-master/css/cropper.min.css">
<link rel="stylesheet" media="all" href="<?php echo $settings->site_url; ?>/<?php echo INCLUDES_DIR; ?>/cropper-master/css/main.css">
<link rel="stylesheet" media="all" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $settings->site_url; ?>/ts-includes/js/cs.main.js"></script>
<script src="<?php echo $settings->site_url; ?>/ts-includes/js/cs.activity.js"></script>
<!-- dynamically loaded header data -->
<?php cs_head(); ?>
<?php
//https://github.com/Woopra/woopra-php-sdk
require_once(INCLUDES_PATH.'/libraries/woopra/woopra_tracker.php');
$woopra = new WoopraTracker(array("domain" => "cannabiz.certsoft.net"));
if(LOGGED_IN){
	$woopra->identify(array(
	   "name" => get_user_info($_SESSION['school']['user'],'username'),
	   "email" => get_user_info($_SESSION['school']['user'],'email'),
	   "company" => "User Business"
	));	
}

$woopra->track()->js_code();
?>
</head>
<body class="<?php body_class(array('mobile-view','body_page_'.$_GET['view'])); ?>" <?php body_tag(); ?>>
<!-- CS <?php echo get_file_version(); ?> -->
<?php if(LOGGED_IN): ?>
<?php
echo "<script>var cbuser = '{$_SESSION['school']['user']}';</script>";
//cannabiz_profile_alert(); 

//Track Mobile Logins
if(empty($_SESSION['school']['mobile'])){
	if(function_exists('cs_get_user_meta')){
		// We will first get the current count from meta data or set it to 0 if none exists
		$count = cs_get_user_meta($_SESSION['school']['user'],'mobile_login_counter');
		if(empty($count)) $count = 0;
		// increase count by 1 and update the metadata value
		cs_update_user_meta($_SESSION['school']['user'],'mobile_login_counter',++$count);
		// We only want to log this once per session so we will set a variable
		// The first time we log this to tell us we already logged mobile for this session		
	}
	$_SESSION['school']['mobile'] = true;
}

// Add Session Timer JS to the header
// Tracks inactivity time and logs out after preset amount of time
session_timer($settings->sessionMaxIdleTime,$settings->sessionAlertTime); 
//
?>
<?php endif; // End If LOGGED_IN ?>

<div id="container" <?php echo $page_class; ?>>

	<div id="mobile-header">
		<div class="container">
			<div class="half floatleft header_left_column">
				<ul class="menu">
				<li id="logo" class="logo <?php echo (empty($_SESSION['school']['mini-nav']))?'expanded':'collapsed'; ?>"><a href="<?php echo $settings->site_url; ?>/?view=module&path=cannabiz&action=mobile-dashboard"><span><?php 
				//if(empty($settings->logo)) page_title(); 
				//else{logo();} 
				(empty($settings->logo))? page_title() : logo();
				?></span></a></li>
				<?php if(LOGGED_IN): ?>
					<li>
						<input type="text" class="search_bar" />
					</li>
				<?php endif; ?>	
				</ul>
			</div>
			<div id="header_links" class="mobile-header-links">
			<?php if(LOGGED_IN): ?>
				<div id="account-menu" class="account-menu">
					<div id="account-menu-toggle">
						<i class="fa fa-bars"></i>
					</div>
					<ul class="account-options">
						<li><a href="<?php echo $settings->site_url; ?>/?view=module&path=cannabiz&action=mobile-dashboard">Dashboard</a></li>
						<li><a href="<?php echo $settings->site_url; ?>/?view=module&path=cannabiz&action=mobile-search&service=1">Search Vendors</a></li>
						<li><a href="<?php echo $settings->site_url; ?>/?view=module&path=cannabiz&action=mobile-search&service=2">Search Shops</a></li>
						<li style="display: none"><a href="<?php echo $settings->site_url; ?>/?view=module&path=cannabiz&action=mobile-messages">My Messages</a></li>
						<li><a href="<?php echo $settings->site_url; ?>/?view=module&path=cannabiz&action=mobile-network">Network Connections</a></li>
						<li style="display: none"><a href="<?php echo $settings->site_url; ?>/?view=profile">Personal Profile</a></li>
						<li style="display: none"><a href="<?php echo $settings->site_url; ?>/?view=profile-photo">Profile Photo</a></li>
						<li style="display: none"><a href="<?php echo $settings->site_url; ?>/?view=account">Account Settings</a></li>
						<li><a href="<?php echo $settings->site_url; ?>/?view=module&path=cannabiz&action=mobile-help">Help</a></li>
						<li><a href="<?php echo $settings->site_url; ?>/ts-logout.php">Logout</a></li>
					</ul>
				</div>
				<script>
					jQuery(document).ready(function($){
						// This script can be moved into the main.js once that is set up
						// And let's label it with the filenames it effects [header.php, mobile-header.php]
						$('#account-menu-toggle').click(function(){
							$( "#account-menu .account-options" ).toggleClass( "account-options-open" );
						});
						$('#mobile-content').click(function(){
							$( "#account-menu .account-options" ).removeClass( "account-options-open" )
						});
					});
				</script>
			<?php else:?>
				<?php if($_GET['view'] != 'login'): ?>
				<a class="header_login_button" href="<?php echo $settings->site_url; ?>/?view=login">Log In</a>
				<?php endif; ?>
			<?php endif; ?>				
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<!-- /header -->

	<div id="mobile-content">
			<div class="mobile-workspace">	
						