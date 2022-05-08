<?php

if (!$is_page) {
    header("location: /404");
}

?>

<div class="base-menu fullpage">

    <div class="inr disfl flCenter">

        <div class="bm text rounded <?php if ($page === "profiles:index") echo "active"; ?>" onclick="window.location.replace('/u/<?php echo $user->username; ?>');">
            <p><?php echo $user->username; ?></p>
        </div>

        <div class="bm text rounded <?php if ($page === "profiles:favorites") echo "active"; ?>" onclick="window.location.replace('/f/<?php echo $user->username; ?>');">
            <p>Favorites</p>
        </div>

        <?php if ($user->uid === UID) { ?>

            <div class="bm text rounded <?php if ($page === "profiles:archive") {
                                            echo "active";
                                        } ?>" onclick="window.location.replace('/a/<?php echo $user->username; ?>');">
                <p>Archive</p>
            </div>

            <div class="bm text rounded" onclick="window.open('');">
                <p>Drafts</p>
            </div>

        <?php } ?>

    </div>

</div>