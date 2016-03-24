<?php
function team_plugin_custom_colors() {

$buttons_color = get_theme_mod('team_plugin_buttons_color', '#333');
$buttons_hover_color = get_theme_mod('team_plugin_buttons_color', '#555');
$buttons_text_color = get_theme_mod('team_plugin_buttons_text_color', '#fff');
$buttons_hover_text_color = get_theme_mod('team_plugin_buttons_hover_text_color', '#fff');
$links_color = get_theme_mod('team_plugin_links_color','#278dec');



 ?>
<style>




</style>


<?php }
add_action('wp_head', 'team_plugin_custom_colors');
?>
