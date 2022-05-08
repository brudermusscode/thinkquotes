<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

exit(login($pdo, $sign, $return, $system, $main, $dev_env));

function login($pdo, $sign, $return, $system, $web_information, $dev_env)
{
  if (empty($_POST["mail"]) || LOGGED) {
    $return->message = set_return_message_with(1);
    return json_encode($return);
  }

  # validate e-mail address
  if (!$sign->validateMail($_POST["mail"])) {
    $return->message = set_return_message_with(2);
    return json_encode($return);
  }

  # variablize
  $inputmail = $_POST["mail"];

  # check if there's an account with that email
  $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = ?");
  $stmt->execute([$inputmail]);

  if (!$stmt->rowCount() > 0) {
    $return->message = set_return_message_with(3);
    return json_encode($return);
  }

  # fetch users information for id
  $stmt = $stmt->fetch();
  $uid = $stmt->id;

  # create a code
  $code = $sign->createCode(4);

  # start ,ysql transaction
  $pdo->beginTransaction();

  # send the created code to the given mail address
  $stmt = $pdo->prepare("INSERT INTO users_authentications (uid, authCode) VALUES (?, ?)");
  $stmt = $system->execute($stmt, [$uid, $code], $pdo, true);

  if (!$stmt->status) {
    $return->message = set_return_message_with(4);
    return json_encode($return);
  }

  # prepare mail body
  $mailbody = file_get_contents(ROOT . '/app/templates/mails/signup.html');
  $mailbody = str_replace('%code%', $code, $mailbody);

  # send mail
  $sendMail = $system->trySendMail($inputmail, "Your authentication code!", $mailbody, $web_information);

  if (is_object($sendMail)) {
    $return->message = set_return_message_with(5);
    return json_encode($return);
  }

  # all fine, keep going my friend
  $return->message = set_return_message_with(6, $inputmail);
  $return->status = true;
  $return->uid = $uid;
  if ($dev_env) $return->code = $code;

  return json_encode($return);
}

function set_return_message_with($id, $inputmail = null)
{
  if ($id == 1) return "Fill out all forms";
  if ($id == 2) return "That's not a mail";
  if ($id == 3) return "Are you sure you are signed up?";
  if ($id == 4) return "Mistakes must be done. That's what makes us human";
  if ($id == 5) return "It couldn't sent a code, please try again";
  if ($id == 6) return "A verification code has been sent to <strong>" . $inputmail . "</strong>";
  return false;
}
