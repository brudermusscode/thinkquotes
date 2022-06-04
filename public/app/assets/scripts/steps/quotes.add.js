$(() => {

    // TODO: go back and edit previous step
    // TODO:

    let url, formData, $t, body, $popupModule, $overlay, $steps, draftObject;

    body = $("body");

    // draft object for keeping last inserted values if the add overlay
    // will be closed before actually submitting the quote
    // TODO: do exactly that
    draftObject = {
        quote_id: 0
    };

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

        url = dynamicHost + "/template/quotes/add/author";

        // add new overlay
        overlay = Overlay.add(body, $(this), false);

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'HTML',
            success: function(data){

                if(data) {

                    // append the data which came from the xhr request
                    // to the overlay
                    overlay.overlay.append(data);

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
    .on("submit", "[data-form='quotes:add,author']", function () {

        url = dynamicHost + "/do/quotes/add/author";
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

                    // reset draftObject
                    draftObject = {};

                    // toggle off steps and hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    setTimeout(() => {

                        // add the quote id to the draft object
                        draftObject.quote_id = data.quote_id;

                        // prepare url for getting new template
                        url = dynamicHost + '/template/quotes/add/quote';

                        // TODO: add something to show when getting template fails
                        // get new template and add it up
                        getTemplate(url, $popupModule, draftObject);

                        setTimeout(() => {

                            // update the steps layer
                            $steps.find(".description p[here]")
                                  .html("Write down the quote");

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

        // prepare ajax url
        url = dynamicHost + "/do/quotes/add/quote";

        // prepare form data sent with ajax request
        formData = new FormData(this);
        formData.append("quote_id", draftObject.quote_id);

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

                    // reset draft object
                    draftObject = {};

                    // make popup module hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    // set timeout for updating whole content of popup module
                    setTimeout(() => {

                        // add the quote id to the draft object
                        draftObject.quote_id = data.quote_id;

                        // prepare url for getting new template
                        url = dynamicHost + '/template/quotes/add/source';

                        // TODO: add something to show when getting template fails
                        // get new template and add it up
                        getTemplate(url, $popupModule, draftObject);

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

        url = dynamicHost + "/do/quotes/add/source";
        formData = new FormData(this);
        formData.append("quote_id", draftObject.quote_id);

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

                    // reset draft object
                    draftObject = {};

                    // make popup module hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    setTimeout(() => {

                        // add the quote id to the draft object
                        draftObject.quote_id = data.quote_id;

                        // prepare url for getting new template
                        url = dynamicHost + '/template/quotes/add/categories';

                        // TODO: add something to show when getting template fails
                        // get new template and add it up
                        getTemplate(url, $popupModule, draftObject);

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

        url = dynamicHost + "/do/quotes/add/categories";
        formData = new FormData(this);
        formData.append("quote_id", draftObject.quote_id);

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

                    // reset draft object
                    draftObject = {};

                    // make popup module hide
                    toggleActive([
                        $popupModule,
                        $steps
                    ], false);

                    setTimeout(() => {

                        // add the quote id to the draft object
                        draftObject.quote_id = data.quote_id;

                        // prepare url for getting new template
                        url = dynamicHost + '/template/quotes/add/review';

                        // TODO: add something to show when getting template fails
                        // get new template and add it up
                        getTemplate(url, $popupModule, draftObject);

                        setTimeout(() => {

                            // change steps description text
                            $steps.find(".description p[here]")
                                .html("That's how your quote will look like!");
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
        url = dynamicHost + "/do/quotes/add/publish";

        $.ajax({

            url: url,
            data: { quote_id: draftObject.quote_id },
            method: "POST",
            dataType: "JSON",
            success: (data) => {

                if (data.status) {

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

                    console.error('Step', 5, 'quote', draftObject.quote_id, 'publishing failed!');

                    showErrorModule("A wild error appeared, fight it!");
                }
            },
            error: (data) => {
                console.error(data);
            }
        });
    });

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

    let getTemplate = (url, fillModule, dataObject = {}) => {

        let u = url;
        let m = fillModule;
        let d = dataObject;

        // TODO: validate if dataObject is an object

        $.ajax({

            url: u,
            data: d,
            method: 'POST',
            dataType: "HTML",
            success: (data) => {

                m.empty().prepend(data);

                return true;
            },
            error: (data) => {
                console.error(data);

                return false;
            }
        });

        return false;
    }
});