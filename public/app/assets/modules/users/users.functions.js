$(function(){

    let $t, url, formData, $contentCard, $nextSibling, which;

    $(document)

    // login
    .on("submit", '[data-form="sign:in"], [data-form="sign:in,code"]', function() {

        // get correct url for each case of sign up...
        if ($(this).data("form") == "sign:in") {

            url = dynamicHost + "/dyn/sign/in";
            which = "in";
        } else {

            // and passing a authentication code
            url = dynamicHost + "/dyn/sign/code";
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


                        console.log(data);

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

        url = dynamicHost + "/dyn/sign/up";

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

    // signout
    .on("click", "[data-action='users:sign,out']", function() {

        let url = dynamicHost + "/dyn/sign/out";

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
                        window.location.reload();
                    }, 800);

                } else {

                    // should never happen here so 
                }
            },
            error: (data) => {
                console.error(data);
            }

            
        });

    })


    // friendsrequests >> send/cancel/delete
    .on("click", "[data-action='function:friends,request,send/cancel/remove']", function() {

        let $t = $(this);
        let getData = $t.data("json");
        let uid = getData[0].uid;
        let action = getData[0].action;
        let error;
        let serializedData = { uid: uid, action: action };
        let $nt = $('.u-hdr').find("[data-action='function:friends,request,send/cancel/remove']");

        let url = dynamicHost + "/dyn/users/friends-add.php";

        switch(action) {
            case "addFriend":
            case "cancelFriend":
            case "removeFriend":
                $.ajax({
                    url: url,
                    method: "POST",
                    data: serializedData,
                    dataType: "TEXT",
                    success: function(data) {

                        $t.removeClass('addFriend, removeFriend, cancelRequest');

                        let $icon = $nt.find(".material-icons-round");
                        let $text = $nt.find(".text");
            
                        switch(parseInt(data)) {
                            case 1:
                                error = "You are already friends!";
                                break;
                            case 2:
                                error = "You can't be friends with that user!";
                                break;
                            case 3:
                                error = "Friendrequest canceled!";
                                $t.addClass("addFriend");
                                break;
                            case 4:
                                error = "Friendrequest sent!";
                                $t.addClass("cancelRequest");
                                break;
                            case 5:
                                error = "You are no longer friends! Too bad!";
                                $t.addClass("removeFriend");
                                closeOverlay();
                                togglebody();
                                break;
                            default:
                                error = "A wild error appeared! Fight it!";
                        }

                        showErrorModule(error);

                    },
                    error: function(data) {

                        showErrorModule("A wild error appeared! Fight it!");

                    }
            
                });
                break;
            case "removeFriendRequest":

                let label = "Remove friend";
                let dataIcon = "sentiment_very_dissatisfied";
                let dataText = "Do you really want to give up this friendship?";
                let dataAction = $t.data("action");
                let confirmationText = "Yes, please!";

                action = 'removeFriend';
                let dataJSON = JSON.stringify([{uid: uid, action: action}]);

                url = dynamicHost + "/dyn/popups/confirmation";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        a: label,
                        b: dataIcon,
                        c: dataText,
                        d: dataAction,
                        e: confirmationText,
                        f: dataJSON
                    },
                    dataType: 'HTML',
                    success: function (response) {

                        if (parseInt(response) === 0) {
                            showErrorModule("A wild error appeared! Fight it!");
                        } else {

                            addOverlay();
                            togglebody();
                            var ro = $(document).find('response-overlay');
                            ro.empty();
                            ro.append(response);
                            fitPopupModule();

                        }

                    },
                    error: function (response) {
                        showErrorModule("Some random error happened, try again!");
                    }
                });

                break;
            default:
                showErrorModule("A wild error appeared! Fight it!");
        }
    })

    // friendrequests >> accept/decline/ignore
    .on("click", "[data-action='function:friends,request,accept/decline']", function() {
        
        let url = dynamicHost + "/dyn/users/friends-requests-actions.php";
        let $t = $(this);
        let $fr = $t.closest('.fr-inr');
        let $frOuter = $fr.closest(".friendrequests-outer");
        let frHeight = $fr.outerHeight();
        let getData = $t.data("json");
        let frid = getData[0].frid;
        let usid = getData[0].usid;
        let action = getData[0].action;
        let dataA = { frid: frid, usid: usid, action: action };
        let error;

        $.ajax({

        url: url,
        method: "POST",
        data: dataA,
        dataType: "TEXT",
        beforeSend: function() {
            showErrorModule("Verifying...");
            $fr.css({"height":frHeight + "px"});
        },
        success: function(data) {

            switch(data){
                case "1":
                    error = "You are now friends!";
                    $fr.addClass('hidden').css({"height":"0px"});
                    setTimeout(function(){
                        $fr.remove();
                    }, 400);
                    break;
                case "2":
                    $fr.addClass('hidden').css({"height":"0px"});
                    setTimeout(function(){
                        $fr.remove();
                    }, 400);
                    error = "Friendrequest declined!";
                    // ask for ignore friendrequests from this user
                    break;
                case "3":
                    error = "You won't get any friendrequests from this user!";
                    break;
                default:
                    error = "A wild error appeared! Fight it!";
            }

            showErrorModule(error);

        },

        // kinda stinks with timeout
        complete: function() {
            setTimeout(function(){
                if($frOuter.children().length < 1) {
                    url = dynamicHost + "/dyn/content/friends-requests-empty.php";
                    $frOuter.load(url);
                }
            }, 400);
        },
        error: function(data) {
            showErrorModule("A wild error appeared! Fight it!");
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

            console.log(data);

        },
        error: function(data) {
            error = "A wild error appeared! Fight it!";
            showErrorModule(error);
        }

    });

}