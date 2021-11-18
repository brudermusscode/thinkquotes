<?php

if (!isset($_SESSION)) {
    session_start();
}

include_once 'mysql.inc.php';

// get system settings
$get_system_settings = $pdo->prepare("SELECT * FROM system_settings, system_urls WHERE system_urls.id = ?");
$get_system_settings->execute([$conf["environment"]]);
$system_settings = $get_system_settings->fetch();

$main = [

    // main settings
    "name" => $system_settings->name,
    "year" => $system_settings->year,
    "maintenance" => $system_settings->maintenance,
    "displayerrors" => $system_settings->displayerrors,

    // urls
    "url" => $system_settings->url,
    "maintenanceurl" => $system_settings->url_maintenance,
    "internurl" => $system_settings->url_intern,
    "mobileurl" => $system_settings->url_mobile,
    "errorurl" => $system_settings->url_error,
    "cssurl" => $system_settings->url_css,
    "scripturl" => $system_settings->url_js,
    "imageurl" => $system_settings->url_img,
    "iconurl" => $system_settings->url_icons,
    "soundurl" => $system_settings->url_sounds,
    "fulldate" => date("Y-m-d H:i:s")
];

$login = new login;
class login
{

    // CHECK LOGIN STATE
    public function isAuthed($pdo)
    {

        if (isset($_COOKIE['UID']) && isset($_COOKIE['TOK']) && isset($_COOKIE['SER']) && empty($_SESSION)) {

            $this->logout();
        } else if (isset($_COOKIE['UID']) && isset($_COOKIE['TOK']) && isset($_COOKIE['SER']) && !empty($_SESSION)) {

            $myid = $_COOKIE['UID'];
            $mytoken = $_COOKIE['TOK'];
            $myserial = $_COOKIE['SER'];

            $get_session_information = $pdo->prepare("SELECT * FROM system_sessions WHERE uid = ? AND token = ? AND serial = ?");
            $get_session_information->execute([$myid, $mytoken, $myserial]);

            // check session existence
            if ($get_session_information->rowCount() > 0) {

                $sess = $get_session_information->fetch();

                // CHECK IF COOKIES HAVE LEGIT VALUES
                if ($sess->uid == $myid && $sess->token == $mytoken && $sess->serial == $myserial) {

                    // CHECK IF ACTUAL SESSION HAS LEGIT VALUES
                    if ($sess->uid == $_SESSION['id'] && $sess->token == $_SESSION['token'] && $sess->serial == $_SESSION['serial']) {

                        // RETURN TRUE:: USER IS AUTHED!
                        return true;
                    }
                }
            } else {

                // delete all cookies
                if (isset($_SERVER['HTTP_COOKIE'])) {
                    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);

                    $i = 0;
                    $len = count($cookies);

                    foreach ($cookies as $cookie) {

                        $parts = explode('=', $cookie);
                        $name = trim($parts[0]);
                        setcookie($name, '', time() - 1000);
                        setcookie($name, '', time() - 1000, '/');

                        $i++;

                        if ($i == $len - 1) {
                            header("Refresh:0");
                        }
                    }
                }
            }
        }
    }

    // CREATE COOKIE
    public static function createCookie($id, $username, $token, $serial)
    {
        setcookie('UID', $id, time() + (86400) * 30, "/");
        setcookie('UN', $username, time() + (86400) * 30, "/");
        setcookie('TOK', $token, time() + (86400) * 30, "/");
        setcookie('SER', $serial, time() + (86400) * 30, "/");
    }

    // CREATE SESSION
    public static function createSession($id, $username, $token, $serial, $admin, $post_permissions)
    {
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['token'] = $token;
        $_SESSION['serial'] = $serial;
        $_SESSION["admin"] = $admin;
        $_SESSION["post_permissions"] = $post_permissions;
    }

    // CREATE UNIQUE STRING
    public static function createString($len)
    {
        $s = bin2hex(random_bytes($len));
        return $s;
    }

    // GET USER ID
    public static function getUID()
    {

        $login = new login;
        global $pdo;

        if ($login->isAuthed($pdo)) {
            return $_SESSION['id'];
        }
        return 0;
    }

    // logout
    public static function logout()
    {
        setcookie('UN', '', time() - 1, "/");
        setcookie('TOK', '', time() - 1, "/");
        setcookie('SER', '', time() - 1, "/");
    }

    // GET REAL IP ADDRESS
    public static function get_client_ip()
    {
        // Nothing to do without any reliable information
        if (!isset($_SERVER['REMOTE_ADDR'])) {
            return NULL;
        }

        // Header that is used by the trusted proxy to refer to
        // the original IP
        $proxy_header = "HTTP_X_FORWARDED_FOR";

        // List of all the proxies that are known to handle 'proxy_header'
        // in known, safe manner
        $trusted_proxies = ["2001:db8::1", "192.168.50.1"];

        if (in_array($_SERVER['REMOTE_ADDR'], $trusted_proxies)) {

            // Get the IP address of the client behind trusted proxy
            if (array_key_exists($proxy_header, $_SERVER)) {

                // Header can contain multiple IP-s of proxies that are passed through.
                // Only the IP added by the last proxy (last IP in the list) can be trusted.
                $proxy_list = explode(",", $_SERVER[$proxy_header]);
                $client_ip = trim(end($proxy_list));

                // Validate just in case
                if (filter_var($client_ip, FILTER_VALIDATE_IP)) {
                    return $client_ip;
                } else {
                    // Validation failed - beat the guy who configured the proxy or
                    // the guy who created the trusted proxy list?
                    // TODO: some error handling to notify about the need of punishment
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}

class user
{
}

class friends
{

    // check for friendrequests
    public static function getFriendrequests($someid)
    {

        global $pdo;

        $getRequests = $pdo->prepare("SELECT * FROM users_friends_requests WHERE got = ?");
        $getRequests->execute([$someid]);
        $rowCount = $getRequests->rowCount();

        if ($rowCount > 0) {
            return $rowCount;
        } else {
            return false;
        }
    }

    // get all friends array
    public static function getFriends($someid)
    {

        global $pdo;
        $friends = [];

        $getAllFriends = $pdo->prepare("SELECT CASE WHEN uid1 = ? THEN uid2 ELSE uid1 END AS uid FROM users_friends WHERE uid1 = ? OR uid2 = ?");
        $getAllFriends->execute([$someid, $someid, $someid]);

        foreach ($getAllFriends->fetchAll() as $gfr) {

            $friendsuid = $gfr->uid;
            $friends[] = $friendsuid;
        }

        return $friends;
    }

    // get all friends of friends
    public static function getFriendsOfFriends($someid)
    {

        global $pdo;
        $acfr = [];

        $getAllFriendsofFriends = $pdo->prepare("SELECT CASE WHEN uid1 = ? THEN uid2 ELSE uid1 END AS uid FROM users_friends WHERE uid1 = ? OR uid2 = ?");
        $getAllFriendsofFriends->execute([$someid, $someid, $someid]);

        foreach ($getAllFriendsofFriends->fetchAll() as $gfrofr) {

            $fruid = $gfrofr->uid;
            $acfr[] = $fruid;
        }

        $fr = [];
        foreach ($acfr as $friendID) {
            $getAllFriendsofFriends->execute([$friendID, $friendID, $friendID]);
            foreach ($getAllFriendsofFriends->fetchAll() as $frofr) {
                $frofruid = $frofr->uid;
                $fr[] = $frofruid;
            }
        }

        if (empty($fr)) {
            return $fr;
        } else {
            $f = array_unique($fr);
            return $f;
        }

        return null;
    }
}

$isLoggedIn = $login->isAuthed($pdo);

// USERINFORMATION
if ($isLoggedIn) {

    $sessionid = $_SESSION['id'];

    $get_user_information = $pdo->prepare("SELECT * FROM users, users_settings WHERE users.id = users_settings.uid AND users.id = ?");
    $get_user_information->execute([$sessionid]);
    $user = $get_user_information->fetch();

    $my = [

        // general userinformation
        "id" => $user->id,
        "username" => $user->uname,
        "mail" => $user->mail,
        "admin" => $user->admin,
        "permissions" => $user->post_permissions,

        // settings
        "show_profile" => $user->show_profile,
        "show_profile_favorites" => $user->show_profile_favorites,
        "send_friendrequests" => $user->send_friendrequests,

        // checked
        "check_friendrequests" => $user->check_friendrequests,
        "check_updates" => $user->check_updates
    ];
}


include_once 'functions.inc.php';
