<?php if (!$is_page) header("location: /"); ?>

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

  <link rel="shortcut icon" href="<?php echo IMAGE . '/global/new.logo.thq.png'; ?>" type="image/x-icon">

  <!-- scss -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo STYLE . '/application.min.css'; ?>" />

  <!-- js -->
  <script src="<?php echo SCRIPT . '/thirdparty/de.jquery.3.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/thirdparty/de.cookie.min.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/thirdparty/de.public.suffix.list.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/classes/Overlay.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/de.core.min.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/users/users.functions.min.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/users/users.get.min.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/quotes/quotes.get.min.js'; ?>"></script>
  <script src="<?php echo SCRIPT . '/quotes/quotes.functions.min.js'; ?>"></script>

  <!--- js > steps --->
  <?php if (LOGGED) { ?>
  <script src="<?php echo SCRIPT . '/steps/quotes.add.js'; ?>"></script>
  <?php } ?>

  <?php if (!empty($has_quotes) && $has_quotes) { ?>
  <script>
  jQuery(function() {
    let loadQuotes = function() {
      console.log("Getting quotes...");

      let $react = $('[data-load="content:quotes"]');
      let $append = $react.find(".actual");
      let $placeholder = $react.find(".quote-placeholder");
      let getData = $react.data("json");
      let page = getData[0].page;
      let subpage = getData[0].subpage;
      let order = getData[0].order;
      let limit = getData[0].limit;
      let uid = getData[0].uid;
      let url;

      switch (page) {
        case "index":
          url = dynamicHost + "/template/quotes/home/_index";
          break;
        case "profiles:index":
          url = dynamicHost + "/template/quotes/profiles/_index";
          break;
        case "profiles:favorites":
          url = dynamicHost + "/template/quotes/profiles/_favorites";
          break;
        case "profiles:drafts":
          url = dynamicHost + "/template/quotes/profiles/_drafts";
          break;
        case "profiles:archive":
          url = dynamicHost + "/template/quotes/profiles/_archive";
      }

      $.ajax({
        url: url,
        method: "POST",
        dataType: "HTML",
        data: {
          page: page,
          limit: limit,
          uid: uid
        },
        success: function(data) {
          let $errCode = parseInt(data);

          switch ($errCode) {
            case 0:
              showErrorModule("Something went wrong...");
              break;
            default:
              $append.empty();
              $append.append(data);
              $placeholder.remove();
          }
        },
        error: function() {
          showErrorModule("Something is wrong here...");
        },
      });
    };

    loadQuotes();
  });
  </script>
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
      <p class="lt isDark inr trimt">We use cookies! You can read more about it <a
          href="<?php echo $url->intern; ?>/privacy#m6" style="color:var(--colour-red);">here</a>!</p>
      <div class="align-mid-vert posabs cb-close mt4" data-action="cookie:cookies,accept">
        <span class="material-icons md-24">close</span>
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