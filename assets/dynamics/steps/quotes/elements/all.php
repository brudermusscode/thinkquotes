<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

?>

<form data-form="quotes:add,all" method="POST" action>
    <div class="inr">

        <label for="popup-module" class="mb32">
            <div class="label-inr light">
                <p>Almost done!</p>
                <p style="font-size:1.2em;">That's how your quote will look!</p>
            </div>
        </label>

        <div class="input">

            <div class="pulse"></div>
            <input name="author" type="hidden" value="%author%" />
            <textarea name="quote" class="dno" value="%quote%" readonly></textarea>
            <input name="source" type="hidden" value="%source%" />
            <input name="category" type="hidden" value="%category%" />
        </div>

        <quote data-element="quote" class="slideUpSlow">

            <div data-append="overlay" class="quote--outer mshd-1">

                <style class="dno">
                    quote .quote--outer .q-inr .edit-overlay {
                        position: relative;
                    }

                    quote .quote--outer .q-inr .edit-overlay {
                        position: relative;
                    }

                    quote .quote--outer .q-inr .edit-overlay textarea {
                        resize: none;
                        width: 100%;
                        border-bottom: 1px solid rgba(0, 0, 0, .24);
                        transition: all .1s linear;
                        color: var(--colour-dark);
                        padding-bottom: 12px;
                    }

                    quote .quote--outer .q-inr .edit-overlay textarea:focus {
                        border-bottom: 1px solid var(--colour-red);
                    }
                </style>

                <div class="q-inr">
                    <div data-react="function:quotes,edit,hide">

                        <div class="author fw7 mb4">
                            <p>%author%</p>
                        </div>

                        <div class="q-text">
                            <p>%quote%</p>
                        </div>

                        <div class="q-categories">
                            <div class="category-banner lt mt4">
                                %category%
                            </div>

                            <div class="cl"></div>
                        </div>

                    </div>
                </div>

            </div>

            <div style="width:100%;height:1.4em;visibility:hidden;"></div>
        </quote>

    </div>
</form>

<script class="dno">
    $(() => {

    });
</script>