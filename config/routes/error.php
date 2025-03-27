<?php

/**
 * @var object $templates
 */

$templates->e404 = TEMPLATE . "/errors/404.php";

/**
 * @route /404
 */
if (CURRENT_PAGE === '404') {
  $include_template = $templates->e404;
}
