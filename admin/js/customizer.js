( function( $ ) {

	wp.customize( 'teammates_section_heading', function( value ) {
		value.bind( function( to ) {
			$( '#teammates-section .teammates-section-title > h2' ).text( to );
		} );
	} );
	
	wp.customize( 'teammates_profile_button', function( value ) {
		value.bind( function( to ) {
			$( '#teammates-section .teammates-members-wrapper a.view-profile' ).text( to );
		} );
	} );

} )( jQuery );
