<?php

/**
 * Private tokens for accessing different parts, that should not
 * be accessible for the outer world.
 */

return [
  /**
   * Maintenance
   * The maintenance token to bypass maintenance mode.
   */
  "maintenance" => "",

  /**
   * Cross-Site-Request-Forgery
   * Security constant to only allow requests actually coming from
   * this website.
   */
  "csrf" => "",
];
