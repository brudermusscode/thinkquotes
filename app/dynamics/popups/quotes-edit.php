<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (
    isset($_POST["qid"])
    && $_POST["qid"] != ""
    && $isLoggedIn
) {

    $qid = $_POST["qid"];
    $guid = $my->id;

    // check quotes existence
    $getQuote = $pdo->prepare("
        SELECT *, 
        quotes.id AS qid, 
        users.id AS uid, 
        quotes_authors.id AS aid,  
        quotes_sources.id AS sid  
        FROM quotes, users, quotes_authors, quotes_sources 
        WHERE quotes.uid = users.id
        AND quotes.aid = quotes_authors.id 
        AND quotes.sid = quotes_sources.id 
        AND quotes.id = ?
        AND quotes.uid = ?
    ");
    $getQuote->execute([$qid, $guid]);

    if ($getQuote->rowCount() > 0) {

        $q = $getQuote->fetch();

?>


        <popup-module class="large pb62">

            <label class="slideUp posrel">
                <div class="inr" style="padding:24px 42px;">
                    <p class="fs24 lt ttup mr24 pt2" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                        Edit quote
                    </p>

                    <p class="mshd-1 lt rd4" style="line-height:2em;background:var(--colour-light);color:var(--colour-dark);font-size:1em;padding:0 12px;">
                        ID: <?php echo $qid; ?>
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

                        <input type="hidden" name="qid" value="<?php echo $q->qid; ?>">

                        <div class="posrel mb24">
                            <p style="color:var(--colour-light);margin-bottom:8px;">Quote</p>
                            <textarea name="quote" placeholder="What did the author say?"><?php echo $q->quote_text; ?></textarea>
                        </div>

                        <div class="dual--input disfl fldirrow posrel mb24">
                            <div class="input posrel" traveluntilheremyboy>
                                <p style="color:var(--colour-light);">Author</p>
                                <div class="posrel">
                                    <input autocomplete="off" value="<?php echo $q->author_name; ?>" data-ontype="function:type,search" data-json='[{"what":"quotes_authors"}]' type="text" name="author" placeholder="Who said it?">

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
                                    <input autocomplete="off" value="<?php echo $q->source_name; ?>" data-ontype="function:type,search" data-json='[{"what":"quotes_sources"}]' class="w100" type="text" name="source" placeholder="Where did you read or hear it?">

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
                                <?php

                                // get categories
                                $getCategories = $pdo->prepare("
                                    SELECT * 
                                    FROM quotes_categories_used, quotes_categories 
                                    WHERE quotes_categories_used.cid = quotes_categories.id
                                    AND quotes_categories_used.qid = ?
                                    ORDER BY quotes_categories_used.id
                                ");
                                $getCategories->execute([$q->qid]);

                                foreach ($getCategories->fetchAll() as $cat) {
                                ?>
                                    <div class="category-banner zoom-in mt8 lt" data-value="<?php echo $cat->category_name; ?>" style="background:var(--colour-light);">
                                        <?php echo $cat->category_name; ?> <span data-action="function:quotes,categories,remove" class="category-delete material-icons-round md-18 rt">close</span>
                                    </div>
                                <?php } ?>

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

                    <hellofresh data-action="function:quotes,edit" class="rdbottom8 wholebottom green">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        Request edit
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

?>