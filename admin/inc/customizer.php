<?php

function team_plugin_customizer( $wp_customize ) {


  $wp_customize->add_panel( 'team_plugin_panel', array(
    'priority'       => 9999,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => 'Team Plugin Options',
    'description'    => 'Options for the Team Plugin',
  ));

  $wp_customize->add_section( 'team_plugin_general_options_section' , array(
    'title'       => __( 'General Options', 'team-plugin' ),
    'priority'    => 1,
    'panel'       => 'team_plugin_panel',
  ));


  //  =============================
  //  = Profile Button Text       =
  //  =============================
  $wp_customize->add_setting( 'team_plugin_profile_button',array(
    'default'        => esc_html__('View Profile', 'team-plugin'),
    'capability'     => 'edit_theme_options',
    'transport'      => 'postMessage',
  ));

  $wp_customize->add_control( 'team_plugin_profile_button', array(
    'label'      => esc_html__('&#34;View Profile&#34; Button Text', 'team-plugin'),
    'section'    => 'team_plugin_general_options_section',
  ));


  //  =============================
  //  = Team members number       =
  //  =============================
  $wp_customize->add_setting( 'team_plugin_members_number',array(
    'default'        => '4',
    'capability'     => 'edit_theme_options',
  ));

  $wp_customize->add_control( 'team_plugin_members_number', array(
    'label'      => esc_html__('Number of Members', 'team-plugin'),
    'description'=> esc_html__('A maximum of 10 members is allowed.', 'team-plugin'),
    'section'    => 'team_plugin_general_options_section',
    'type'       => 'number',
    'input_attrs'=> array(
        'min'   => 1,
        'max'   => 10,
        'step'  => 1,
        'class' => 'team-plugin-members-number',
    ),
  ));


  $wp_customize->add_section( 'team_plugin_colors_section' , array(
    'title'       => __( 'Color Options', 'team-plugin' ),
    'priority'    => 2,
    'panel'       => 'team_plugin_panel',
  ));


  //  =============================
  //  = Buttons Color             =
  //  =============================
  $wp_customize->add_setting('team_plugin_buttons_color', array(
				'default'           => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
				// 'transport'					=> 'postMessage',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'team_plugin_buttons_color', array(
			'label'      => __( 'Buttons color', 'team-plugin' ),
			'section'    => 'team_plugin_colors_section',
	)));


  //  =============================
  //  = Buttons Hover Color       =
  //  =============================
  $wp_customize->add_setting('team_plugin_buttons_hover_color', array(
				'default'           => '#555',
				'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'team_plugin_buttons_hover_color', array(
			'label'      => __( 'Buttons hover color', 'team-plugin' ),
			'section'    => 'team_plugin_colors_section',
	)));


  //  =============================
  //  = Buttons Text Color        =
  //  =============================
  $wp_customize->add_setting('team_plugin_buttons_text_color', array(
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
				// 'transport'					=> 'postMessage',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'team_plugin_buttons_text_color', array(
			'label'      => __( 'Buttons text color', 'team-plugin' ),
			'section'    => 'team_plugin_colors_section',
	)));


  //  =============================
  //  = Buttons Hover Text Color  =
  //  =============================
  $wp_customize->add_setting('team_plugin_buttons_hover_text_color', array(
				'default'           => '#fff',
				'sanitize_callback' => 'sanitize_hex_color',
				// 'transport'					=> 'postMessage',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'team_plugin_buttons_hover_text_color', array(
			'label'      => __( 'Buttons hover text color', 'team-plugin' ),
			'section'    => 'team_plugin_colors_section',
	)));


  //  =============================
  //  = Links Color               =
  //  =============================
  $wp_customize->add_setting('team_plugin_links_color', array(
				'default'           => '#278dec',
				'sanitize_callback' => 'sanitize_hex_color',
				// 'transport'					=> 'postMessage',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'team_plugin_links_color', array(
			'label'      => __( 'Links color', 'team-plugin' ),
			'section'    => 'team_plugin_colors_section',
	)));


  //  =============================
  //  = Links Hover Color         =
  //  =============================
  $wp_customize->add_setting('team_plugin_links_hover_color', array(
				'default'           => '#59afff',
				'sanitize_callback' => 'sanitize_hex_color',
				// 'transport'					=> 'postMessage',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'team_plugin_links_hover_color', array(
			'label'      => __( 'Links hover color', 'team-plugin' ),
			'section'    => 'team_plugin_colors_section',
	)));

  //  =============================
  //  = CUSTOM CSS SECTION        =
  //  =============================
  $wp_customize->add_section( 'team_plugin_custom_css_section' , array(
    'title'       => __( 'Custom CSS', 'team-plugin' ),
    'priority'    => 3,
    'panel'       => 'team_plugin_panel',
  ));

  $wp_customize->add_setting('team_plugin_custom_css', array(
      'capability'     => 'edit_theme_options',
	));
	$wp_customize->add_control('team_plugin_custom_css', array(
      'type'       => 'textarea',
			'label'      => __( 'CSS Code', 'team-plugin' ),
      'description'=> __( 'Add your own CSS code here' ),
      'section'    => 'team_plugin_custom_css_section',
  ));



}
add_action( 'customize_register', 'team_plugin_customizer', 30 );

?>
