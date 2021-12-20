<?php

$is_page = true;
$page = "intern";
$subPage = "intern:updates";
$pageTitle = "Updates";

// mysql database
require_once "../session/session.inc.php";

// Head section
include_once "../assets/templates/global/head.php";
include_once "../assets/templates/global/header.php";

?>

<div id="main" class="wpx--main intern fullpage">

    <?php include_once "../assets/templates/intern/header.tools.php"; ?>

    <div class="intern--outer updates">

        <div class="lt-content posrel">

            <div class="timeline-start-dot align-mid-horiz" style="border-radius: 50%;background: var(--colour-light);border: 10px solid var(--colour-lila);position: absolute;top:-1em;height: 42px;width: 42px;"></div>

            <div class="whole-line updates posabs align-mid-horiz"></div>

            <?php

            // get updates
            $getUpdates = $pdo->prepare("SELECT *, system_updates.id AS suid, system_updates.timestamp AS systs FROM system_updates,users WHERE system_updates.uid = users.id
            ORDER BY suid
            DESC");
            $getUpdates->execute();

            foreach ($getUpdates->fetchAll() as $u) {

                $timeAgoObject = new convertToAgo;
                $when = $timeAgoObject->timeago($u->systs);

            ?>

                <update>

                    <div class="aligning">

                        <div class="timeline-dot"></div>

                        <div class="timestamp-small">
                            <div class="timestamp-inr">

                                <div class="timestamp-text">
                                    <p><?php echo $when; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="timestamp">

                            <div style="border-radius:12px;background:var(--colour-red);">
                                <div class="timestamp-inr">

                                    <div class="timestamp-text">
                                        <div class="username"><?php echo $u->username; ?></div>
                                        <p style="color:var(--colour-light);"><?php echo $when; ?></p>
                                    </div>

                                    <div class="dev-icon">
                                        <div class="image-outer">
                                            <div class="actual" style="background:url(<?php echo $url->img; ?>/team/2FA27933-D484-40D5-B12E-4A454A4EF86B.JPG) center top / cover no-repeat;">
                                                <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $url->img; ?>/team/2FA27933-D484-40D5-B12E-4A454A4EF86B.JPG">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="cl"></div>
                                </div>
                            </div>

                        </div>

                        <div class="normal-box small-margin updates" id="m1">
                            <div class="nb-inr posrel" style="z-index:1;">

                                <div class="update-text">

                                    <div class="user-date">
                                        <div class="username">
                                            <p><?php echo $u->uname; ?></p>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text"><?php echo $u->update_text; ?></div>
                                    </div>

                                    <div class="cl"></div>
                                </div>

                                <div class="images">
                                    <?php

                                    // get updates
                                    $getUpdatesImages = $pdo->prepare("SELECT * FROM system_updates_images WHERE suid = ? ORDER BY id DESC");
                                    $getUpdatesImages->execute([$u->suid]);

                                    foreach ($getUpdatesImages->fetchAll() as $uimg) {

                                    ?>
                                        <div class="image-outer">
                                            <div class="image-inr" style="background:url(<?php echo $url->img; ?>/updates/<?php echo $uimg->image; ?>) center top / cover no-repeat;">
                                                <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $url->img; ?>/updates/<?php echo $uimg->image; ?>">
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="cl"></div>
                </update>

            <?php } ?>

        </div>
    </div>
</div>


<?php include_once "../assets/templates/global/footer.php"; ?>