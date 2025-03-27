<?php

/**
 * The template variable contains the current template the view is showing.
 *
 * @var object
 */
$templates = (object) [];
$templates->unavailable = TEMPLATE . "/global/unavailable.php";
$templates->home = TEMPLATE . "/home/index.php";

/**
 * Defining the title as the one coming from the SEO settings in the database
 * first, will let the page fallback to it, if there might be no title set
 * through any of the router files included below
 */
$router_title = "This is a title";

/**
 * 404 template is defined first for falling back to it. If there is no tem-
 * plate for a current page to show, it will show the 404
 */
$include_template = TEMPLATE . '/errors/invalid_request.php';

foreach (glob(ROUTE . "/*.php") as $filename)
  include_once $filename;

if (CURRENT_PAGE === 'home' || !CURRENT_PAGE) {
  $include_template = $templates->home;
}

/**
 * Defining the TITLE constant which holds the title coming from any of the
 * above router file inclusions
 */
define('TITLE', $router_title);
$title = TITLE . ' on ' . APP_NAME;
