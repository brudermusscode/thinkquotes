<?php

# start new session
session_start();

# auto load composer libs
include dirname($_SERVER['DOCUMENT_ROOT']) . "/vendor/autoload.php";

# require new database connection
require_once "db/connect.php";

# set dev_env to true, if current environment is development
(bool) $dev_env = false;
if ($db->getEnvironment() == 'dev') $dev_env = true;

# include all models
include_once ROOT . "/app/models/Thinkquotes.php";
include_once ROOT . "/app/models/Sign.php";
include_once ROOT . "/app/models/Time.php";
include_once ROOT . "/app/models/Collection.php";
include_once ROOT . "/app/models/Friends.php";
include_once ROOT . "/app/models/User.php";

# get system settings
# TODO: outsource into class and just call a function
$stmt = $pdo->prepare("SELECT * FROM system_settings, system_urls");
$stmt->execute();
$systemInformation = $stmt->fetch();

$main = (object) [

  # main settings
  "name" => $systemInformation->name,
  "year" => $systemInformation->year,
  "maintenance" => $systemInformation->maintenance,
  "displayerrors" => $systemInformation->displayerrors,
  "fulldate" => date("Y-m-d H:i:s")
];

$url = (object) [
  "main" => $systemInformation->server,
  "maintenance" => $systemInformation->maintenance,
  "intern" => $systemInformation->intern,
  "mobile" => $systemInformation->mobile,
  "error" => $systemInformation->error,
  "css" => $systemInformation->css,
  "js" => $systemInformation->js,
  "img" => $systemInformation->img,
  "icons" => $systemInformation->icons,
  "sounds" => $systemInformation->sounds,
];

# remove by time
$sroot = ROOT;

# define things
define("LOGGED", $sign->isAuthed());
define("IMAGES", $url->img);

# create dynamic return for xhr requests to manage
# output responsively
$return = (object) [
  "status" => false,
  "message" => "A wild error appeared, fight it!",
  "init" => [
    "request" => $_REQUEST,
    "session" => $_SESSION
  ]
];

# handle page behavior if maintenance is turned on
# TODO: outsource into class and just call a function
if (isset($is_page) && $is_page) {

  # check if maintenance
  if ($main->maintenance == "1") {
    if (LOGGED) {
      if ($_SESSION["admin"] == '0') {
        if ($page !== "maintenance") {
          header("Location: " . $url->maintenance);
        }
      }
    } else {
      if ($page !== "maintenance") {
        header("Location: " . $url->maintenance);
      }
    }
  } else {
    if (LOGGED) {
      if ($_SESSION["admin"] == '0') {
        if ($page === "maintenance") {
          header("Location: " . $url->main);
        }
      }
    } else {
      if ($page === "maintenance") {
        header("Location: " . $url->main);
      }
    }
  }
}

$my = (object) [
  "uid" => 0
];

if (LOGGED) {

  # reset session and get new settings
  $my = $sign->resetSession();

  # objectifcy $_SESSION and put into $my for shoter use
  $my = (object) $_SESSION;

  # define UID for short use
  # define("UID", $my->uid);
  define("ADMIN", $my->admin);
  # define("0", false);
  # define("1", true);
}
