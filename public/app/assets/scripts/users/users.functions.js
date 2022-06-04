$(function(){

    let $t, url, formData, $contentCard, $nextSibling, which;

    $(document)

    // login
    .on("submit", '[data-form="sign:in"], [data-form="sign:in,code"]', function() {

        // get correct url for each case of sign in...
        if ($(this).data("form") == "sign:in") {

            url = dynamicHost + "/do/users/login/request_code";
            which = "in";
        } else {

            // and passing a authentication code
            url = dynamicHost + "/do/users/login/verify_code";
            which = "code";
        }

        // get formdata
        formData = new FormData(this);

        // choose current content-card
        $contentCard = $(this).closest("content-card");

        // with that content-card chosen, choose the next sibling
        $nextSibling = $contentCard.next();

        $.ajax({

            url: url,
            data: formData,
            method: $(this).attr("method"),
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(data) {

                if (data.status) {

                    if(which == "in") {

                        // toggle class visible for both content card, so
                        // passing code will be made possible
                        $contentCard.toggleClass("visible");
                        $nextSibling.toggleClass("visible");

                        // find uid input and set it
                        $nextSibling.find("input[name='uid']").val(data.uid);

                        // why so ever, but focus on the first code input
                        // after timeout of 100 ms
                        setTimeout(function() {
                            $nextSibling.find("input[name='code1']").focus();
                        }, 100);
                    } else {

                        $(document).find("close-overlay").click();

                        setTimeout(function() {
                            window.location.reload();
                        }, 750);
                    }
                }

                // show responsive error module with error text only
                // if the message of the response is not NULL
                if(data.message !== null) {

                    showErrorModule(data.message);
                }
            },
            error: function(data) {
                console.error(data);
            }
        });

    })

    // signup
    .on("submit", '[data-form="sign:up"]', function() {

        url = dynamicHost + "/do/users/register/signup";
        // get formdata
        formData = new FormData(this);

        // choose current content-card
        $contentCard = $(this).closest("content-card");

        // with that content-card chosen, choose the next sibling
        $nextSibling = $contentCard.next();

        $.ajax({

            url: url,
            data: formData,
            method: $(this).attr("method"),
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(data) {

                if (data.status) {

                    // toggle class visible for both content card, so
                    // passing code will be made possible
                    $contentCard.toggleClass("visible");
                    $nextSibling.toggleClass("visible");

                    // find uid input and set it
                    $nextSibling.find("input[name='uid']").val(data.uid);

                    // why so ever, but focus on the first code input
                    // after timeout of 100 ms
                    setTimeout(function() {
                        $nextSibling.find("input[name='code1']").focus();
                    }, 100);
                }

                // show responsive error module with error text
                showErrorModule(data.message);
            },
            error: function(data) {
                console.error(data);
            }
        });

    })


    // go to next input if maxlength is reached
    .on("input", "input", function() {

        if (this.hasAttribute("maxlength")) {

            $t = $(this);
            value = this.value;
            $nextSibling = $t.next();
            $previousSibling = $t.prev();
            $lastSibling = $t.parent().find("input").last();
            let maxLength = this.getAttribute("maxlength");

            // if the maxlength of the input is reached, ...
            if (value.length >= maxLength) {

                // ... focus the enxt sibling
                $nextSibling.focus();

                // if we reached the last element of the code input
                // chain, submit the form and check, if the code is valid
                if ($lastSibling.attr("maxlength") == $lastSibling.val().length) {
                    $t.closest("form").submit();
                }

                // if input is empty, change to previous sibling
            } else if (value.length == 0) {
                $previousSibling.focus();
            }
        }

        return false;
    })

    // logout
    .on("click", "[data-action='users:sign,out']", function() {

        let url = dynamicHost + "/do/users/logout";

        $.ajax({

            url: url,
            method: "POST",
            dataType: "JSON",
            beforeSend: () => {

                showErrorModule("Logging out...");
            },
            success: (data) => {

                if(data.status) {

                    // show error module with error output
                    showErrorModule(data.message);

                    // set timeout to give user time for reading output
                    // actually just for letting everything look smooth and cool
                    setTimeout(() => {

                        // reload page
                        window.location.replace('/');
                    }, 1200);

                } else {

                    // should never happen here so...
                }
            },
            error: (data) => {
                console.error(data);
            }


        });

    })


    // friendsrequests >> send, cancel
    .on("click", "[data-action='function:friends,request,actions']", function () {
        let $t = $(this);
        let getData = $t.data("json");
        let uid = parseInt(getData[0].uid);
        let action = $t.data().do;
        let dataObject = { uid: uid };

        let url;

        switch (action) {
            case 'request':
                url = dynamicHost + '/do/users/friends/request';
                break;
            case 'cancel_request':
                url = dynamicHost + '/do/users/friends/cancel_request'
                break;
        }

        $.ajax({
            url: url,
            method: "POST",
            data: dataObject,
            dataType: "JSON",
            success: (data) => {

                if (data.status) {

                    switch (data.action) {
                        case 'request':
                            $t.removeClass('request');
                            $t.addClass("cancel_request");

                            // set new action
                            $t.data('do', 'cancel_request');

                            break;
                        case 'cancel_request':
                            $t.removeClass('cancel_request');
                            $t.addClass("request");

                            // set new action
                            $t.data('do', 'request');

                            break;
                    }

                    return;
                }

                showErrorModule(data.message);
            },
            error: (data) => {
                console.error(data);
            }
        });
    })

    // friendrequests >> accept/decline/ignore
    .on("click", "[data-action='function:friends,request,answer']", function() {

        let $t = $(this);
        let $request_outer = $t.closest('.friendrequests-outer');
        let get_data = $t.data('json');
        let action = get_data[0].action;
        let id = get_data[0].id;
        let user_sent_id = get_data[0].user_sent_id;
        let dataString = { id: id, uid: user_sent_id };

        let url;

        switch (action) {
            case 'accept_request':
                url = dynamicHost + '/do/users/friends/accept_request';
                break;
            case 'decline_request':
                url = dynamicHost + '/do/users/friends/cancel_request'
                break;
        }

        $.ajax({

            url: url,
            data: dataString,
            method: "POST",
            dataType: "JSON",
            success: (data) => {

                if (data.status) {

                    // delete container with request
                    $request_outer.remove();

                    // switch through action cases for different behavior
                    switch (data.action) {
                        case 'accept_request':
                            break;
                        case 'cancel_request':
                            break;
                    }
                    return;
                }
            },

            // kinda stinks with timeout
            // complete: () => {
            //     setTimeout(function(){
            //         if($frOuter.children().length < 1) {
            //             url = dynamicHost + "/dyn/content/friends-requests-empty.php";
            //             $frOuter.load(url);
            //         }
            //     }, 400);
            // },

            error: (data) => {
                console.error(data);
            }

        });
    })

    // settings
    .on("click", '#settings-main radio-model .single', function() {

        let $t = $(this);
        let $rm = $t.parent();
        let val = $t.data("value");
        let f;
        let sendChanges = $t.hasClass('isActive');

        // responsive design
        $rm.find('.single').each(function() {
            $(this).removeClass('isActive');
        });

        if ($rm.hasClass('std')) {
            $t.addClass('isActive');
        }

        // change actual value
        $rm.find('[data-react="element:radio"]').val(val);

        // serialize values
        f = $(this).closest('[data-form="users:settings"]').serialize();

        // request save settings
        if(!sendChanges) {
            usersSaveSettings(f);
        }

    })

    // check notifications >> main menu
    .on("click", 'usermainmenu', function() {

        let $t = $(this);
        let $notify_dot = $t.find('[data-element="notify-dot"]');

        url = dynamicHost + "/do/users/check_notifications/main_menu";

        $.ajax({
            url: url,
            dataType: "JSON",
            method: "POST",
            success: (data) => {
                if (data.status) {
                    $notify_dot.remove();
                }
            },
            error: () => {
                showErrorModule("Oopsie");
            }
        });

    });

});


let usersSaveSettings = function(form) {

    let url = dynamicHost + "/dyn/users/settings";
    let error;
    let f = form;

    $.ajax({

        method: "POST",
        dataType: "text",
        url: url,
        data: f,
        success: function(data) {

        },
        error: function(data) {
            error = "A wild error appeared! Fight it!";
            showErrorModule(error);
        }

    });

}