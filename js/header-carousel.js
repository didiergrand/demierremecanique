( function () {
	'use strict';

	var SWITCH_DELAY = 5000;
	var FADE_DELAY = 300;
	var DRAG_THRESHOLD = 50;

	function applyImage( container, url ) {
		var bg = container.querySelector( '.header-image-bg' );
		var img = container.querySelector( 'img' );

		if ( bg ) {
			bg.style.backgroundImage = 'url("' + url + '")';
		}

		if ( img ) {
			img.src = url;
		}
	}

	function updateDots( dots, activeIndex ) {
		dots.forEach( function ( dot, index ) {
			var isActive = index === activeIndex;
			dot.classList.toggle( 'is-active', isActive );
			dot.setAttribute( 'aria-selected', isActive ? 'true' : 'false' );
		} );
	}

	function createDots( container, images, onSelect ) {
		var nav = document.createElement( 'div' );
		nav.className = 'header-carousel-dots';
		nav.setAttribute( 'role', 'tablist' );
		nav.setAttribute( 'aria-label', 'Navigation carousel' );

		var dots = images.map( function ( _url, index ) {
			var dot = document.createElement( 'button' );
			dot.type = 'button';
			dot.className = 'header-carousel-dot';
			dot.setAttribute( 'role', 'tab' );
			dot.setAttribute( 'aria-label', 'Slide ' + ( index + 1 ) );
			dot.addEventListener( 'click', function () {
				onSelect( index );
			} );
			nav.appendChild( dot );
			return dot;
		} );

		container.appendChild( nav );
		return dots;
	}

	function startCarousel( container ) {
		var rawImages = container.getAttribute( 'data-carousel-images' );
		if ( ! rawImages ) {
			return;
		}

		var images = [];
		try {
			images = JSON.parse( rawImages );
		} catch ( error ) {
			return;
		}

		if ( ! Array.isArray( images ) || images.length < 2 ) {
			return;
		}

		var slides = [];
		var rawSlides = container.getAttribute( 'data-carousel-slides' );
		if ( rawSlides ) {
			try {
				slides = JSON.parse( rawSlides );
			} catch ( error ) {
				slides = [];
			}
		}

		var currentIndex = 0;
		var isPaused = false;
		var dots = [];

		function updateSlideText( nextIndex ) {
			if ( ! Array.isArray( slides ) || slides.length === 0 ) {
				return;
			}

			var slide = slides[ nextIndex ];
			if ( ! slide ) {
				return;
			}

			var titleLink = container.querySelector( '.header-carousel-title-link' );
			if ( titleLink ) {
				if ( slide.title ) {
					titleLink.textContent = slide.title;
				}
				if ( slide.link ) {
					titleLink.setAttribute( 'href', slide.link );
				}
			}

			var excerpt = container.querySelector( '.header-carousel-excerpt' );
			if ( excerpt ) {
				excerpt.textContent = slide.excerpt ? slide.excerpt : '';
			}

			var button = container.querySelector( '.header-carousel-button' );
			if ( button ) {
				var buttonHref = slide.button_link || slide.link;
				var buttonText = slide.button_text || '';
				if ( buttonHref ) {
					button.setAttribute( 'href', buttonHref );
				}
				if ( buttonText ) {
					button.textContent = buttonText;
				}
			}
		}

		function goToIndex( nextIndex ) {
			container.classList.add( 'is-fading' );

			window.setTimeout( function () {
				applyImage( container, images[ nextIndex ] );
				updateSlideText( nextIndex );
				container.classList.remove( 'is-fading' );
				currentIndex = nextIndex;
				updateDots( dots, currentIndex );
			}, FADE_DELAY );
		}

		dots = createDots( container, images, function ( index ) {
			goToIndex( index );
		} );
		updateDots( dots, currentIndex );
		updateSlideText( currentIndex );

		container.addEventListener( 'mouseenter', function () {
			isPaused = true;
		} );

		container.addEventListener( 'mouseleave', function () {
			isPaused = false;
		} );

		window.setInterval( function () {
			if ( isPaused ) {
				return;
			}
			goToIndex( ( currentIndex + 1 ) % images.length );
		}, SWITCH_DELAY );

		// Drag / swipe support
		var dragStartX = null;
		var isDragging = false;

		function onDragStart( x ) {
			dragStartX = x;
			isDragging = false;
		}

		function onDragEnd( x ) {
			if ( dragStartX === null ) {
				return;
			}

			var delta = x - dragStartX;
			dragStartX = null;

			if ( Math.abs( delta ) < DRAG_THRESHOLD ) {
				return;
			}

			isDragging = true;

			if ( delta < 0 ) {
				goToIndex( ( currentIndex + 1 ) % images.length );
			} else {
				goToIndex( ( currentIndex - 1 + images.length ) % images.length );
			}
		}

		// Suppress link clicks that result from a drag gesture
		container.addEventListener( 'click', function ( e ) {
			if ( isDragging ) {
				e.preventDefault();
				isDragging = false;
			}
		}, true );

		// Mouse drag
		container.addEventListener( 'mousedown', function ( e ) {
			onDragStart( e.clientX );
		} );

		document.addEventListener( 'mouseup', function ( e ) {
			if ( dragStartX !== null ) {
				onDragEnd( e.clientX );
			}
		} );

		// Touch swipe
		container.addEventListener( 'touchstart', function ( e ) {
			onDragStart( e.touches[ 0 ].clientX );
		}, { passive: true } );

		container.addEventListener( 'touchend', function ( e ) {
			onDragEnd( e.changedTouches[ 0 ].clientX );
		} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		var carousels = document.querySelectorAll( '.header-image[data-carousel-images]' );
		carousels.forEach( startCarousel );
	} );
}() );
