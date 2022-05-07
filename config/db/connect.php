<?php

// start new session
session_start();

$my = (object) [];

// get database connection class
include_once "../app/models/Db.php";

// setup database connection while using JSON file
// which has been outsourced for security reasons
// don't know if that is good style or not, but
// it seems to work pretty well
$db = new Db("connection.json");
$db = $Db->connectDatabase();

// store connection data in $pdo
$pdo = $db->connection;

// store data that were used to connect to the database
// in $pdoConnectionData
$pdoConnectionData = $db->configuration;

// check if connection has been set, if not return
// the error generated by the connection function
if (!$pdo) {
    echo $pdo;
}

// get system settings
// TODO: outsource into class and just call a function
$stmt = $pdo->prepare("SELECT * FROM system_settings, system_urls WHERE system_urls.id = ?");
$stmt->execute([$pdoConnectionData->environment]);
$systemInformation = $stmt->fetch();

$main = (object) [

    // main settings
    "name" => $systemInformation->name,
    "year" => $systemInformation->year,
    "maintenance" => $systemInformation->maintenance,
    "displayerrors" => $systemInformation->displayerrors,
    "fulldate" => date("Y-m-d H:i:s")
];

$url = (object) [
    "main" => $systemInformation->url,
    "maintenance" => $systemInformation->url_maintenance,
    "intern" => $systemInformation->url_intern,
    "mobile" => $systemInformation->url_mobile,
    "error" => $systemInformation->url_error,
    "css" => $systemInformation->url_css,
    "js" => $systemInformation->url_js,
    "img" => $systemInformation->url_img,
    "icons" => $systemInformation->url_icons,
    "sounds" => $systemInformation->url_sounds,
];

$sendMail = (object) [
    "header"  => 'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=utf-8' . "\r\n" .
        'From: ThinkQuotes <noreply@thinkquotes.de>' . "\r\n"
];

// include objects/classes
include_once "classes/System.php";
include_once "classes/Sign.php";
include_once "classes/Time.php";
include_once "classes/Collection.php";
include_once "classes/Friends.php";
include_once "classes/User.php";

// shorten
$sroot = $_SERVER['DOCUMENT_ROOT'];

// define things
define("LOGGED", $sign->isAuthed());

// create dynamic return for xhr requests to manage
// output responsively
$return = (object) [
    "status" => false,
    "message" => "A wild error appeared, fight it!",
    "REQUEST" => $_REQUEST,
    "SESSION" => $_SESSION
];

// handle page behavior if maintenance is turned on
// TODO: outsource into class and just call a function
if (isset($is_page) && $is_page) {

    // check if maintenance
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

if (LOGGED) {

    // reset session and get new settings
    $my = $sign->resetSession();

    // objectifcy $_SESSION and put into $my for shoter use
    $my = (object) $_SESSION;

    // define UID for short use
    define("UID", $my->uid);
    define("ADMIN", $my->admin);
    define("0", false);
    define("1", true);
}
