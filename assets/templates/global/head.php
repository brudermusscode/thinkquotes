<?php

if (!$is_page) {
    header("location: /");
}

?>

<!DOCTYPE html>
<html lang=en>

<head>

    <meta charset="UTF-8" />

    <title><?php echo $main->name; ?> - Your Daily Dose of Mindfulness</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name='description' content="Your Daily Dose of Mindfulness" />
    <meta name='keywords' content="think,quotes,mindfulness,quotes" />
    <meta property="og:image" content="bee01.png" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="http://<?php echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:site_name" content="<?php echo $main->name; ?>" />
    <meta property="og:type" content="website" />

    <link rel="shortcut icon" href="<?php echo $url->img; ?>/global/new.logo.thq.png" type="image/x-icon">

    <!-- scss -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $url->css; ?>/de.normalize.css" />
    <link rel="stylesheet" href="<?php echo $url->css; ?>/de.gen.css" />
    <link rel="stylesheet" href="<?php echo $url->css; ?>/elem.quote.css" />
    <link rel="stylesheet" href="<?php echo $url->css; ?>/de.animations.css" />
    <link rel="stylesheet" href="<?php echo $url->css; ?>/de.elements.css" />
    <link rel="stylesheet" href="<?php echo $url->css; ?>/de.hdr.css" />
    <link rel="stylesheet" href="<?php echo $url->css; ?>/de.classes.css" />
    <link rel="stylesheet" href="<?php echo $url->css; ?>/de.responsiveness.css" />

    <?php if ($page === "maintenance") { ?>
        <link rel="stylesheet" href="<?php echo $url->css; ?>/de.maintenance.css" />

    <?php } else if ($page === "profiles") { ?>
        <link rel="stylesheet" href="<?php echo $url->css; ?>/de.profiles.css" />

    <?php } else if ($page === "intern") { ?>
        <link rel="stylesheet" href="<?php echo $url->css; ?>/de.intern.css" />

    <?php } ?>

    <link rel="stylesheet" href="<?php echo $url->css; ?>/sign.css" />

    <!-- js -->
    <script src="<?php echo $url->js; ?>/thirdparty/de.jquery.3.js"></script>
    <script src="<?php echo $url->js; ?>/thirdparty/de.cookie.min.js"></script>
    <script src="<?php echo $url->js; ?>/thirdparty/de.masonry.js"></script>
    <script src="<?php echo $url->js; ?>/thirdparty/de.public.suffix.list.js"></script>
    <script src="<?php echo $url->js; ?>/classes/Overlay.js"></script>
    <script src="<?php echo $url->js; ?>/de.core.min.js"></script>
    <script src="<?php echo $url->js; ?>/users/users.functions.min.js"></script>
    <script src="<?php echo $url->js; ?>/users/users.get.min.js"></script>
    <script src="<?php echo $url->js; ?>/quotes/quotes.get.min.js"></script>
    <script src="<?php echo $url->js; ?>/quotes/quotes.functions.min.js"></script>

    <!--- js > steps --->
    <?php if (LOGGED) { ?>
        <script src="<?php echo $url->js; ?>/steps/quotes.add.min.js"></script>
    <?php } ?>

</head>

<body>


    <?php if (LOGGED && ADMIN) { ?>
        <div id="adminDump" class="mshd-3">
            <div class="dump mshd-1">
                <div class="title">SESSION</div>
                <pre><?php var_dump((object) $_SESSION); ?></pre>
            </div>
            <div class="dump mshd-1">
                <div class="title">REQUEST</div>
                <pre><?php var_dump((object) $_REQUEST); ?></pre>
            </div>
            <div class="dump mshd-1">
                <div class="title">COOKIE</div>
                <pre><?php var_dump((object) $_COOKIE); ?></pre>
            </div>
            <div class="dump mshd-1">
                <div class="title">SERVER</div>
                <pre><?php var_dump((object) $_SERVER); ?></pre>
            </div>
        </div>
    <?php } ?>

    <app>

        <!-- ERROR RESPONSER -->
        <div data-structure="module:error" id="errorResponse" class="error-module">
            <div class="popper mshd-4">
                <p style="line-height:24x;color:1c1c1c;font-size:1em;font-weight:500;"></p>
            </div>
        </div>

        <script>
            $(function() {

                $(document).on("click", '[data-action="cookie:cookies,accept"]', function() {

                    Cookies.set("leckercoronabier", true, {
                        expires: 9999999
                    });

                    $t = $(this);
                    $b = $t.closest(".cookiezi-banner").css({
                        bottom: "-120px"
                    });

                });

            });
        </script>

        <?php if (!isset($_COOKIE["leckercoronabier"])) { ?>

            <div class="cookiezi-banner mshd-3">
                <p class="lt isDark inr trimt">We use cookies! Read more about it <a href="<?php echo $url->intern; ?>/privacy#m6">here</a>...</p>
                <div class="align-mid-vert posabs cb-close" data-action="cookie:cookies,accept">
                    <span class="material-icons-round md-24">close</span>
                </div>
            </div>

        <?php } ?>



        <script>
            $(function() {

                $(document).on("click", '#settings-main .settings-menu-outer ul li', function() {

                    let $t = $(this);
                    let $u = $t.parent();

                    $u.find('li').each(function() {
                        $(this).removeClass('isActive');
                    });

                    if (!$t.hasClass('isActive')) {
                        $t.addClass('isActive');
                    } else {

                    }

                });

                $(document).on("click", '.showMoreClick .clickArea', function() {

                    let $t = $(this).closest('.showMoreClick');
                    let h = $t.find('[getHeight]').innerHeight();

                    if ($t.hasClass('isOpen')) {
                        $t.removeClass('isOpen').removeAttr('style')
                    } else {
                        $t.addClass('isOpen').css({
                            height: h + "px"
                        });
                    }

                });

            });
        </script>