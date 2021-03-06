<?php if (!$is_page) header(NOT_FOUND); ?>

<div class="base-menu fullpage">

    <div class="inr disfl flCenter">

        <div class="bm text rounded <?php if ($page === "profiles:index") echo "active"; ?>" onclick="window.location.replace('/u/<?php echo $user->username; ?>');">
            <p><?php echo $user->username; ?></p>
        </div>

        <div class="bm text rounded <?php if ($page === "profiles:favorites") echo "active"; ?>" onclick="window.location.replace('/f/<?php echo $user->username; ?>');">
            <p>Favorites</p>
        </div>

        <?php if ($user->uid === $my->uid) { ?>

            <div class="bm text rounded <?php if ($page === "profiles:drafts") {
                                            echo "active";
                                        } ?>" onclick="window.location.replace('/d/<?php echo $user->username; ?>');">
                <p>Drafts</p>
            </div>

            <div class="bm text rounded <?php if ($page === "profiles:archive") {
                                            echo "active";
                                        } ?>" onclick="window.location.replace('/a/<?php echo $user->username; ?>');">
                <p>Archive</p>
            </div>

        <?php } ?>

    </div>

</div>