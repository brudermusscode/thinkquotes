<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST) && LOGGED) {
    if ($my->post_permissions != "none") {

?>


        <popup-module>
            <form data-form="quotes:add,author" method="POST" action>
                <div class="inr">

                    <label for="popup-module" class="mb32">
                        <div class="label-inr light">
                            <p>Who said it?</p>
                        </div>
                    </label>

                    <div class="input">
                        <div class="pulse"></div>
                        <input name="author" type="text" placeholder="Buddha, Mark Aurel, Arthur Schopenhauer, ..." autofocus="true" />
                    </div>

                    <div class="recommendations" data-element="quotes:add,recommended">

                        <?php

                        $stmt = $pdo->prepare("SELECT * FROM quotes_authors ORDER BY RAND() LIMIT 12");
                        $stmt->execute();

                        foreach ($stmt->fetchAll() as $s) {

                        ?>

                            <card>
                                <p><?php echo $s->author_name; ?></p>
                            </card>

                        <?php } ?>

                    </div>

                </div>
            </form>
        </popup-module>

        <steps>
            <div class="steps-inr">

                <div class="description disfl fldirrow">
                    <p class="mr12">
                        <i class="ri-information-fill small"></i>
                    </p>
                    <p class="trimt" here>Choose the author, that created your following quote</p>

                    <div class="cl"></div>
                </div>

                <div class="tools">
                    <div class="disfl fldirrow">
                        <div>
                            <hellofresh data-hellofresh="quotes:add,submit" class="hellofresh hover-shadow shadowed green rd12 icon-only mr12 posrel">
                                <div class="c-ripple js-ripple">
                                    <span class="c-ripple__circle"></span>
                                </div>
                                <p class="lt posabs alignmiddle">
                                    <i class="ri-arrow-right-line std"></i>
                                </p>

                                <div class="cl"></div>
                            </hellofresh>
                        </div>
                    </div>
                </div>

                <div class="cl"></div>
            </div>
        </steps>

        <script class="dno">
            $(() => {

                let url, formData, $t, body, $popupModule, $overlay, $steps;

                body = $("body");
                $popupModule = body.find("popup-module");
                $overlay = $popupModule.closest("page-overlay");
                $steps = $overlay.find("steps");

                setTimeout(() => {

                    // add class active to popup module so it gets visible
                    // after x amounts of seconds
                    toggleActive([
                        $popupModule,
                        $steps
                    ], true);

                    // add slideUp animations to all cards with recommendations
                    $popupModule.find("card").addClass("slideUpSlow");

                }, 600);

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
                    .on("input", "input[name='author'], input[name='source']", function() {

                        let $append = $popupModule.find('[data-element="quotes:add,recommended"]');
                        let what = this.name;
                        formData = this.value;

                        // check what to search for and return false,
                        // if someone likes to play around and changes
                        // valid search strings
                        switch (what) {
                            case "author":
                                url = dynamicHost + "/dyn/content/search-authors";
                                break;

                            case "source":
                                url = dynamicHost + "/dyn/content/search-sources";
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

                    .on("submit", "[data-form='quotes:add,author']", function() {

                        url = dynamicHost + "/dyn/steps/quotes/quote";
                        formData = new FormData(this);

                        // check if author input s empty and return false
                        if (isEmpty(formData.get("author"))) {
                            return false;
                        }

                        $.ajax({

                            url: url,
                            data: formData,
                            method: this.method,
                            dataType: "HTML",
                            contentType: false,
                            processData: false,
                            success: (data) => {

                                if (data !== 0) {

                                    // toggle off steps and hide
                                    toggleActive([
                                        $popupModule,
                                        $steps
                                    ], false);

                                    setTimeout(() => {

                                        $popupModule.empty()
                                            .prepend(data);

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
                                }
                            },
                            error: (data) => {
                                console.error(data);
                            }
                        });
                    })

                    .on("submit", "[data-form='quotes:add,quote']", function() {

                        url = dynamicHost + "/dyn/steps/quotes/source";
                        formData = new FormData(this);

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

                                if (data !== 0) {

                                    // make popup module hide
                                    toggleActive([
                                        $popupModule,
                                        $steps
                                    ], false);

                                    setTimeout(() => {

                                        $popupModule.empty()
                                            .prepend(data);

                                        setTimeout(() => {

                                            $steps.find(".description p[here]")
                                                .html("The source is, where you heard or read about the quote");
                                            $steps.find("hellofresh p").html("<i class='ri-check-fill std'></i>");

                                            // make popup module visible
                                            toggleActive([
                                                $popupModule,
                                                $steps
                                            ], true);
                                        }, 100);
                                    }, 1000);
                                }
                            },
                            error: (data) => {
                                console.error(data);
                            }
                        });
                    })

                    .on("submit", "[data-form='quotes:add,done']", function() {

                        url = dynamicHost + "/dyn/steps/quotes/add";
                        formData = new FormData(this);

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

                                if (data !== 0) {

                                    // make popup module hide
                                    toggleActive([
                                        $popupModule,
                                        $steps
                                    ], false);

                                    setTimeout(() => {

                                        $popupModule.empty()
                                            .prepend(data);

                                        setTimeout(() => {

                                            $steps.find(".description p[here]")
                                                .html("The source is, where you heard or read about the quote");
                                            $steps.find("hellofresh p").html("<i class='ri-check-fill std'></i>");

                                            // make popup module visible
                                            toggleActive([
                                                $popupModule,
                                                $steps
                                            ], true);
                                        }, 100);
                                    }, 1000);
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
            });
        </script>

<?php

    } else {
        exit(1);
    }
} else {
    exit(0);
}

?>