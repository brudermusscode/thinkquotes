<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set header to json response
header(JSON_RESPONSE_FORMAT);

# start validation process
if (empty($_POST['mail']) || LOGGED) {
  $return->message = error_response_with(0);
  exit(json_encode($return));
}

# variablize
$mail = $_REQUEST["mail"];

# validate mail address
if (!$sign->validateMail($mail)) {
  $return->message = error_response_with(1);
  exit(json_encode($return));
}

# get remoteaddr and httpx
$httpx = $sign->getRemoteAddress();
$remoteaddr = $_SERVER['REMOTE_ADDR'];
# maximum of 24 chars for username allowed from database side
$username = "THQ-" . $collection->getToken(16);

# ! start mysql transaction
$pdo->beginTransaction();

# insert new user
# insert users settings
$query = "INSERT INTO users (username, mail, remoteaddr, httpx) VALUES (?, ?, ?, ?)";
$insert_user = $THQ->insert($query, [$username, $mail, $remoteaddr, $httpx], false);

if (!$insert_user->status) {
  if ($insert_user->code == '23000') $return->message = error_response_with(2);
  exit(json_encode($return));
}

# get last inserted id for setting up
# relation between user and settings
$id = $insert_user->connection->lastInsertId();

# insert users settings
$query = "INSERT INTO users_settings (uid) VALUES (?)";
$insert_users_settings = $THQ->insert($query, [$id], false);

if (!$insert_users_settings->status) {
  $return->message = error_response_with(3);
  exit(json_encode($return));
}

# create authentication code
$auth_code = $sign->createCode(4);

# insert authentication
$query = "INSERT INTO users_authentications (uid, authCode) VALUES (?, ?)";
$insert_auth_code = $THQ->insert($query, [$id, $auth_code], false);

if (!$insert_auth_code->status) {
  $return->message = error_response_with(4);
  exit(json_encode($return));
}

# prepare mail body
$mailbody = file_get_contents(ROOT . '/public/app/templates/mails/signup.html');
$mailbody = str_replace('%code%', $auth_code, $mailbody);

# send mail
$sendMail = $THQ->trySendMail($mail, "Welcome to ThinkQuotes!", $mailbody, $main);

if (is_object($sendMail)) {

  # rollback insertions
  $pdo->rollback();

  $return->message = error_response_with(5);
  exit(json_encode($return));
}

# set return status to true, we did it boys
$return->status = true;
$return->uid = $id;
$return->message = error_response_with(6, $mail);

# send auth code with json response if dev env is enabled
if ($dev_env) $return->auth_code = $auth_code;

# COMMIT INSERRTIONS WUH
$pdo->commit();

# final script exit. If you get till here, you are gud to go
exit(json_encode($return));

# define function which will just return error messages
function error_response_with(int $message_code, string $email_address = null)
{

  if ($message_code == 0) $message = 'Use your mail address to sign up';
  if ($message_code == 1) $message = 'Your mail address is invalid';
  if ($message_code == 2) $message = 'Your mail address is in use already. If this is your account, sign in';
  if ($message_code == 3) $message = 'There seems to be something sqishy. We recommend, to try again!';
  if ($message_code == 4) $message = 'There seems to be something sqishy. We recommend, to try again!';
  if ($message_code == 5) $message = "We couldn't send an email out of curious reasons. Please login with your new account and use the the code which will be send there";
  if ($message_code == 6) $message = "A mail with an authentication code has been sent to <strong>$email_address</strong>";

  return $message;
}
