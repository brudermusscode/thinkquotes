<?php

if (!$is_page) {
    header("location: /404");
}

?>

<div class="base-menu fullpage">

    <div class="inr disfl flCenter">

        <div class="bm text rounded <?php if ($subpage === "profile") {
                                        echo "active";
                                    } ?>" onclick="window.location.replace('/u/profile/<?php echo $user->id; ?>');">
            <p><?php echo $user->username; ?></p>
        </div>

        <div class="bm text rounded <?php if ($subpage === "favorites") {
                                        echo "active";
                                    } ?>" onclick="window.location.replace('/u/favorites/<?php echo $user->id; ?>');">
            <p>Favorites</p>
        </div>

        <?php if ($user->id === UID) { ?>

            <div class="bm text rounded <?php if ($subpage === "archive") {
                                            echo "active";
                                        } ?>" onclick="window.location.replace('/u/archive/<?php echo $user->id; ?>');">
                <p>Archive</p>
            </div>

            <div class="bm text rounded" onclick="window.open('');">
                <p>Drafts</p>
            </div>

        <?php } ?>

    </div>

</div>