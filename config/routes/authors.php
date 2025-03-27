<?php

/**
 * @var object $templates
 */

$templates->author = TEMPLATE . "/authors/author.php";

/**
 * @route /author/{id}
 */
if (CURRENT_PAGE === 'author') {
  $include_template = $templates->author;
}
