<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST)) {
    if ($isLoggedIn) {
        if ($my->permissions != "none") {

?>

            <style class="dno">
                [data-react="function:type,search"] .search-type--sizing>div {
                    padding: 0 24px;
                    background: transparent;
                    transition: all .1s linear;
                    cursor: pointer;
                    line-height: 2em;
                }

                [data-react="function:type,search"] .search-type--sizing>div:hover {
                    background: rgba(230, 129, 251, .24);
                }

                [data-react="function:type,search"] .search-type--sizing>div:active {
                    background: rgba(230, 129, 251, .48);
                }

                [data-react="function:type,search"] {
                    visibility: hidden;
                    height: 0px;
                    opacity: 0;
                    border-radius: 0 0 6px 6px;
                    top: 3.1em;
                    left: 0;
                    background: white;
                    transition: all .6s cubic-bezier(.1, .82, .25, 1);
                    overflow: hidden;
                    z-index: 3;
                }

                [data-react="function:type,search"].active {
                    visibility: visible;
                    opacity: 1;
                }
            </style>


            <popup-module class="large pb62">

                <label class="slideUp posrel">
                    <div class="inr" style="padding:24px 42px;">
                        <p class="fs24 lt ttup" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                            Add a quote
                        </p>

                        <div data-action="popup:close" class="close dark posabs align-mid-vert" style="right:32px;line-height:1;">
                            <p class="posabs alignmiddle"><span class="material-icons-round md24">close</span></p>
                        </div>

                        <div class="cl"></div>
                    </div>
                </label>

                <div class="zoom-in popup-shd rd10" style="background-color:var(--colour-dark);">

                    <div class="inr mshd-1 posrel" style="z-index:1;">

                        <form data-form="quotes,add">

                            <div class="posrel mb24">
                                <p style="color:var(--colour-light);margin-bottom:8px;">Quote</p>
                                <textarea name="quote" placeholder="What did the author say?"></textarea>
                            </div>

                            <div class="dual--input disfl fldirrow posrel mb24">
                                <div class="input posrel" traveluntilheremyboy>
                                    <p style="color:var(--colour-light);">Author</p>
                                    <div class="posrel">
                                        <input autocomplete="off" data-ontype="function:type,search" data-json='[{"what":"quotes_authors"}]' type="text" name="author" placeholder="Who said it?">

                                        <div data-react="function:type,search" class="posabs w100 mshd-2">
                                            <div class="search-type--sizing" style="padding:12px 0;">
                                                <!-- ADD REACT CONTENT -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input posrel" traveluntilheremyboy>
                                    <p style="color:var(--colour-light);">Source</p>
                                    <div class="posrel">
                                        <input autocomplete="off" data-ontype="function:type,search" data-json='[{"what":"quotes_sources"}]' class="w100" type="text" name="source" placeholder="Where did you read or hear it?">

                                        <div data-react="function:type,search" class="posabs w100 mshd-2">
                                            <div class="search-type--sizing" style="padding:12px 0;">
                                                <!-- ADD REACT CONTENT -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mb12">

                                <div class="input disfl fldirrow">
                                    <p style="color:var(--colour-light);">Category/Topic</p>
                                    <div class="rd6 ml12" style="background:var(--colour-light);color:var(--colour-dark);font-size:.8em;padding:0 8px;line-height:1.8;">
                                        <p>Multiple input</p>
                                    </div>
                                </div>

                                <div data-react="function:quotes,categories,add">

                                    <div class="cl"></div>
                                </div>

                                <div class="input posrel" traveluntilheremyboy>
                                    <input autocomplete="off" data-ontype="function:type,search" data-json='[{"what":"quotes_categories"}]' value="" data-action="function:quotes,categories,add" class="w100" type="text" placeholder="What's it about?">

                                    <div data-react="function:type,search" class="posabs w100 mshd-2">
                                        <div class="search-type--sizing" style="padding:12px 0;">
                                            <!-- ADD REACT CONTENT -->
                                        </div>
                                    </div>
                                </div>

                                <div class="mt8">
                                    <div style="font-size:.8em;font-weight:300;color:var(--colour-light);opacity:.42;">
                                        <p class="lt">Press&nbsp;</p>
                                        <p class="lt rd6" style="background:var(--colour-light);color:var(--colour-dark);padding:0 8px;line-height:1.6;margin-top:2px;">Enter</p>
                                        <p class="lt">&nbsp;/&nbsp;</p>
                                        <p class="lt rd6" style="background:var(--colour-light);color:var(--colour-dark);padding:0 8px;line-height:1.6;margin-top:2px;">Space</p>
                                        <p class="lt">&nbsp;to add topics</p>

                                        <div class="cl"></div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>

                    <div class="submit">

                        <hellofresh data-action="function:quotes,add" class="rdbottom8 wholebottom green">
                            Add quote!
                        </hellofresh>

                    </div>

                </div>

            </popup-module>


<?php

        } else {
            exit('1');
        } // No permissions
    } else {
        exit('0');
    }
} else {
    exit('0');
}

?>