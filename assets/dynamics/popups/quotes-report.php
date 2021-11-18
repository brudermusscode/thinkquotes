<?php

require_once "./../../../session/session.inc.php";

if (isset($_POST['qid'])) {
    if ($isLoggedIn) {

        $qid = $_POST['qid'];

?>



        <popup-module class="large pb62">

            <label class="slideUp posrel">
                <div class="inr" style="padding:24px 42px;">
                    <p class="fs24 lt ttup mr24 pt2" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                        Report this quote
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

            <?php

            $getQuote = $pdo->prepare("SELECT * FROM quotes WHERE id = ?");
            $getQuote->execute([$qid]);
            $q = $getQuote->fetch();

            ?>

            <div class="mb24 slideUp mshd-1 rd10" style="background:var(--colour-darkred);">
                <p style="color:var(--colour-light);line-height:1.4;padding:32px 48px;">
                    <?php echo $q->quote_text; ?>
                </p>
            </div>

            <form data-form="quotes,report" data-json='[{"qid":"<?php echo $qid; ?>"}]'>

                <div class="zoom-in mshd-1 rd10" style="background-color:var(--colour-dark);">

                    <div class="inr mshd-1 posrel" style="z-index:1;">

                        <?php

                        $getReportCategories = $pdo->prepare("SELECT * FROM quotes_reports_categories");
                        $getReportCategories->execute();

                        ?>

                        <p style="color:var(--colour-light);margin-bottom:8px;">Report reason</p>

                        <div data-structure="select" class="select-input mb42">
                            <div class="show-actual">
                                <p class="lt">
                                    Select a reason...
                                </p>
                                <p class="rt icon"><span class="material-icons-round md-24">arrow_drop_down</span></p>

                                <div class="cl"></div>
                            </div>

                            <dataset class="mshd-2 tran-all-cubic">

                                <input type="hidden" name="cid" value="0">

                                <ul>

                                    <?php foreach ($getReportCategories->fetchAll() as $c) { ?>

                                        <li data-set="<?php echo $c->id; ?>">
                                            <p><?php echo $c->category; ?></p>
                                        </li>

                                    <?php } ?>

                                </ul>
                            </dataset>
                        </div>


                        <div class="posrel mb24">
                            <p style="color:var(--colour-light);margin-bottom:24px;">Comment</p>
                            <textarea name="comment" placeholder="Add a comment for the report..."></textarea>
                        </div>



                    </div>

                    <div class="submit">

                        <hellofresh data-action="function:quotes,report" class="rdbottom8 wholebottom darkred">
                            <div class="c-ripple js-ripple">
                                <span class="c-ripple__circle"></span>
                            </div>
                            Report
                        </hellofresh>

                    </div>

                </div>

            </form>

        </popup-module>


<?php

    } else {
        exit('0');
    }
} else {
    exit('0');
}

?>