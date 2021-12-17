<?php

include_once "System.php";

$sign = new Sign($pdo, $_SESSION, $_COOKIE);

class Sign extends Thinkquotes
{

    public function __construct(object $pdo, array $fromSession, array $fromCookies)
    {
        $this->pdo = $pdo;
        $this->fromSession = (object) $fromSession;
        $this->fromCookies = (object) $fromCookies;
    }

    // check login state for user
    public function isAuthed()
    {

        if (isset($this->fromCookies->TOK) && isset($this->fromCookies->SER) && !empty($this->fromSession)) {

            $cookieToken = $this->fromCookies->TOK;
            $cookieSerial = $this->fromCookies->SER;
            $sessionToken = $this->fromSession->token;
            $sessionSerial = $this->fromSession->serial;
            $sessionId = $this->fromSession->id;

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
                    return false;
                }
            } else {

                $this->logout();
                return false;
            }
        } else {

            return false;
        }
    }

    // validating email addresses
    public function validateMail(string $mail)
    {

        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    // create numeric code with custom length
    public function createCode(string $length)
    {

        $string = "0123456789";
        return substr(str_shuffle($string), 0, $length);
    }

    // create string custom length
    public function createString(string $len)
    {
        $s = bin2hex(random_bytes($len));
        return $s;
    }

    // create a session to keep user logged in
    public function createSession(object $fetch, object $serial, bool $reset = false)
    {

        if (isset($serial->token, $serial->serial, $serial->uid) && !$reset) {

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
                return ($_SESSION);
            } else {

                return false;
            }
        } else {

            // pass serial and token keys to fetch object
            $fetch->serial = $serial->serial;
            $fetch->token = $serial->token;

            // loop through fetch object and pass all keys + values
            // to $SESSION
            foreach ($fetch as $f => $k) {

                $_SESSION[$f] = $k;
            }

            return $_SESSION;
        }

        return false;
    }

    // reset sesson and get new settings
    public function resetSession()
    {

        if ($this->isAuthed()) {

            // get user data and compare
            $stmt = $this->pdo->prepare("
                SELECT *, users.id AS id 
                FROM users, users_settings 
                WHERE users.id = users_settings.uid 
                AND users.id = ?
            ");

            if ($stmt->execute([$this->fromSession->id])) {

                $serial = (object) [
                    "serial" => $this->fromCookies->SER,
                    "token" => $this->fromCookies->TOK
                ];

                // fetch actual user information
                $u = $stmt->fetch();

                // return new createSession
                return $this->createSession($u, $serial, true);
            }
        }

        return false;
    }

    // logout
    public function logout()
    {

        setcookie('TOK', '', time() - 1, "/");
        setcookie('SER', '', time() - 1, "/");

        session_destroy();
    }

    // return real estate client ip
    public static function getRemoteAddress()
    {
        if (!isset($_SERVER['REMOTE_ADDR'])) {
            return NULL;
        }

        $proxy_header = "HTTP_X_FORWARDED_FOR";
        $trusted_proxies = ["2001:db8::1", "192.168.50.1"];

        if (in_array($_SERVER['REMOTE_ADDR'], $trusted_proxies)) {

            if (array_key_exists($proxy_header, $_SERVER)) {

                $proxy_list = explode(",", $_SERVER[$proxy_header]);
                $client_ip = trim(end($proxy_list));

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
