<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;

# auto load composer libs
include dirname($_SERVER['DOCUMENT_ROOT']) . "/vendor/autoload.php";

$system = new Thinkquotes;

class Thinkquotes
{

    public static function execute(object $stmt, array $params, object $connection, bool $commit = false)
    {

        (object) $stmt;
        (array) $params;
        (object) $connection;
        (bool) $commit;

        try {

            // try executing the statement
            $stmt->execute($params);

            // store error information
            $return = (object) [
                "status" => true,
                "commit" => $commit,
                "rows" => $stmt->rowCount(),
                "lastInsertId" => $connection->lastInsertId()
            ];

            // commit changes if true
            if ($commit) $connection->commit();

            // return the object back to the script
            return $return;
        } catch (\PDOException $e) {

            // rollback data and return error information
            if ($commit) $connection->rollback();

            // catch error information
            $return = (object) [
                "status" => false,
                "exception" => $e,
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];

            return $return;
        }

        return false;
    }

    public static function insert(object $connection, string $query, array $params, bool $commit = false)
    {
        (object) $connection;
        (string) $query;
        (array) $params;
        (bool) $commit;

        try {

            # validate given parameters' types
            if (!is_string($query)) self::amk('Query has to be of type (string)');
            if (!is_array($params)) self::amk('Given query parameters have to be of type (array)');
            if (!is_bool($commit)) self::amk("Commit value has to be of type (bool)");

            $stmt = $connection->prepare($query);
            $stmt = self::execute($stmt, $params, $connection, $commit);

            // commit changes if true
            if ($commit) $connection->commit();

            // store error information
            $return = (object) [
                "status" => true,
                "commit" => $commit,
                "stmt" => $stmt,
                "connection" => $connection
            ];

            // return the object back to the script
            return $return;
        } catch (\PDOException $e) {

            // rollback data and return error information
            if ($commit) $connection->rollback();

            // catch error information
            $return = (object) [
                "status" => false,
                "exception" => $e,
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];

            return $return;
        }

        return false;
    }

    # converts a simple function into an prepared update statement using
    # PDO, taking in commitment true/false, returning the statements object
    public static function update(object $connection, string $query, array $params, bool $commit = false)
    {

        (object) $connection;
        (string) $query;
        (array) $params;
        (bool) $commit;

        # validate given parameters by their type and return an amk, if one mismatches
        if (!is_array($params)) self::amk('Given Variables have to be of type (array)');
        if (!is_string($query)) self::amk('Queries have to be of type (string)');
        if (!is_bool($commit)) self::amk("Commit value has to be of type (bool)");

        try {

            # set up new query for updating one or more records
            $stmt = $connection->prepare($query);
            $stmt = self::execute($stmt, $params, $connection, $commit);

            # validate trueness of given query and return false, if it is
            if (!$stmt) return false;

            # otherwise return the statement's response object
            return (object) $stmt;
        } catch (\PDOException $e) {

            if ($commit) $connection->rollback();

            // catch error information
            $return = (object) [
                "status" => false,
                "exception" => $e,
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];

            return $return;
        }

        return false;
    }

    # converts a simple function into an select statement and returns an object
    # with PDO query functions and records, if any
    public static function select($connection, $query, $params = null, $fetch_all = false)
    {

        (object) $connection;
        (string) $query;
        (array) $params;

        try {

            $stmt = $connection->prepare($query);
            $stmt->execute($params);

            # fetch records
            if ($fetch_all) {
                $fetch = $stmt->fetchAll();
            } else {
                $fetch = $stmt->fetch();
            }

            $stmt_return = (object) [
                "status" => true,
                "stmt" => $stmt,
                "fetch" => $fetch
            ];

            # return the object
            return $stmt_return;
        } catch (\PDOException $e) {

            // catch error information
            $return = (object) [
                "status" => false,
                "exception" => $e,
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];

            return $return;
        }

        return false;
    }

    public static function trySendMail($address, $subject, $body, $web_information)
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        // SMTP needs accurate times, and the PHP time zone MUST be set
        // This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('Etc/UTC');

        // Server settings
        $mail->isSMTP(); // Send using SMTP
        # $mail->SMTPDebug = PHPMailer::SMTP::DEBUG_SERVER;
        $mail->Host = 'w01c33b1.kasserver.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = 'test@thinkquotes.eu';
        $mail->Password = 'secret123';
        // $mail->AuthType = 'XOAUTH2';

        // Create and pass GoogleOauthClient to PHPMailer
        // $oauthTokenProvider = new \GoogleOauthClient(
        //     'someone@gmail.com',
        //     'path/to/gmail-xoauth2-credentials.json',
        //     'path/to/gmail-xoauth-token.json'
        // );
        // $mail->setOAuth($oauthTokenProvider);

        // Recipients
        $mail->setFrom('noreply@thinkquotes.de', $web_information->name);
        $mail->addAddress($address);

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->Subject = $subject;
        $mail->Body = $body;
        # $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        try {

            $mail->send();

            return true;
        } catch (Exception $e) {

            $errorInformation = (object) [
                "status" => false,
                "code" => $e->getCode(),
                "message" => $e->getMessage(),
                "response" => $mail->ErrorInfo
            ];

            return $errorInformation;
        }
    }

    # just throw new errors with a certain message abbreviated
    public static function amk($message)
    {
        throw new Exception($message);
    }
}
