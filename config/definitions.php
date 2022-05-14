<?php

define("PREROOT", dirname($_SERVER["DOCUMENT_ROOT"]));
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("TEMPLATES", $_SERVER["DOCUMENT_ROOT"] . '/app/templates');
define("DO", $_SERVER["DOCUMENT_ROOT"] . '/app/dynamics');
define("JSON_RESPONSE_FORMAT", 'Content-type: application/json');
define("NOT_FOUND", 'location: /404');
