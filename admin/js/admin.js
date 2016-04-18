jQuery(document).ready(function(){

	jQuery('.general_options_tab').click(function(){
		jQuery('.meta_social_screen').hide();
		jQuery('.social_icons_tab').removeClass('active');
		jQuery('.meta_general_screen').fadeIn(100);
		jQuery('.general_options_tab').addClass('active');
	});

	jQuery('.social_icons_tab').click(function(){
		jQuery('.meta_general_screen').hide();
		jQuery('.general_options_tab').removeClass('active');
		jQuery('.meta_social_screen').fadeIn(100);
		jQuery('.social_icons_tab').addClass('active');
	});

});
