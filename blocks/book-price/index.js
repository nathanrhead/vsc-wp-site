( function( wp ) {
  if (!wp || !wp.blocks) return;

  wp.blocks.registerBlockType( 'responsive-child/book-price', {
    edit: function() {
      return 'Book price will be rendered on the front end.';
    },
    save: function() {
      return null;
    }
  } );
} )( window.wp );