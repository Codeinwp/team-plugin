jQuery(document).ready(function(){

	jQuery('.general_options_tab').click(function(){
		jQuery('.meta_social_screen').hide();
		jQuery('.social_icons_tab').removeClass('active');
		jQuery('.meta_general_screen').show();
		jQuery('.general_options_tab').addClass('active');
	});

	jQuery('.social_icons_tab').click(function(){
		jQuery('.meta_general_screen').hide();
		jQuery('.general_options_tab').removeClass('active');
		jQuery('.meta_social_screen').show();
		jQuery('.social_icons_tab').addClass('active');
	});

});
