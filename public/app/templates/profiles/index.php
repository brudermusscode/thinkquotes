<?php

$is_page = true;
$page = "profiles";

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

# check for valid getting username
if (empty($_GET['username'])) header('location: /404');
if (!preg_match("/^[a-zA-Z0-9_\-]+$/", $_GET['username'])) header('location: /404');

# variablize the username
(string) $username = $_GET['username'];

# select current user for profile
$query = "SELECT * FROM users WHERE BINARY username = ?";
$get_user = $system->select($pdo, $query, [$username], false);

# validate user exists
if ($get_user->stmt->rowCount() < 1) header('location: /404');

$user = $get_user->fetch;

# friends
$fr = $friends->getFriends($user->id);
$frofr = $friends->getFriendsOfFriends($user->id);

# Head section
include_once TEMPLATES . "/global/head.php";
include_once TEMPLATES . "/global/header.php";

# * insert banner
include_once TEMPLATES . "/profiles/_banner.php";

# * insert menu
include_once TEMPLATES . "/profiles/_menu.php";

?>

<div id="main" class="wpx--main">

    <div class="mt24"></div>

    <label for="quotes" class="posrel mb24">
        <div class="label-inr">
            <p class="ttup">

                <?php

                if (LOGGED && $user->id == UID) {
                    echo "Quotes you posted";
                } else {
                    echo "Quotes by $user->username";
                }

                ?>

            </p>
            <p class="ttup mr18">
                <i class="ri-arrow-down-s-line std"></i>
            </p>
        </div>
    </label>

    <create-grid class="mb32" data-load="content:quotes" data-json='[{"page":"profiles:index","limit":"20","uid":"<?php echo $user->id; ?>"}]'>
        <div class="actual"></div>
        <?php include_once TEMPLATES . "/quotes/_loading.php"; ?>
    </create-grid>

</div>

<?php

# foot section
include_once TEMPLATES . "/global/footer.php";

?>