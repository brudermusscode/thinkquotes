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

    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="https://storage.googleapis.com/non-spec-apps/mio-icons/latest/round.css">
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

    <!-- SCRIPTS -->
    <script src="<?php echo $url->js; ?>/thirdparty/de.jquery.3.js"></script>
    <script src="<?php echo $url->js; ?>/thirdparty/de.cookie.min.js"></script>
    <script src="<?php echo $url->js; ?>/thirdparty/de.masonry.js"></script>
    <script src="<?php echo $url->js; ?>/thirdparty/de.public.suffix.list.js"></script>
    <script src="<?php echo $url->js; ?>/de.core.min.js"></script>
    <script src="<?php echo $url->js; ?>/de.useful.min.js"></script>
    <script src="<?php echo $url->js; ?>/users/users.functions.min.js"></script>
    <script src="<?php echo $url->js; ?>/users/users.get.min.js"></script>
    <script src="<?php echo $url->js; ?>/quotes/quotes.get.min.js"></script>
    <script src="<?php echo $url->js; ?>/quotes/quotes.functions.min.js"></script>

    <style>
        .spin-cubic-endless {
            animation: spin 3s infinite;
            animation-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap');
    </style>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5364145398992926" crossorigin="anonymous"></script>


</head>

<body>

    <app>

        <!-- ERROR RESPONSER -->
        <div data-structure="module:error" id="errorResponse" class="error-module">
            <div class="popper mshd-4">
                <p style="line-height:24x;color:1c1c1c;font-size:1em;font-weight:500;"></p>
            </div>
        </div>


        <style>
            .cookiezi-banner {
                bottom: 24px;
                left: 32px;
                background: var(--colour-dark);
                border-radius: 6px;
                position: fixed;
                z-index: 1000;
                display: block;
                transition: all 0.6s cubic-bezier(0.1, 0.82, 0.25, 1);
            }

            .cookiezi-banner .inr {
                padding: 0 84px 0 24px;
                line-height: 4em;
            }

            .cookiezi-banner .cb-close {
                right: 24px;
                cursor: pointer;
                color: var(--colour-light);
                opacity: .8;
                transition: all .1s linear;
            }

            .cookiezi-banner .cb-close:hover {
                opacity: .6;
            }

            .cookiezi-banner .cb-close:active {
                opacity: .4;
            }

            .cookiezi-banner a {
                color: var(--colour-red);
                transition: all .1s linear;
            }

            .cookiezi-banner a:hover {
                opacity: .8;
            }

            .cookiezi-banner a:active {
                opacity: .4;
            }
        </style>

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