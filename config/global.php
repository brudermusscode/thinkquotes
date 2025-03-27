<?php

use Bruder\Env\Env;

return [
  "database" => [
    "default" => [
      'driver' => 'mysql',
      'host' => Env::get("MYSQL_HOST"),
      'port' => Env::get("MYSQL_PORT"),
      'database' => Env::get("MYSQL_DATABASE"),
      'username' => Env::get("MYSQL_USER"),
      'password' => Env::get("MYSQL_PASSWORD"),
      'charset' => Env::get("MYSQL_CHARSET"),
      'collation' => Env::get("MYSQL_COLLATION"),
      'prefix' => '',
    ],

    "CLI" => [
      'driver' => 'mysql',
      'host' => Env::get("MYSQL_HOST_CLI"),
      'port' => Env::get("MYSQL_PORT"),
      'database' => Env::get("MYSQL_DATABASE"),
      'username' => Env::get("MYSQL_USER"),
      'password' => Env::get("MYSQL_PASSWORD"),
      'charset' => Env::get("MYSQL_CHARSET"),
      'collation' => Env::get("MYSQL_COLLATION"),
      'prefix' => '',
    ],
  ],
];
