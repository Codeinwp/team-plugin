( function( $ ) {

	wp.customize( 'team_plugin_section_heading', function( value ) {
		value.bind( function( to ) {
			$( '#team-plugin-section .team-plugin-section-title > h2' ).text( to );
		} );
	} );

	wp.customize( 'team_plugin_profile_button', function( value ) {
		value.bind( function( to ) {
			$( '#team-plugin-section .team-plugin-members-wrapper a button' ).text( to );
		} );
	} );

} )( jQuery );
