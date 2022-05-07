<?php

class Db
{

    public string $inputfile;

    // constructor function which will only get the input
    // file which includes the data for connecting to the
    // database.
    // ! Must be JSON format
    public function __construct(string $inputfile)
    {
        $this->inputfile = $inputfile;
    }

    public function connectDatabase()
    {
        // get login infromation from outsourced file
        $PDOconfiguration = (object) $this->convertFromFile($this->inputfile)->connect;

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

    // check current environment for local or web
    // public function isLocalhost()
    // {

    //     $whitelist = [
    //         '127.0.0.1',
    //         '::1'
    //     ];

    // check if the server is in the array
    //     if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {

    // this is a local environment
    //         return true;
    //     }

    //     return false;
    // }

    // get information from json file
    public function getJSONFromFile()
    {
        $f = $this->inputfile;
        $JSONData = file_get_contents($f);
        $JSONData = json_decode($JSONData);

        // return data from file as json
        return $JSONData;
    }

    public function convertFromFile()
    {
        // use getFromFile function to return from file values
        $fileData = $this->getJSONFromFile($this->inputfile);

        // return them
        return (object) $fileData;
    }
}
