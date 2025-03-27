<?php

/**
 * @var object $templates
 */

$templates->topic = TEMPLATE . "/topics/topic.php";

/**
 * @route /topic/{id}
 */
if (CURRENT_PAGE === 'topic') {
  $include_template = $templates->topic;
}
