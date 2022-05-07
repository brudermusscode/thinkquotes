<?php

$page = "maintenance";
$is_page = true;

// mysql database
require_once "../session/session.inc.php";

// Head section
include_once "../assets/templates/global/head.php";

?>



<header class="header--maintenance">

    <div class="sizing">
        <div class="logo">
            <img src="<?php echo $main["imageurl"]; ?>/global/logo.new.png" />
        </div>
    </div>

</header>

<div class="main">

    <div class="inr">
        <?php

        $getRandomQuote = $pdo->prepare("
                            SELECT * 
                            FROM quotes, quotes_authors, quotes_categories, quotes_sources
                            WHERE quotes.aid = quotes_authors.id
                            AND quotes.sid = quotes_sources.id
                            ORDER BY RAND()
                            LIMIT 1
                        ");
        $getRandomQuote->execute();

        foreach ($getRandomQuote->fetchAll() as $q) {

        ?>

            <quote>

                <div class="" style="margin-top:48px;color:var(--colour-orange);font-size:8em;">
                    <p class="tal">&ldquo;</p>
                </div>

                <div class="disbl bgf mshd-1 rd6 mb24">

                    <div style="padding:24px 42px;">

                        <div class="quote--text">
                            <p class="tac"><?php echo $q->quote_text; ?></p>
                        </div>

                    </div>

                </div>

                <div class="author">
                    <p class="tac"><?php echo $q->author_name; ?></p>
                </div>

                <div style="line-height:.05;color:var(--colour-orange);font-size:8em;">
                    <p class="tar">&bdquo;</p>
                </div>

            </quote>


        <?php

        }

        ?>



    </div>

    <div style="margin-top:124px;">
        <p class="tac" style="color:white;font-weight:800;text-shadow:0 1px 0 rgba(0,0,0,.48);">Bald verfügbar</p>
    </div>

</div>


<?php

// foot section
include_once "../assets/templates/global/footer.php";

?>