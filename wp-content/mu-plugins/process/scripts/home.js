'use strict';

const productPage = {
    loadFlickity : function() {
        const elem = document.querySelector('.st-product-slider-container');
        if ( null === elem ) return;
        const flkty = new Flickity( elem, {
            contain: true,
            percentPosition: true,
            wrapAround: true,
            pageDots: false,
            cellAlign: 'center',
        });
    },
    loadGiftCardImageChanger : function() {
        if( typeof(giftCardVariationInfo) === 'undefined' ) return;
        const resetLink = document.querySelectorAll('.reset_variations')[0];
        const giftCardImageElement = document.querySelectorAll('.st-product-image img')[0]
       // Get the default image to revert when gift card is reset.
        const defGCImage = giftCardImageElement.src;
        document.addEventListener( 'input', (event) => {
           if ( 'gift-card-amount' !== event.target.id ) return;
           if( '' !== event.target.value ) {
               giftCardImageElement.src = giftCardVariationInfo[event.target.value];
           }
        });
        resetLink.addEventListener( 'click', (event) => {
            giftCardImageElement.src = defGCImage;
        })
    }
};

document.addEventListener('DOMContentLoaded', (event) => {
    productPage.loadGiftCardImageChanger();
});

window.addEventListener('load', (event) => {
    productPage.loadFlickity();
});
