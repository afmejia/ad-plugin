$(document).ready(function() {
    var canvas = $( ".canvas" );
    var template = 0;
    if ( $( "#template" ).hasClass( 'template-1' ) ) {
        canvas.css( 'stroke-width', '5' );
        template = 1;
    } else {
        canvas.attr( "rx", 15 );
        template = 2;
    }
});