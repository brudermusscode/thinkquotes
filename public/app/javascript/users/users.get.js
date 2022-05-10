$(function () {

    let url, body = $("body");

    $(document)

    // sign in
    .on("click", "[data-action='popup:login']", function (e) {

        // add new overlay
        overlay = Overlay.add(body, $(this), false);

        // set url for xhr
        url = dynamicHost + "/template/popups/_login";

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'HTML',
            success: function (data) {

                setTimeout(function() {

                    overlay.overlay.append(data);
                }, 700);
            },
            error: function (data) {
                console.error(data);
            }
        });
    })

    // sign up
    .on("click", "[data-action='popup:signup']", function (e) {

        // add new overlay
        overlay = Overlay.add(body, $(this), false);

        // set url for xhr
        url = dynamicHost + "/template/popups/_signup";

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'HTML',
            success: function (data) {

                setTimeout(function() {

                    overlay.overlay.append(data);
                }, 700);
            },
            error: function (data) {
                console.error(data);
            }
        });
    })

    // sign >> out
    .on("click", "[data-action='popup:signout']", function (e) {

        let label = "Logout",
            icon = "contact_support",
            text = "You want to go already?",
            dataAction = "function:sign,out",
            confirmationText = "Yes, let me go!";

        let url = dynamicHost + "/dyn/popups/confirmation";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                a: label,
                b: icon,
                c: text,
                d: dataAction,
                e: confirmationText
            },
            dataType: 'HTML',
            success: function (response) {

                var errorModuleOutput = randomStringArray(randomErrorTexts);

                if (parseInt(response) === 0) {

                    showErrorModule(errorModuleOutput);
                    window.location.replace("./404");

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

    })

    // friends >> requests
    .on("click", '[data-action="popup:users,friendrequests"]', function () {

        let url = dynamicHost + "/dyn/popups/users-friendsrequests";
        let error;
        let $t = $(this);

        $.ajax({

            url: url,
            method: "POST",
            dataType: "TEXT",
            success: function (data) {

                if (parseInt(data) !== 0) {

                    addOverlayAppendData(data);
                    $t.removeClass('hasRequest');

                } else {

                    togglebody();
                    closeOverlay();
                    showErrorModule("A wild error appeared! Fight it!");

                }

            },
            error: function (data) {
                showErrorModule("A wild error appeared! Fight it!");
            }

        });

    })

    // settings
    .on("click", '[data-action="popup:users,settings"]', function () {

        let url = dynamicHost + "/dyn/popups/users-settings";
        let error;
        let $t = $(this);
        let $ro;

        $.ajax({

            url: url,
            method: "POST",
            dataType: "TEXT",
            success: function (data) {

                if (parseInt(data) !== 0) {

                    addOverlayAppendData(data);
                    $ro = $(document).find('response-overlay');
                    $ro.css({ "background":"var(--colour-dark)" });

                    usersSettingsPage('privacy');


                } else {

                    togglebody();
                    closeOverlay();
                    showErrorModule("A wild error appeared! Fight it!");

                }

            },
            error: function (data) {
                showErrorModule("A wild error appeared! Fight it!");
            }

        });

    })

    // settings >> switch pages
    .on("click", '[data-action="users:settings,page"]', function(){

        let $t = $(this);
        let page = $t.data('settings-page');

        if(!$t.hasClass('isActive')) {
            usersSettingsPage(page);
        }

    });

});

let addOverlayAppendData = function (content, append = undefined) {

    let data = content;
    let appendTo = append;
    let $overlay;

    console.log(appendTo);

    togglebody();
    addOverlay(appendTo);

    if(appendTo !== undefined) {
        $overlay = $(appendTo).find('response-overlay');
    } else {
        $overlay = $("body").find('response-overlay');
    }

    $overlay.empty();
    $overlay.append(data);
    fitPopupModule();

    return true;

}

let checkUsersSettings = function(action) {

    let a = action;
    let u = dynamicHost + "/dyn/quickies/check-settings.php";

    $.ajax({
        url: u,
        data: { action: a },
        dataType: "TEXT",
        method: "POST",
        success: function(data) {
            console.log(data);
            return true;
        },
        error: function(data) {
            return false;
        }
    });

}

let usersSettingsPage = function(what) {

    let $ro = $(document).find('response-overlay');
    let pageText;
    let loadContent = $ro.find('[data-react="users:settings,content"]');
    let $progressBar = $ro.find('[data-element="overlay:progress"] .progress-bar');
    let validInput = false;

    switch(what) {
        case "privacy":
            pageText = "Privacy";
            url =  dynamicHost + "/dyn/content/settings/privacy";
            validInput = true;
            break;
        case "general":
            pageText = "General";
            url =  dynamicHost + "/dyn/content/settings/general";
            validInput = true;
            break;
        default:
            closeOverlay();
            showErrorModule("A wild error appeared! Fight it!");
    }

    if(validInput) {

        $.ajax({
            url: url,
            data: what,
            method: "POST",
            dataType: "TEXT",
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        $progressBar.css({ width:percentComplete + "%" });
                    }
            }, false);

            xhr.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = (evt.loaded / evt.total) * 100;
                    $progressBar.css({ width:percentComplete + "%" });
                }
            }, false);

            return xhr;
            },

            success: function (data) {

                setTimeout(function(){
                    $progressBar.removeAttr('style');
                }, 400);

                loadContent.empty();
                loadContent.append(data);

            },
            error: function(data) {
                closeOverlay();
                showErrorModule('A wild error appeared! Fight it!');
            }
        });

        pageText = $ro.find('[data-react="users:settings,page"]').html(pageText);

        return true;
    }

    return false;
}