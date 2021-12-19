class Overlay {

    static add(append, element, card = false, zIndex = false, color = false) {

        let $overlay, array, hw, position, elementOffset;

        // store offset of the clicked element
        elementOffset = element.offset();

        array = {
            overlay : null,
            element : null,
            loader  : null
        };
    
        // set body's overflow to hidden
        $('body').addClass('ovhid');

        // set zIndex if it's not passed
        if(!zIndex) {
            zIndex = "1000";
        }

        // set background colour to standard red, if no param was passed
        if(!color) {
            color = "var(--colour-red)";
        }

        // append the page overlay to passed param append and set a
        // background of the clicked element as well as it's height
        // and width and coordinates
        $overlay = append.prepend('<page-overlay style="background:'+element.css("background-color")+';height:'+element.outerHeight()+'px;width:'+element.outerWidth()+'px;top:'+elementOffset.top+'px;left:'+elementOffset.left+'px;z-index: ' + zIndex + ';"></page-overlay>');

        // store added page overlay
        $overlay = append.find("page-overlay");

        // add overlay to array
        array.overlay = $overlay;
        array.element = element;
    
        // set timeout function to get full fade in transition
        setTimeout(function(){
    
            // if it's not a card overlay
            setTimeout(function() {

                if(!card) {

                    // append closing area to the overlay
                    $overlay.append('<close-overlay><i class="ri-close-circle-line" style="font-size:3em;"></i></close-overlay');
                }
            }, 700);

            // make it visible
            $overlay.addClass("visible");

            // add some additional css for nice enlargen effect
            $overlay.addClass("visible").css({
                height: "100%"
            });

            setTimeout(function() {
                $overlay.css({
                    top:0,
                    left:0,
                    width: "100%",

                    // the color that was passed through param color. Std is var(--colour-red)
                    background: color
                });
            }, 0);
        }, 10);

        // return the overlay as array
        return array;
    }

    static close(append) {
        
        let $overlay = append.find("page-overlay");

        // let overlay fade out
        $overlay.css('opacity', '0');
    
        // set timeout for smooth fade out
        setTimeout(function(){

            // remove overlay
            $overlay.remove();
        }, 400);

        // reove overflow hidden of body
        append.removeClass('ovhid');
    }
}