$(function(){

    let $t, url, formData;

    // signin
    $(document).on('keypress', "[data-etat='login:username'], [data-etat='login:password']", function(event) {

        var keycode = (event.keyCode ? event.keyCode : event.which);

        if(keycode == '13'){
            $('[data-action="function:login"]').click();
        }


    }).on("click", "[data-action='function:login']", function(){

        var parentDiv = $(this).parents(1);
        var username = $.trim(parentDiv.find("input[name='username']").val());
        var password = $.trim(parentDiv.find("input[name='password']").val());
        var error;
        var errorModuleOutputRandom = randomStringArray(randomErrorTexts);
        let url = dynamicHost + "/dyn/sign/in";

        if(username < 1){
            error = 1;
        } else if(password < 1) {
            error = 2;
        } else {
            error = 3;
        }

        switch(error){
            case 1:
                error = "Please fill out username's field!";
                break;
            case 2:
                error = "Please fill out password's field!";
                break;
            case 3:
                error = "Verifying...";


                $.ajax({

                    url: url,
                    method: "POST",
                    data: {
                        username: username, password: password
                    },
                    dataType: "text",
                    success: function(loginData) {
                        
                        var ld = parseInt(loginData);
                        
                        switch(ld){
                            case 1:
                                error = "This user seems not te be existing!";
                                break;
                            case 2:
                                error = "Your username or password seems to be wrong!";
                                break;
                            case 3:
                                expandErrorModule('done_all', 'Verified');
                                
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                                
                                break;
                            default:
                                error = errorModuleOutputRandom;
                        }

                        showErrorModule(error);

                    },
                    error: function(loginData){
                        showErrorModule("Some randomness happened, you may want to try again!");
                    }

                });


                break;
            default:
                error = errorModuleOutputRandom;
        }

        showErrorModule(error);

    })
    
    // signup
    .on("submit", "[data-form='sign:up']", function(e) {

        $t = $(this);
        url = dynamicHost + "/dyn/sign/up";
        formData = new FormData(this);

        $.ajax({
            
            url: url,
            data: formData,
            method: $t.attr("method"),
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(data) {

                console.log(data);

                if(data.status) {

                } else {

                }

                showErrorModule(data.message);
            },
            error: function(data) {
                console.error(data);
            }

        });

    })

    // signout
    .on("click", "[data-action='function:sign,out']", function() {

        let url = dynamicHost + "/dyn/sign/out";

        $.ajax({

            url: url,
            method: "POST",
            data: { logout: true },
            dataType: "TEXT",
            beforeSend: function() {
                showErrorModule("Requesting logout...");
            },
            success: function(data) {

                var pdata = parseInt(data);

                if(pdata === 1) {

                    expandErrorModule('emoji_people', 'Goodbye! (ΘεΘ');

                    setTimeout(function(){
                        window.location.replace("/");
                    }, 2000);
                } else {
                    showErrorModule("The site doesn't want to let you go!");
                }

            },
            error: function(data) {
                showErrorModule("Oh! Something went wrong! Try again!");
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
        let icon;
        let text;
        let serializedData = { uid: uid, action: action };
        let $nt = $('.u-hdr').find("[data-action='function:friends,request,send/cancel/remove']");
        let ntGetData = $nt.data("json");

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

                        console.log(data);

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
                                icon = 'add_reaction';
                                text = 'Add friend';
                                ntGetData[0].action = 'addFriend';
                                break;
                            case 4:
                                error = "Friendrequest sent!";
                                icon = 'not_interested';
                                text = 'Cancel friendrequest';
                                ntGetData[0].action = 'cancelFriend';
                                break;
                            case 5:
                                error = "You are no longer friends! Too bad!";
                                icon = 'add_reaction';
                                text = 'Add friend';
                                ntGetData[0].action = 'addFriend';
                                closeOverlay();
                                togglebody();
                                break;
                            default:
                                error = "A wild error appeared! Fight it!";
                        }

                        $icon.html(icon);
                        $text.html(text);
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