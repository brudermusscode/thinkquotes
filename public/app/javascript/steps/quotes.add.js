$(() => {

    // TODO: go back and edit previous step
    // TODO:

    let url, formData, $t, body, $popupModule, $overlay, $steps, draftObject;

    body = $("body");

    // draft object for keeping last inserted values if the add overlay
    // will be closed before actually submitting the quote
    // TODO: do exactly that
    draftObject = [];

    // set document for every function
    $(document)

    // submit forms on button click in steps layer
    .on("click", "[data-hellofresh='quotes:add,submit']", function() {

        formSubmit($(document).find("[data-form]"));
    })

    // go further if a card was clicked
    .on("click", "card", function() {

        let value = this.childNodes[1].innerHTML;
        let input = $popupModule.find("input[type='text']");

        // change the inputs value to the ones clicked
        input.val(value);

        // set timeout of small num since we need to await the
        // exchange of the input values and submit the form
        // afterwards
        setTimeout(() => {

            formSubmit($(document).find("[data-form]"));
        }, 20);
    })

    // on type, search for existing entries
    .on("input", "input[type='text']", function() {

        let $append = $popupModule.find('[data-element="quotes:add,recommended"]');
        let what = this.name;
        formData = this.value;

        // check what to search for and return false,
        // if someone likes to play around and changes
        // valid search strings
        switch (what) {
            case "author":
                url = dynamicHost + "/do/content/search-authors";
                break;

            case "source":
                url = dynamicHost + "/do/content/search-sources";
                break;

            case "category":
                url = dynamicHost + "/do/content/search-categories";
                break;

            default:
                return false;
        }

        // check if input is empty
        if (isEmpty(formData)) {
            return false;
        }

        $.ajax({

            url: url,
            data: {
                search: formData
            },
            method: "POST",
            dataType: "HTML",
            success: (data) => {

                if (data !== 0) {
                    $append.empty();
                    $append.append(data);
                }

            },
            error: (data) => {
                console.error(data);
            }

        });

    })

    // TODO: dry code steps, you can do in one function with dynamic variables
    // *    url, formdata, etc.
    // ! add quote has been clicked!
    .on("click", '[data-action="popup:quotes,add"]', function() {

        url = dynamicHost + "/do/steps/quotes/author";

        // add new overlay
        overlay = Overlay.add(body, $(this), false);

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'JSON',
            success: function(data){

                if(data.status) {

                    // append the data which came from the xhr request
                    // to the overlay
                    overlay.overlay.append(data.message);

                    // assign popup module and steps layer
                    $popupModule = overlay.overlay.find("popup-module");
                    $steps = overlay.overlay.find("steps");

                    // set timeout for fading content in
                    setTimeout(() => {

                        // add class active to popup module so it gets visible
                        // after x amounts of seconds
                        toggleActive([
                            $popupModule,
                            $steps
                        ], true);

                        // add slideUp animations to all cards with recommendations
                        $popupModule.find("card").addClass("slideUpSlow");

                        // focus input on load
                        $(document).find("input[type='text']").focus();

                    }, 600);
                }
            },
            error: function(data){
                console.error(data);
            }
        });
    })

    // ? step 1: add the author
    .on("submit", "[data-form='quotes:add,author']", function() {

        url = dynamicHost + "/do/steps/quotes/quote";
        formData = new FormData(this);

        // check if author input s empty and return false
        if (isEmpty(formData.get("author"))) {
            return false;
        }

        $.ajax({

            url: url,
            data: formData,
            method: this.method,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: (data) => {

                if (data.status) {

                    // add the author id to the draft object
                    draftObject.aid = data.aid;

                    // toggle off steps and hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    setTimeout(() => {

                        $popupModule.empty()
                            .prepend(data.message);

                        setTimeout(() => {

                            // update the steps layer
                            $steps.find(".description p[here]")
                                .html("Write down the actual quote by " + formData.get("author"));

                            // make popup module visible
                            toggleActive([
                                $popupModule,
                                $steps
                            ], true);
                        }, 100);
                    }, 1000);
                } else {
                    showErrorModule(data.message);
                }
            },
            error: (data) => {
                console.error(data);
            }
        });
    })

    // ? step 2: add the quote
    .on("submit", "[data-form='quotes:add,quote']", function() {

        url = dynamicHost + "/do/steps/quotes/source";
        formData = new FormData(this);

        // append the aid to the formData and be sure to check in PHP
        // if the aid was submitted
        formData.append("aid", draftObject.aid);

        // check if the inputs are empty
        for (let values of formData.entries()) {
            if (isEmpty(values[1])) {
                return false;
            }
        }

        $.ajax({

            url: url,
            data: formData,
            method: this.method,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: (data) => {

                if (data.status) {

                    // add the quote text to the draftObject
                    draftObject.quote = data.quote;
                    draftObject.qid = data.qid;

                    // make popup module hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    // set timeout for updating whole content of popup module
                    setTimeout(() => {

                        // clear the popup module's content
                        $popupModule.empty()

                        // and append the new
                        .prepend(data.message);

                        // set timeout for updating the step layer and sliding it in
                        setTimeout(() => {

                            // update steps layer
                            $steps.find(".description p[here]")
                                .html("The source is, where you heard or read about the quote");

                            // make popup module visible
                            toggleActive([
                                $popupModule,
                                $steps
                            ], true);
                        }, 100);
                    }, 1000);
                } else {
                    showErrorModule(data.message);
                }
            },
            error: (data) => {
                console.error(data);
            }
        });
    })

    // ? step 3: add the source
    .on("submit", "[data-form='quotes:add,source']", function() {

        url = dynamicHost + "/do/steps/quotes/categories";
        formData = new FormData(this);

        // append new values to formData and make sure to
        // verify those in PHP script
        formData.append("aid", draftObject.aid);
        formData.append("quote", draftObject.quote);
        formData.append("qid", draftObject.qid);

        // check if the inputs are empty
        for (let values of formData.entries()) {

            if (isEmpty(values[1])) {
                return false;
            }
        }

        $.ajax({

            url: url,
            data: formData,
            method: this.method,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: (data) => {

                if (data.status) {

                    // add source id to draftObject
                    draftObject.sid = data.sid;

                    console.log(draftObject);

                    // make popup module hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    setTimeout(() => {

                        $popupModule.empty()
                            .prepend(data.message);

                        setTimeout(() => {

                            // change steps description text
                            $steps.find(".description p[here]")
                                .html("Choose a category, that describes the quote's content");

                            // make popup module visible
                            toggleActive([
                                $popupModule,
                                $steps
                            ], true);
                        }, 100);
                    }, 1000);
                } else {
                    showErrorModule(data.message);
                }
            },
            error: (data) => {
                console.error(data);
            }
        });
    })

    // ? step 4: add the category
    .on("submit", "[data-form='quotes:add,category']", function() {

        url = dynamicHost + "/do/steps/quotes/all";
        formData = new FormData(this);

        // append evertyhing to formData
        formData.append("aid", draftObject.aid);
        formData.append("quote", draftObject.quote);
        formData.append("qid", draftObject.qid);
        formData.append("sid", draftObject.sid);

        // check if the inputs are empty
        for (let values of formData.entries()) {

            if (isEmpty(values[1])) {
                return false;
            }
        }

        $.ajax({

            url: url,
            data: formData,
            method: this.method,
            dataType: "HTML",
            contentType: false,
            processData: false,
            success: (data) => {

                if (data) {

                    // make popup module hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    setTimeout(() => {

                        $popupModule.empty()
                            .prepend(data);

                        setTimeout(() => {

                            // change steps description text
                            $steps.find(".description p[here]")
                                .html("That's how your quote will look like");
                            $steps.find("hellofresh")
                                .attr("data-action", "quotes:add,all,submit")
                                .html('<i class="ri-check-line std"></i>');

                            // make popup module visible
                            toggleActive([
                                $popupModule,
                                $steps
                            ], true);
                        }, 100);
                    }, 1000);
                } else {
                    showErrorModule(data.message);
                }
            },
            error: (data) => {
                console.error(data);
            }
        });
    })

    // ? step 5: submit everything
    .on("click", "[data-action='quotes:add,all,submit']", function() {

        // reassign url for xhr request
        url = dynamicHost + "/do/steps/quotes/_submit";

        // select form
        let form = document.querySelector('[data-form="quotes:add,all"]');

        // submit all to function and store result in variable
        submitAllResult = submitAll(form, url);

        // submit all
        if (submitAllResult) {

            // add new overlay
            overlay = Overlay.add(body, $(this), false, "1001", "var(--colour-lila-200)");

            // set a timeout to make everything smooth looking
            setTimeout(() => {

                // add confirmation text to overlay
                // TODO: maybe add own file with some script action to let it look even cooler
                overlay.overlay.append('<popup-module class="active"><div class="confirmation-text centered"><p>Lovely!</p></div></popup-module>');

                // set another timeout to close the overlay
                setTimeout(() => {
                    closeOverlay(body);
                }, 1800);
            }, 600);
        } else {
            showErrorModule("A wild error appeared, fight it!");
        }
    });

    // submit everything
    let submitAll = (form, url) => {

        let ajax = true;

        // construct formdata
        formData = new FormData(form);

        // check if the inputs are empty
        for (let values of formData.entries()) {

            if (isEmpty(values[1])) {
                return false;
            }
        }

        ajax = $.ajax({

            url: url,
            data: formData,
            method: "POST",
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: (data) => {

                if (!data.status) {
                    return false;
                }
            },
            error: (data) => {
                console.error(data);
            }
        })
        // .responseJSON
        ;



        return ajax;
    }

    // create function to use again for checking emty input/textarea strings
    const isEmpty = (str) => {

        if ($.trim(str).length < 1) {
            return true;
        }

        return false;
    }

    const formSubmit = (form) => {
        form.submit();
    }

    // TODO: make update step function for dry code
    const updateSteps = (steps, str, icon = false) => {

        let $steps = steps;

    }

    // TODO: use toggleClass now that I found the error
    const toggleActive = (container, active = true) => {

        for (let i = 0; i < container.length; i++) {
            if (active) {
                container[i].addClass("active");
            } else {
                container[i].removeClass("active");
            }
        }

        return true;
    }
});