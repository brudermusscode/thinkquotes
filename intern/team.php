<?php

$is_page = true;
$page = "intern";
$subPage = "intern:team";
$pageTitle = "Team of Development";

// mysql database
require_once $_SERVER['DOCUMENT_ROOT'] . "/session/session.inc.php";

// Head section
include_once $sroot . "/assets/templates/global/head.php";
include_once $sroot . "/assets/templates/global/header.php";

?>

<div id="main" class="wpx--main intern fullpage">

    <?php include_once "../assets/templates/intern/header.tools.php"; ?>

    <div class="intern--outer updates">

        <div class="lt-content posrel">

            <create-grid class="mb32">
                <div class="inr grid">

                    <?php

                    $getInternTeamMembers = $pdo->prepare("
                        SELECT * 
                        FROM intern_team_members, intern_team_ranks, users 
                        WHERE intern_team_members.rid = intern_team_ranks.id 
                        AND intern_team_members.uid = users.id 
                        ORDER BY intern_team_members.id
                    ");
                    $getInternTeamMembers->execute();

                    foreach ($getInternTeamMembers as $member) {

                    ?>

                        <div class="grid--outer">

                            <div class="rank-card green">
                                <div class="rc-inr">
                                    <div class="top-section">
                                        <div class="icon">
                                            <span class="material-icons-round md-32"><?php echo $member->icon; ?></span>
                                        </div>
                                        <div class="image-outer">
                                            <div class="actual" style="background-image:url(<?php echo $url->img; ?>/<?php echo $member->image; ?>);">
                                                <img src="">
                                            </div>
                                        </div>

                                        <div class="cl"></div>
                                    </div>

                                    <div class="bottom-section mt28">
                                        <div class="rankname">
                                            <p><?php echo $member->rank_name; ?></p>
                                        </div>
                                        <div class="username">
                                            <p class="ttup"><?php echo $member->uname; ?></p>
                                        </div>
                                    </div>

                                </div>


                                <?php

                                $getInternTeamSocials = $pdo->prepare("
                                    SELECT * 
                                    FROM intern_team_members_social, intern_team_members_social_added
                                    WHERE intern_team_members_social_added.sid = intern_team_members_social.id 
                                    AND intern_team_members_social_added.uid = ? 
                                    ORDER BY intern_team_members_social.id
                                ");
                                $getInternTeamSocials->execute([$member->uid]);

                                if ($getInternTeamSocials->rowCount() > 0) {

                                ?>

                                    <div class="social-media mt12">


                                        <?php foreach ($getInternTeamSocials as $social) { ?>

                                            <a href="<?php if ($social->base_url !== "") echo $social->base_url . "/" . $social->url;
                                                        else echo $social->url; ?>" target="_blank">
                                                <div class="a">
                                                    <p class="posrel lt mr12 mshd-1" style="color:white;background:<?php echo $social->icon_color; ?>;border-radius:50%;height:32px;width:32px;">
                                                        <span class="posabs alignmiddle material-icons-round md-24"><?php echo $social->icon; ?></span>
                                                    </p>
                                                    <p class="lt trimt mt6 posrel" style="width:calc(100% - 48px);"><?php echo $social->title; ?></p>
                                                </div>

                                                <div class="cl"></div>
                                            </a>

                                        <?php } ?>

                                    </div>

                                <?php } ?>

                            </div>

                            <div style="width:100%;height:1.4em;visibility:hidden;"></div>
                        </div>
                    <?php } ?>

                    <div class="cl"></div>

                </div>
            </create-grid>

        </div>
    </div>
</div>


<?php include_once $sroot . "/assets/templates/global/footer.php"; ?>