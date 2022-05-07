<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

# auto load composer libs
include dirname($_SERVER['DOCUMENT_ROOT']) . "/vendor/autoload.php";

$system = new Thinkquotes;

class Thinkquotes
{

    public static function execute($stmt, $params, $connection, $commit = false)
    {

        // check if passed $params is of array type
        if (!is_array($params)) {
            $params = [$params];
        }

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
            if ($commit) {
                $connection->commit();
            }

            // return the object back to the script
            return $return;
        } catch (\PDOException $e) {

            // catch error information
            $return = (object) [
                "exception" => $e,
                "status" => false,
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];

            // rollback data and return error information
            if ($commit) {
                $connection->rollback();
            }

            return $return;
        }

        return false;
    }

    public static function trySendMail($address, $subject, $body, $header)
    {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'user@example.com'; // SMTP username
            $mail->Password = 'secret'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
            $mail->Port = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            // Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($address); // Add a recipient
            # $mail->addAddress('ellen@example.com', 'Hans Peter');
            # $mail->addReplyTo('info@example.com', 'Information');
            # $mail->addCC('cc@example.com');
            # $mail->addBCC('bcc@example.com');

            // Attachments
            # $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            # $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = $body;
            # $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            return true;
        } catch (Exception $e) {

            $errorInformation = [
                "status" => false,
                "code" => $e->getCode(),
                "message" => $e->getMessage(),
                "response" => $mail->ErrorInfo
            ];

            return $errorInformation;
        }
    }

    # converts a simple function into an prepared update statement using
    # PDO, taking in commitment true/false, returning the statements object
    public static function update($connection, $query, $variable_array, $commit = false)
    {
        # ❤️
        (object) $connection;
        (string) $query;
        (array) $variable_array;
        (bool) $commit;

        # validate given parameters by their type and return an amk, if one mismatches
        if (!is_array($variable_array)) self::amk('Given Variables have to be of type (array)');
        if (!is_string($query)) self::amk('Queries have to be of type (string)');
        if (!is_bool($commit)) self::amk("Commit value has to be of type (bool)");

        # set up new query for updating one or more records
        $stmt = $connection->prepare($query);

        // ? is using self:: the right way to execute the function?
        $stmt = self::execute($stmt, $variable_array, $connection, $commit);

        # validate trueness of given query and return, if it's false
        if (!$stmt) return;

        # otherwise return the statement's response object
        return (object) $stmt;
    }

    # converts a simple function into an select statement and returnign an object
    # with PDO query functions and records, if any
    public static function select($connection, $query, $variable_array = null)
    {
        # ❤️
        (object) $connection;
        (string) $query;
        (array) $variable_array;

        # setup new select statement and execute it
        $stmt = $connection->prepare($query);
        $stmt->execute($variable_array);

        # guard clause the output of execution. Instantly return out if it's false
        if (!$stmt) return;

        # fetch records
        $fetch = $stmt->fetch();

        # build new object to work with later
        $stmt_return = (object) [
            "stmt" => $stmt,
            "fetch" => $fetch
        ];

        # return the object
        return $stmt_return;
    }

    # just throw new errors with a certain message abbreviated
    public static function amk($message)
    {
        throw new Exception($message);
    }
}
