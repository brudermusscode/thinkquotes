<?php

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
        try {

            if (mail($address, $subject, $body, $header)) {

                return true;
            }
        } catch (PDOException $e) {

            $errorInformation = [
                "status" => false,
                "code" => $e->getCode(),
                "message" => $e->getMessage()
            ];

            return $errorInformation;
        }

        return false;
    }
}
