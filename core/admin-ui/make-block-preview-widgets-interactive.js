// Make QR codes and copy buttons work in a block or Elementor preview

// Block editor: ServerSideRender replaces its markup after every attribute
// change, so re-run on each change. init() is idempotent; calling it often is
// the intended use.
const observer = new MutationObserver( () => window.benecasterFrontend?.init( wrapper ) );
observer.observe( wrapper, { childList: true, subtree: true } );

// Elementor: run for each widget instance when Elementor renders it, in the
// editor and on the live page alike. $scope is the widget's own element,
// which init() accepts directly.
jQuery( window ).on( 'elementor/frontend/init', () => {
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/my-benecaster-qr.default',
        ( $scope ) => window.benecasterFrontend?.init( $scope[ 0 ] )
    );
} );
