<?php

define("PREROOT", dirname($_SERVER["DOCUMENT_ROOT"]));
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("TEMPLATES", $_SERVER["DOCUMENT_ROOT"] . '/public/app/templates');
define("FUNC", $_SERVER["DOCUMENT_ROOT"] . '/public/app/dynamics');
define("JSON_RESPONSE_FORMAT", 'Content-type: application/json');
define("NOT_FOUND", 'location: /404');
define(false, 0);
define(true, 1);