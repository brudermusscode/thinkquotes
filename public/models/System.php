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
