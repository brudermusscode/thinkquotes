 "use strict";

 $(function(){

    let url, overlay, formData, body = $("body");

    $(document)

    // >> quotes > report
	.on('click', '[data-action="popup:quotes,report"]', function(e) {

        let $t = $(this);
        let getData = $t.closest('quote').data("json");
        let qid = getData[0].qid;
        let url = dynamicHost + "/template/quotes/_report";

        // add new overlay
        overlay = Overlay.add(body, $(this), false);

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'HTML',
            data: { qid: qid },
            success: function(data){

                let ro = $('body').find('response-overlay');
                let form = $('[data-form="quotes,add"]');

                if(parseInt(data) === 0){

                    showErrorModule("You need to have atleast one Quote with 20 upvotes!");
                    closeOverlay();

                } else {

                    setTimeout(() => {
                        overlay.overlay.append(data);
                        fitPopupModule();
                    }, 400)

                }

            },
            error: function(data){
                showErrorModule("Some randomness just happened, try again!");
            }
        });

	})

    // >> quotes > edit
    .on('click', '[data-action="popup:quotes,edit"]', function(e) {

        categoryArray = [];
        let $ro;
        let $t = $(this);
        let $q = $t.closest('quote');
        let getData = $q.data("json");
        let qid = getData[0].qid;
        let url = dynamicHost + "/dyn/quickies/get-quote-categories";

        // get categories first
        $.ajax({
            type: "POST",
            url: url,
            data: { qid: qid },
            dataType: 'HTML',
            beforeSend: function(){

                addOverlay();
                togglebody();

            },
            success: function(data){

                if(parseInt(data) !== 0) {

                    // pass categories to array
                    categoryArray = JSON.parse(data);

                    // get overlay
                    $.ajax({
                        type: "POST",
                        url: "/dyn/popups/quotes-edit",
                        data: { qid: qid },
                        dataType: 'HTML',
                        success: function(data){

                            $ro = $('body').find('response-overlay');
                            let $form = $('[data-form="quotes,add"]');

                            if(parseInt(data) === 0){

                                showErrorModule("A wild error appeared! Fight it!");
                                closeOverlay();

                            } else {

                                $ro.empty();
                                $ro.append(data);
                                fitPopupModule();
                                resizeTextarea('textarea');

                            }

                        },
                        error: function(response){
                            showErrorModule("Some randomness just happened, try again!");
                        }
                    });

                } else {
                    showErrorModule("A wild error appeared! Fight it!");
                    closeOverlay();
                }

            },
            error: function() {

            }

        });

    })

    // >> quotes, archive
    .on("click", "[data-action='popups:quotes,delete']", function(){

        let $t, qid, url, formData, overlay;

        // add new overlay
        overlay = Overlay.add(body, $(this), false);

        $t = $(this);
        qid = $t.closest("quote").data("json")[0].qid;
        formData = { qid: qid };
        url = dynamicHost + "/template/quotes/_archive";

        $.ajax({

            url: url,
            data: formData,
            dataType: "HTML",
            method: "POST",
            success: (data) => {

                if(data) {

                    overlay.overlay.prepend(data);
                } else {

                    showErrorModule(stdErrorOutput);
                }
            },
            error: (data) => {
                showErrorModule(stdErrorOutput);
            }

        });

    });

});