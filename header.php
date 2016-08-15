<?php save_progress(); ?>
<!DOCTYPE html>
<html>
<head>
<title><?php page_title(); ?></title>

<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" media="all" href="<?php schoolinfo('schoolURL'); ?>/<?php echo SCHOOL_DIR; ?>/themes/base.css" />
<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" media="all" href="<?php stylesheet(); ?>" />
<link href="<?php schoolinfo('schoolURL'); ?>/<?php echo INCLUDES_DIR; ?>/cropper-master/css/cropper.min.css" rel="stylesheet">
<link href="<?php schoolinfo('schoolURL'); ?>/<?php echo INCLUDES_DIR; ?>/cropper-master/css/main.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php schoolinfo('schoolURL'); ?>/ts-includes/js/cs.main.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<?php
if(!empty($settings->additionalStyles)){
	echo '<style>'."\n";
	echo $settings->additionalStyles;
	echo "\n".'</style>'."\n";
}
if($settings->disableRightClick == 'true'):
?>
<script language=JavaScript>
    var message="Function Disabled!";
    function clickIE4(){
        if (event.button==2){ alert(message); return false; }
    }
    function clickNS4(e){
        if (document.layers||document.getElementById&&!document.all){
            if (e.which==2||e.which==3){
                alert(message);
                return false;
            }
        }
    }
    if (document.layers){
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown=clickNS4;
    } else if (document.all&&!document.getElementById){
        document.onmousedown=clickIE4;
    }
    document.oncontextmenu=new Function("alert(message); return false")
</script>
<style>
	.no-select {
    user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    -o-user-select: none;
}
</style>
<?php endif; ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
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
<body class="<?php body_class(array('body_page_'.$_GET['view'])); ?>" <?php body_tag(); ?>>
<?php //set_activity($_SESSION['school']['user']); ?>
<?php if(LOGGED_IN): ?>
<script>
activity_url = '<?php echo get_schoolinfo('schoolURL'); ?>/users/ts-school/ajax/activity.php';
</script>
<script src="<?php schoolinfo('schoolURL'); ?>/ts-includes/js/cs.activity.js"></script>

<script>
	if($( window ).width() <= 480 ){
		window.location = '<?php echo get_schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=mobile-dashboard';
	}
	var cbuser = '<?php echo $_SESSION['school']['user']; ?>';
</script>
<?php cannabiz_profile_alert(); ?>
<?php if( !cs_has_report($_SESSION['school']['user'],'onboarding') && !cannabiz_account_published()){
echo '<!-- onboarding -->';
if(!$_SESSION['school']['cannabiz']){
	$_SESSION['school']['cannabiz'] = true;
	include(MOD_PATH.'/cannabiz/onboarding.php');
}

echo '<!-- /onboarding -->';
}
else{
	echo '<!--',cs_has_report($_SESSION['school']['user'],'onboarding'),' -->';
	echo '<!--',cannabiz_account_published(),' -->';
}
//include(MOD_PATH.'/cannabiz/onboarding.php');
?>
<?php session_timer($settings->sessionMaxIdleTime,$settings->sessionAlertTime); ?>
<div id="cannabiz_mobile_splash" class="cannabiz_mobile_view">
	<div id="cannabiz_mobile_splash_content">
	<?php
	if(empty($settings->logo)) page_title();
	else{logo();}
	?>
	<p>Mobile Version Coming soon.</p>
	<p>Check out your account on your desktop computer or tablet device.</p>
	</div>
</div>
<?php else: ?>
	<scrip>var cbuser = '0';</scrip>
<?php endif; ?>



<!-- START HEADER -->

<div <?php echo $page_class; ?>>
	<div id="header">
		<div class="container">
			<div class="col-sm-4 floatleft cb-left-header-col">
				<ul class="cb-left-navigation">
					<li id="logo" class="logo <?php echo (empty($_SESSION['school']['mini-nav']))?'expanded':'collapsed'; ?>">
						<a href="<?php schoolinfo('schoolURL'); ?>">
							<span>
								<?php
								if(empty($settings->logo)) page_title();
								else{logo();} ?>
							</span>
						</a>
					</li>
					<?php if(LOGGED_IN): ?>
					<li class="dropdown temp-title">
						<a href="#"><i class="ion-search"></i><span class="menu-item-title">Find Services</span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=find-service&service=1">Search Vendors</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=find-service&service=2">Search Shops</a></li>
							<!--<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=search">Search</a></li>-->
						</ul>
					</li>
				<?php endif; ?>
				</ul>
			</div>
			<div class="col-sm-8 floatright alignright cb-right-header-col">
			<?php if(LOGGED_IN): ?>
				<ul class="cb-right-navigation">
					<?php if(cannabiz_is_seller()): ?>
					<li class="dropdown">
						<a href="#">Shop Information<i class="ion-gear-b"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=seller-profile">Edit Profile</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=seller-products">Manage Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>//?view=module&path=cannabiz&action=shop-details&id=<?php echo cannabiz_get_profile_id($_SESSION['school']['user'],2); ?>">View Shop Profile</a></li>
						</ul>
					</li>
					<?php endif; ?>
					<?php if(cannabiz_is_grower()): ?>
					<li class="dropdown temp-title">
						<a href="#"><span class="menu-item-title">Vendor Information</span><i class="ion-gear-b"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=vendor-profile">Edit Profile</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=manage-vendor-products">Manage Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=add-products">Add New Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=offered-products">Offered Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=grower-details&id=<?php echo cannabiz_get_profile_id($_SESSION['school']['user'],1); ?>">View Vendor Profile</a></li>
						</ul>
					</li>
					<?php endif; ?>
					<?php if(!cannabiz_is_seller() && !cannabiz_is_grower()): ?>
					<li class="dropdown">
						<a href="#">Shop Information<i class="ion-gear-b"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=seller-profile">Edit Profile</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=seller-products">Manage Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>//?view=module&path=cannabiz&action=shop-details&id=">View Shop Profile</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#">Vendor Information<i class="ion-gear-b"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=vendor-profile">Edit Profile</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=manage-vendor-products">Manage Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=add-products">Add New Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=offered-products">Offered Products</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=grower-details&id=">View Vendor Profile</a></li>
						</ul>
					</li>
					<?php endif; ?>
					<li class="temp-title">
						<a href="<?php echo get_schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=connections"><span class="menu-item-title">Connections</span><i class="ion-android-share-alt"></i></a>
					</li>
					<li class="temp-title">
						<a href="<?php echo get_schoolinfo('schoolURL'); ?>/?view=module&path=cannabiz&action=messages"><span class="menu-item-title">Messages</span><i class="ion-chatbubbles"></i><?php if(unread_messages($_SESSION['school']['user'])) echo '<i class="fa fa-circle" style="color: #00ff00; margin-left: -15px; font-size: 12px"></i>'; ?></a>
					</li>
					<li class="user-account dropdown">
						<?php echo get_profile_photo(); ?>
						<span class="user-name menu-item-title">
						<?php $greeting = get_option('user_greeting','first_name'); ?>
						<?php if($greeting == 'first_name'): ?>
						<?php echo get_user_data($_SESSION['school']['user'],'firstName'); ?>
						<?php else: ?>
						<?php echo $_SESSION['school']['user_name']; ?>
						<?php endif; ?>
						</span>
						<i class="ion-arrow-down-b"></i>
						<ul class="dropdown-menu">
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=profile">Personal Profile</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=profile-photo">Profile Photo</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/?view=account">Account Settings</a></li>
							<li><a href="<?php schoolinfo('schoolFrontendURL'); ?>/help/" target="_blank">Help</a></li>
							<li><a href="<?php schoolinfo('schoolURL'); ?>/ts-logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
				<?php else:?>
				<?php if($_GET['view'] != 'login'): ?>
				<a class="header_login_button" href="<?php schoolinfo('schoolURL'); ?>/?view=login">Log In</a>
				<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>


<!-- END HEADER -->

	<div id="page-contents">
		<div class="<?php echo (empty($_SESSION['school']['mini-nav']))?'collapsed':'expanded'; ?>">
			<?php run_callbacks('workspace_init'); ?>
			<?php if(!empty($sub_menu_slug)) get_sub_menu($sub_menu_slug); ?>
