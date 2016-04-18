<?php
function teammates_custom_colors() {

// $buttons_color = get_theme_mod('teammates_buttons_color', '#333');
// $buttons_hover_color = get_theme_mod('teammates_buttons_hover_color', '#555');
// $buttons_text_color = get_theme_mod('teammates_buttons_text_color', '#fff');
// $buttons_hover_text_color = get_theme_mod('teammates_buttons_hover_text_color', '#fff');
// $links_color = get_theme_mod('teammates_links_color','#278dec');
// $links_hover_color = get_theme_mod('teammates_links_hover_color','#59afff');
$custom_css = get_theme_mod('teammates_custom_css');



 ?>
<style type="text/css">

/*#teammates-section .teammates-members-wrapper a button {
	background: <?php echo esc_html($buttons_color); ?> !important;
  color: <?php echo esc_html($buttons_text_color);  ?> !important;
}

#teammates-section .teammates-members-wrapper a button:hover {
	background: <?php echo esc_html($buttons_hover_color); ?> !important;
  color: <?php echo esc_html($buttons_hover_text_color); ?> !important;
}

#teammates-section .teammates-members-wrapper a {
	color: <?php echo esc_html($links_color); ?>;
}

#teammates-section .teammates-members-wrapper a:hover {
	color: <?php echo esc_html($links_hover_color); ?>;
}*/

<?php echo wp_filter_nohtml_kses($custom_css); ?>


</style>


<?php }
add_action('wp_head', 'teammates_custom_colors');
?>
