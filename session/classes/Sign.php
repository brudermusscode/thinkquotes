<?php

include_once "System.php";

$sign = new Sign($pdo);

class Sign extends Thinkquotes
{

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // check login state for user
    public function isAuthed()
    {

        if (isset($_COOKIE['TOK']) && isset($_COOKIE['SER']) && !empty($_SESSION)) {

            $__session = (object) $_SESSION;
            $__cookie = (object) $_COOKIE;

            $cookieToken = $__cookie->TOK;
            $cookieSerial = $__cookie->SER;
            $sessionToken = $__session->token;
            $sessionSerial = $__session->serial;
            $sessionId = $__session->id;

            // check if cookies and serial are same
            if (
                $cookieToken == $sessionToken &&
                $cookieSerial == $sessionSerial
            ) {

                // get session from database
                $getSession = $this->pdo->prepare("SELECT * FROM users_sessions WHERE uid = ? AND token = ? AND serial = ?");
                $getSession->execute([$sessionId, $sessionToken, $sessionSerial]);

                if ($getSession->rowCount() > 0) {

                    // everything's fine, user is logged in
                    return true;
                } else {
                    $this->logout();
                }
            } else {
                $this->logout();
            }
        } else {
            return false;
        }
    }

    public function validateMail(string $mail)
    {

        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    public function createCode(string $length)
    {

        $string = "0123456789";
        return substr(str_shuffle($string), 0, $length);
    }

    public function createString(string $len)
    {
        $s = bin2hex(random_bytes($len));
        return $s;
    }

    // CREATE SESSION
    public function createSession(object $fetch, object $serial)
    {

        if (isset($serial->token, $serial->serial)) {

            // insert user session
            $stmt = $this->pdo->prepare("INSERT INTO users_sessions (uid, token, serial) VALUES (?, ?, ?)");
            $stmt = $this->execute($stmt, [$serial->uid, $serial->token, $serial->serial], $this->pdo, true);

            if ($stmt->status) {

                // pass serial and token keys to fetch object
                $fetch->serial = $serial->serial;
                $fetch->token = $serial->token;

                // loop through fetch object and pass all keys + values
                // to $SESSION
                foreach ($fetch as $f => $k) {
                    $_SESSION[$f] = $k;
                }

                // set cookies to compare session serials
                setcookie('TOK', $serial->token, time() + (86400) * 30, "/");
                setcookie('SER', $serial->serial, time() + (86400) * 30, "/");

                // return objectified $SESSION
                return ((object) $_SESSION);
            } else {

                return false;
            }
        }

        return false;
    }

    // logout
    public function logout()
    {

        if (isset($_SESSION)) {

            // unset all $SESSION keys
            unset($_SESSION);

            // unset token and serial cookies
            setcookie('TOK', '', time() - 1, "/");
            setcookie('SER', '', time() - 1, "/");

            // destroy the current session
            session_destroy();
        }
    }
}
