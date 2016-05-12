<?php

function teammates_customizer( $wp_customize ) {


  $wp_customize->add_panel( 'teammates_panel', array(
    'priority'       => 9999,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => 'Teammates Options',
    'description'    => 'Options for the Teammates Plugin',
  ));

  $wp_customize->add_section( 'teammates_general_options_section' , array(
    'title'       => __( 'General Options', 'teammates' ),
    'priority'    => 1,
    'panel'       => 'teammates_panel',
  ));


  //  =============================
  //  = Profile Button Text       =
  //  =============================
  $wp_customize->add_setting( 'teammates_profile_button',array(
    'default'        => esc_html__('View Profile', 'teammates'),
    'capability'     => 'edit_theme_options',
    'transport'      => 'postMessage',
  ));

  $wp_customize->add_control( 'teammates_profile_button', array(
    'label'      => esc_html__('&#34;View Profile&#34; Button Text', 'teammates'),
    'section'    => 'teammates_general_options_section',
  ));


  //  =============================
  //  = Team members number       =
  //  =============================
  $wp_customize->add_setting( 'teammates_members_number',array(
    'default'        => '4',
    'capability'     => 'edit_theme_options',
  ));

  $wp_customize->add_control( 'teammates_members_number', array(
    'label'      => esc_html__('Number of Members', 'teammates'),
    'description'=> esc_html__('A maximum of 10 members is allowed.', 'teammates'),
    'section'    => 'teammates_general_options_section',
    'type'       => 'number',
    'input_attrs'=> array(
        'min'   => 1,
        'max'   => 10,
        'step'  => 1,
        'class' => 'teammates-members-number',
    ),
  ));


  //  =============================
  //  = CUSTOM CSS SECTION        =
  //  =============================
  $wp_customize->add_section( 'teammates_custom_css_section' , array(
    'title'       => __( 'Custom CSS', 'teammates' ),
    'priority'    => 3,
    'panel'       => 'teammates_panel',
  ));

  $wp_customize->add_setting('teammates_custom_css', array(
      'capability'     => 'edit_theme_options',
	));
	$wp_customize->add_control('teammates_custom_css', array(
      'type'       => 'textarea',
			'label'      => __( 'CSS Code', 'teammates' ),
      'description'=> __( 'Add your own CSS code here' ),
      'section'    => 'teammates_custom_css_section',
  ));



}
add_action( 'customize_register', 'teammates_customizer', 30 );

?>
