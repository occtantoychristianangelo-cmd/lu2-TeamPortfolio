( function () {
	'use strict';

	var button = document.querySelector( '.nav-toggle' );
	var navigation = document.getElementById( 'primary-navigation' );
	var compactLayout = window.matchMedia( '(max-width: 640px)' );

	if ( ! button || ! navigation ) {
		return;
	}

	function setMenuState( isOpen ) {
		button.setAttribute( 'aria-expanded', String( isOpen ) );
		navigation.hidden = ! isOpen;
	}

	function syncLayout() {
		if ( compactLayout.matches ) {
			setMenuState( false );
		} else {
			navigation.hidden = false;
			button.setAttribute( 'aria-expanded', 'false' );
		}
	}

	button.addEventListener( 'click', function () {
		setMenuState( button.getAttribute( 'aria-expanded' ) !== 'true' );
	} );

	navigation.addEventListener( 'click', function ( event ) {
		if ( compactLayout.matches && event.target.closest( 'a' ) ) {
			setMenuState( false );
		}
	} );

	compactLayout.addEventListener( 'change', syncLayout );
	syncLayout();
} )();
