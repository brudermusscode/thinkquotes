<?php

/**
 * Print out anything in nicley formatted pattern.
 *
 * @param mixed
 * @return string
 */
function p(mixed ...$a)
{
  echo "<pre>";
  var_dump($a);
  echo "</pre>";
}

/**
 * @param mixed $parameter
 * @param string|array $case
 * @return void
 */
function display_active(mixed $parameter, mixed $case = null)
{
  if ($case === null)
    echo $parameter === null ? "active" : "";
  else if ($case === "")
    echo $parameter === "" ? "active" : "";
  else
    echo is_array($case)
      ? (
        in_array($parameter, $case)
        ? "active"
        : ""
      )
      : ($parameter === $case ? "active" : "");
}

/**
 * @param bool $condition
 * @param ?string $custom_attribute
 * @return void
 */
function display_disabled_if(bool $condition, ?string $custom_attribute = null)
{
  echo $condition ? $custom_attribute ?? "disabled" : "";
}
