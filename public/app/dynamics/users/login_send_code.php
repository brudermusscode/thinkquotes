<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

// exit script by executing the validation function
exit(validate_sign_in_code($pdo, $return, $sign, $system));

function validate_sign_in_code($pdo, $return, $sign, $system)
{
  if (!is_numeric_request() || LOGGED) {
    $return->message = set_return_message_with(1);
    return json_encode($return);
  }

  $serialArray = NULL;
  $uid = $_REQUEST["uid"];

  // take all parts of the given code and chain it to one string for
  // validation
  $code = $_REQUEST["code1"];
  $code .= $_REQUEST["code2"];
  $code .= $_REQUEST["code3"];
  $code .= $_REQUEST["code4"];

  // check if there's an account with that email
  $query =
    "SELECT *, users.id AS id
        FROM users, users_authentications, users_settings
        WHERE users.id = users_authentications.uid
        AND users.id = users_settings.uid
        AND users_authentications.uid = ?
        AND users_authentications.authCode = ?
        AND users_authentications.used = '0'";

  $stmt = $system->select($pdo, $query, [$uid, $code]);

  if ($stmt->rowCount() < 1) {
    $return->message = set_return_message_with(2);
    return json_encode($return);
  }

  // create serial & token for session
  $serialArray = (object) [
    "token" => $sign->createString(34),
    "serial" => $sign->createString(34),
    "uid" => $uid
  ];

  // begin a new mysqwl transaction!!1 ALL OR NOTHING1!!!
  $pdo->beginTransaction();

  // create session with user information
  if (!$sign->createSession($stmt, $serialArray, false)) {
    $return->message = set_return_message_with(3);
    return json_encode($return);
  }

  // update the user_authentication record to 'used', which equals the value of (int) 1
  $update = $pdo->prepare("UPDATE users_authentications SET used = 1 WHERE uid = ?");
  $update = $system->execute($update, [$uid], $pdo, true);

  if (!$update->status) {
    $return->message = set_return_message_with(4);
    return json_encode($return);
  }

  // set up all $return values for the request to continue
  $return->status = true;
  $return->SESSION = $_SESSION;
  $return->STMT = $stmt;
  $return->message = set_return_message_with(5);

  return json_encode($return);
}

function is_numeric_request()
{
  foreach ($_REQUEST as $a => $b) {
    if (!is_numeric($a)) {
      return false;
    }
  }

  return true;
}

function set_return_message_with($id)
{
  if ($id == 1) return "Fill out all forms";
  if ($id == 2) return "Are you sure you are signed up?";
  if ($id == 3) return "Couldn't create a session";
  if ($id == 4) return "Mistakes are, what makes us human. But the system encountered a problem";
  if ($id == 5) return "You've been logged in my friend!";
  return false;
}
