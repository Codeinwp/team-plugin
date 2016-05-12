<?php
function teammates_custom_colors() {

$custom_css = get_theme_mod('teammates_custom_css');



 ?>
<style type="text/css">

<?php echo wp_filter_nohtml_kses($custom_css); ?>

</style>


<?php }
add_action('wp_head', 'teammates_custom_colors');
?>
