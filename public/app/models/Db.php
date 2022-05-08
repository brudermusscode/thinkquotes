<?php

include_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/definitions.php";

class Db
{

    public function getEnvironment()
    {
        $environment = file_get_contents(PREROOT . '/config/db/environment');

        $available_environments = (array) ["dev", "test", "prod"];

        if (!in_array($environment, $available_environments))
            throw new Exception(
                "***** Unavailable environment set in /config/db/environment! ******"
            );

        return $environment;
    }

    public function connectDatabase()
    {

        # get environment
        $environment = $this->getEnvironment();

        # check current environment and get correct connection.json
        $connection_path = PREROOT . "/config/db/connection." . $environment . ".json";

        # validate file existence
        if (!file_exists($connection_path))
            throw new Exception(
                "***** Configuration-file in /config/db should match 'connection.*ENVIRONMENT*.json' ******"
            );

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
