<?php

require_once dirname(__DIR__) . "/config/init.php";

use Bruder\Application\Cookie;
use Bruder\Application\Server;
use Bruder\Env\Env;
use Bruder\Http\CSRF;

/**
 * The router and opengraph variables
 */
include CONFIG . '/router.php';

/**
 * Create a CSRF token.
 */
$csrf_token = CSRF::create_token();

/**
 * Sanitizes the output for non DEV environments. I don't know if
 * this actually has some good to it, but I like the look of all
 * HTML elements clutched together inside the source code.
 */
include TEMPLATE . "/global/_sanitize_html_output.php";

?>

<!DOCTYPE html>
<html lang=en>

<head>
  <meta charset="UTF-8" />
  <link rel="manifest" href="/manifest.json">
  <link rel="canonical" href="<?php echo HOME_URL . Server::get("REQUEST_URI"); ?>" />
  <link rel="home" href="<?php echo HOME_URL; ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf_token" content="<?php echo $csrf_token; ?>" />

  <!--- Title --->
  <title><?php echo $title; ?></title>

  <!--- Tell IE to render webpage for edge --->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="application-name" content="<?php echo APP_NAME; ?>">

  <?php

  /**
   * All the requirements being inside the head just as
   * JavaScript files abnd self written functionalities.
   */
  include TEMPLATE . "/global/_yield_requirements.php";

  ?>
</head>

<body toggled="true" initialized="false" mobile="false" puremode=<?php echo PUREMODE_ENABLED ? 1 : 0; ?> class="theme--cartoon<?php echo DARKMODE_ENABLED ? "-dark" : ""; ?>">

  <overlay loading-app visible="true" fl fldircol alic jucc gap=smol+>
    <div logo-icon style="opacity:0;scale:1.8;margin-top:3.2em;">
      <div fl alic jucc style=height:4.2em;width:4.2em; circled background=green>
        <i text wide color=light bold class="si-coffee"></i>
      </div>
    </div>

    <div logo-text style="opacity:0;scale:1.8;">
      <p text midplus bold><?php echo APP_NAME; ?></p>
    </div>

    <div dynamic-color dno class="dot-container">
      <div class="dot-pulse"></div>
      <div class="dot-pulse"></div>
      <div class="dot-pulse"></div>
    </div>
  </overlay>

  <?php

  /**
   * Include the header.
   */
  include TEMPLATE . "/global/_header.php"; ?>

  <?php

  echo "<main>";
  include_once $include_template;
  echo "</main>";

  ?>

  <script>
    let __body = document.body;
    let __main = document.find("main");
    let __env = "<?php echo Env::get("ENVIRONMENT") ?>";
    let __init = false;
  </script>

</body>

</html>

<?php include TEMPLATE . "/global/_yield_end.php"; ?>