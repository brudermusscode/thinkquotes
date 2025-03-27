<?php

/**
 * This file includes the main.bundle.js which can be used around
 * the website as a script file. I bet it's loading faster if it
 * is directly included in the DOM instead of imported through a file.
 */

if (DEV) {
  echo '<script type="text/javascript" src="/assets/javascript/main.bundle.js"></script>';

  // echo "<style>";
  // include ASSETS . "/stylesheets/main.css";
  // echo "</style>";
} else {
  echo "<script defer>";
  include ASSETS . "/javascript/main.production.bundle.js";
  echo "</script>";
}
