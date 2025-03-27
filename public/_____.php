<?php

require_once dirname($_SERVER["DOCUMENT_ROOT"]) . "/config/init.php";

header(JSON_RESPONSE);

use Bruder\Application\Application;
use Bruder\Http\Request;

// TODO: Build in CSRF protection for each request.
use Bruder\Http\CSRF;

/**
 * @var User $current_user
 */

$__RETURN = Request::hi_mom();
$__DD = Application::get_default_dialogues();
$error_url = dirname(__DIR__) . "/app/templates/errors/invalid_request.php";

/**
 * @var string CSRF Token sent with the headerts to be validated.
 */
$__CSRF_TOKEN = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

/**
 * @var boolean
 */
$app_initialized = true;

/**
 * Include all router files and the basic router confirguration.
 */
include_once CONFIG . "/router.php";

/**
 * Include opengraph elements.
 */
include_once CONFIG . "/opengraph.php";

/**
 * @var object
 */
$template_return = (object) [];

ob_start();
include_once $include_template;

$template_return->include_template = ob_get_clean();

/**
 * Set the new title.
 */
$template_return->title = $title;

exit(json_encode($template_return));
