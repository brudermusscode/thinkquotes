 "use strict";
 
 $(function(){
 
    let url, overlay, formData, body = $("body");
    
    $(document)

    // >> quotes > report
	.on('click', '[data-action="popup:quotes,report"]', function(e) {

        var $t = $(this);
        var getData = $t.closest('quote').data("json");
        var qid = getData[0].qid;
        let url = dynamicHost + "/dyn/popups/quotes-report";

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'HTML',
            data: { qid: qid },
            beforeSend: function(){

                addOverlay();
                togglebody();
                
            },
            success: function(data){
                
                
                
                var ro = $('body').find('response-overlay');
                var form = $('[data-form="quotes,add"]');
                
                if(parseInt(data) === 0){
                    
                    showErrorModule("You need to have atleast one Quote with 20 upvotes!");
                    closeOverlay();
                    
                } else {
                    
                    ro.empty();
                    ro.append(data);
                    fitPopupModule();
                    
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

    // >> quotes > delete
    .on('click', '[data-action="popup:quotes,delete"]', function(e) {

        let $ro;
        let $t = $(this);
        let $q = $t.closest('quote');
        let getData = $q.data("json");
        let qid = getData[0].qid;
        let url = dynamicHost + "/dyn/quickies/check-quotes-owner";

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

                    let label = "Delete #" + qid,
                        icon = "delete",
                        text = "Are you sure to delete this quote?",
                        dataAction = "function:quotes,delete",
                        confirmationText = "Yes, remove it!";

                    // get overlay
                    $.ajax({
                        type: "POST",
                        url: "/dyn/popups/confirmation",
                        data: { 
                            a: label, 
                            b: icon, 
                            c: text,
                            d: dataAction,
                            e: confirmationText
                        },
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
                                cacheID.push(qid);
                                
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


});