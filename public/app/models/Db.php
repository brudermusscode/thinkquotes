<?php

include_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/definitions.php";

class Db
{

    // constructor function which will only get the input
    // file which includes the data for connecting to the
    // database.
    // ! Must be JSON format
    public function __construct()
    {
    }

    public function connectDatabase()
    {

        # get environment
        $environment = file_get_contents(PREROOT . '/config/db/environment');

        # check current environment and get correct connection.json
        if ($environment == 'dev') {
            $connection_path = PREROOT . "/config/db/connection.dev.json";
        } else {
            $connection_path = PREROOT . "/config/db/connection.prod.json";
        }

        // get login infromation from outsourced file
        $PDOconfiguration = (object) $this->convertFromFile($connection_path)->connect;

        // try catch database connection
        try {

            // set up dns string
            $dsn = 'mysql:host=' . $PDOconfiguration->host . ';dbname=' . $PDOconfiguration->db . ';charset=' . $PDOconfiguration->charset;

            // create a new database connection using the dns string
            $pdo = new PDO($dsn, $PDOconfiguration->user, $PDOconfiguration->pass);

            // preset attributes
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // set default date and timezone for php
            date_default_timezone_set('Europe/Berlin');

            // define things ez pz lemono squeezio
            define("SROOT", $_SERVER["DOCUMENT_ROOT"]);

            // return the database connection and the information
            // which were used to connect to the database, so we
            // later can access the right environment settings
            $return = (object) [
                "connection" => $pdo,
                "configuration" => $PDOconfiguration
            ];

            // return it
            return $return;
        } catch (PDOException $e) {

            // Bruder, irgendwas lief schief alder
            return "Bruder: " . $e->getMessage();
        }
    }

    // get information from json file
    public function getJSONFromFile(string $file)
    {
        $JSONData = file_get_contents($file);
        $JSONData = json_decode($JSONData);

        // return data from file as json
        return $JSONData;
    }

    public function convertFromFile(string $file)
    {
        // use getFromFile function to return from file values
        $fileData = $this->getJSONFromFile($file);

        // return them
        return (object) $fileData;
    }
}
