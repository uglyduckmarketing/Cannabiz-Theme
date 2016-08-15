

			</div>	
			<?php if(LOGGED_IN): ?>
			<div id="panel_right" class="transition">
				<div id="extra-content"><i class="fa fa-circle-o-notch spin"></i></div>
			</div>	
			<?php endif; ?>
		</div>
	</div>
	<!-- /content -->
	
	<div id="footer">
		<div class="container">
			<div class="padded_top10 padded_bottom10">
				<?php 
				$school_lic = get_schoolinfo('license');
				$course_lic = get_courseinfo('courseLicense',$_SESSION['school']['active_course']);
				$course_disclaimer = get_courseinfo('courseDisclaimer',$_SESSION['school']['active_course']);
				
				?>
				<a href="<?php schoolinfo('schoolURL'); ?>"><?php schoolinfo('schoolName'); ?></a>
				<?php if($course_disclaimer): ?>
				| <a href="./?view=module&path=school&action=course-disclaimer">Course Disclaimer</a> <?php //echo $course_disclaimer; ?>
				<?php endif; ?>
				<?php if($school_lic): ?>
				| Company License #<?php echo $school_lic; ?>
				<?php endif; ?>
				<?php if($course_lic): ?>
				| Course License #<?php echo $course_lic; ?>
				<?php endif; ?>
				| Powered by <a href="http://certsoft.net" target="blank">CertSoft</a> <?php echo get_file_version(); ?>
			</div>
		</div>
		<!-- /footer container -->
	</div>	
	<!-- /footer -->
</div>
<?php ts_footer(); ?>
<script>
jQuery(document).ready(function($){
		$('.btn_close_overlay').click(function(){
			$('#cs_overlay').fadeOut();
			return false;
		});
});	
</script>
<script>

rightbar = false;
	
function panel_height(){
	return $( window ).height()-$( '#footer' ).height() -$( '#header' ).height();
}	
	
jQuery(document).ready(function($){	
	// Panel Area Height
	$('#panel_left').css('min-height',panel_height() );
	//$('#logo').css('width', $('#panel_left').css('width'));
	//$('.workspace').css('min-height',$('#panel_left').height()+$( '#footer' ).height());
	
	$( window ).resize(function() {
		$('#panel_left').css('min-height',panel_height() );
		//$('#logo').css('width', $('#panel_left').css('width'));
	});
	
		
	$('#toggle-left').click(function(){
		if($('#panel_left').hasClass('expanded')){
			$('#panel_center').css('padding-left','82px');
			$('#panel_left').css('width','82px');
			$('#logo').css('width','82px');
			$('#logo').addClass('collapsed');
			$('#panel_left').addClass('collapsed');
			$('#panel_left').removeClass('expanded');
			$('#toggle-left i').addClass('cb-close');
			$('#toggle-left i').removeClass('fa-toggle-left');
			$.post( "<?php echo $settings->site_url.'/'.SCHOOL_FOLDER; ?>/ajax/ajax-actions.php", { action: "toggle-nav", pos: 1 } );
		}
		else{
			$('#panel_center').css('padding-left','240px');
			$('#panel_left').css('width','240px');
			$('#logo').css('width','240px');
			$('#logo').removeClass('collapsed');
			$('#panel_left').addClass('expanded');
			$('#panel_left').removeClass('collapsed');
			$('#toggle-left i').removeClass('fa-toggle-right');
			$('#toggle-left i').addClass('cb-close');
			$.post( "<?php echo $settings->site_url.'/'.SCHOOL_FOLDER; ?>/ajax/ajax-actions.php", { action: "toggle-nav", pos: 0 } );
		}
		return false;
	});
	$('#toggle-right').click(function(){
		if(rightbar){
			$('#panel_center').css('padding-right','0%');
			$('#panel_right').css('width','0%');
			$('#toggle-right i').removeClass('fa-chevron-right');
			$('#toggle-right i').addClass('fa-chevron-left');
			rightbar = false;
		}
		else{
			$('#panel_center').css('padding-right','25%');
			$('#panel_right').css('width','25%');
			$('#toggle-right i').removeClass('fa-chevron-left');
			$('#toggle-right i').addClass('fa-chevron-right');
			rightbar = true;
		}
		return false;
	});
});	
</script>
</body>
</html>