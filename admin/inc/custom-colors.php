<?php
function team_plugin_custom_colors() {

// $buttons_color = get_theme_mod('team_plugin_buttons_color', '#333');
// $buttons_hover_color = get_theme_mod('team_plugin_buttons_hover_color', '#555');
// $buttons_text_color = get_theme_mod('team_plugin_buttons_text_color', '#fff');
// $buttons_hover_text_color = get_theme_mod('team_plugin_buttons_hover_text_color', '#fff');
// $links_color = get_theme_mod('team_plugin_links_color','#278dec');
// $links_hover_color = get_theme_mod('team_plugin_links_hover_color','#59afff');
$custom_css = get_theme_mod('team_plugin_custom_css');



 ?>
<style type="text/css">

/*#team-plugin-section .team-plugin-members-wrapper a button {
	background: <?php echo esc_html($buttons_color); ?> !important;
  color: <?php echo esc_html($buttons_text_color);  ?> !important;
}

#team-plugin-section .team-plugin-members-wrapper a button:hover {
	background: <?php echo esc_html($buttons_hover_color); ?> !important;
  color: <?php echo esc_html($buttons_hover_text_color); ?> !important;
}

#team-plugin-section .team-plugin-members-wrapper a {
	color: <?php echo esc_html($links_color); ?>;
}

#team-plugin-section .team-plugin-members-wrapper a:hover {
	color: <?php echo esc_html($links_hover_color); ?>;
}*/

<?php echo wp_filter_nohtml_kses($custom_css); ?>


</style>


<?php }
add_action('wp_head', 'team_plugin_custom_colors');
?>
