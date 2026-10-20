// Follow along with an episode as it plays — highlight the current line, jump on click

// Markup: <li class="my-line" data-episode="42" data-start="83.5">…</li>
document.addEventListener( 'click', ( event ) => {
    const line = event.target.closest( '.my-line' );
    if ( ! line ) return;
    window.benecasterFrontend.seek( Number( line.dataset.episode ), Number( line.dataset.start ) );
} );

document.addEventListener( 'benecaster:timeupdate', ( event ) => {
    const { episodeId, currentTime } = event.detail;
    document.querySelectorAll( `.my-line[data-episode="${ episodeId }"]` ).forEach( ( line ) => {
        line.classList.toggle( 'is-current', Number( line.dataset.start ) <= currentTime && currentTime < Number( line.dataset.end ) );
    } );
} );
