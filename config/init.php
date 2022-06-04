<?php

# start new session
session_start();

# auto load composer libs
include $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

# require new database connection
require_once "db/connect.php";

# set dev_env to true, if current environment is development
(bool) $dev_env = false;
if ($db->getEnvironment() == 'dev') $dev_env = true;

# include all models
include_once ROOT . "/public/app/models/Thinkquotes.php";
include_once ROOT . "/public/app/models/Sign.php";
include_once ROOT . "/public/app/models/Time.php";
include_once ROOT . "/public/app/models/Collection.php";
include_once ROOT . "/public/app/models/Friends.php";
include_once ROOT . "/public/app/models/User.php";

# get system settings
# TODO: outsource into class and just call a function
$stmt = $pdo->prepare("SELECT * FROM system_settings, system_urls");
$stmt->execute();
$systemInformation = $stmt->fetch();

$main = (object) [
  "name" => $systemInformation->name,
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
  "styles" => $systemInformation->styles,
  "scripts" => $systemInformation->scripts,
  "images" => $systemInformation->images,
  "icons" => $systemInformation->icons,
  "sounds" => $systemInformation->sounds,
];

# remove by time
$sroot = ROOT;

# define things
define("LOGGED", $sign->isAuthed());
define("IMAGE", $url->images);
define("SCRIPT", $url->scripts);
define("STYLE", $url->styles);
define("SOUND", $url->sounds);
define("ICON", $url->icons);

# create dynamic return for xhr requests to manage
# output responsively
$return = (object) [
  "status" => false,
  "message" => "A wild error appeared, fight it!"
];

# add request & session data to return object for debugging
# only when dev env is inititialized
if ($dev_env) {
  $return->init = [
    "request" => $_REQUEST,
    "session" => $_SESSION
  ];
}

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

  define("ADMIN", $my->admin);
}