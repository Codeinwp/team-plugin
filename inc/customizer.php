<?php

function team_plugin_customizer( $wp_customize ) {


  $wp_customize->add_panel( 'team_plugin_panel', array(
    'priority'       => 9999,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => 'Team Plugin Options',
    'description'    => 'Options for the Team Plugin',
  ));

  $wp_customize->add_section( 'team_plugin_section' , array(
    'title'       => __( 'General Options', 'team-plugin' ),
    'priority'    => 1,
    'panel'       => 'team_plugin_panel',
  ));


  //  =============================
  //  = Section Heading           =
  //  =============================
  $wp_customize->add_setting( 'team_plugin_section_heading',array(
    'default'        => esc_html__('Our team', 'team-plugin'),
    'capability'     => 'edit_theme_options',
  ));

  $wp_customize->add_control( 'team_plugin_section_heading', array(
    'label'      => esc_html__('Section Heading', 'team-plugin'),
    'section'    => 'team_plugin_section',
  ));


  //  =============================
  //  = Profile Button Text       =
  //  =============================
  $wp_customize->add_setting( 'team_plugin_profile_button',array(
    'default'        => esc_html__('View Profile', 'team-plugin'),
    'capability'     => 'edit_theme_options',
  ));

  $wp_customize->add_control( 'team_plugin_profile_button', array(
    'label'      => esc_html__('&#34;View Profile&#34; Button Text', 'team-plugin'),
    'section'    => 'team_plugin_section',
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
    'section'    => 'team_plugin_section',
    'type'       => 'number',
    'input_attrs'=> array(
        'min'   => 1,
        'max'   => 10,
        'step'  => 1,
        'class' => 'team-plugin-members-number',
    ),
  ));



}
add_action( 'customize_register', 'team_plugin_customizer', 30 );

?>
