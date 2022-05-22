<?php

if (!$is_page) header(NOT_FOUND);

# define action string for friendrequests
(string) $action = NULL;
(bool) $allow_request = false;
(bool) $is_friend = false;

# only do this block, if this is not current user's profile
if (!($user->uid == $my->uid)) {

  # check if friendrequest exists
  $am_sender = false;
  $am_receiver = false;

  $q =
    "SELECT (
      SELECT COUNT(*)
      FROM users_friends_requests
      WHERE sent = ? AND got = ?
      LIMIT 1
    ) sender,
    (
      SELECT COUNT(*)
      FROM users_friends_requests
      WHERE sent = ? AND got = ?
      LIMIT 1
    ) receiver";
  $get_friend_request = $THQ->select($pdo, $q, [$my->uid, $user->uid, $user->uid, $my->uid], false);

  if ($get_friend_request->fetch->sender) $am_sender = true;
  if ($get_friend_request->fetch->receiver) $am_receiver = true;

  # raise NOT_FOUND if query fails
  if (!$get_friend_request->status) header(NOT_FOUND);

  # if no friendrequest exists, set action to request

  # switch through privacy settings of user for sending friendrequests
  switch ($user->send_friendrequests) {
    case "all":
      $allow_request = true;
      break;
    case "friendsoffriends":
      if (!in_array($my->uid, $frofr)) {
        $allow_request = false;
      } else {
        $allow_request = true;
      }
      break;
    default:
      $allow_request = false;
  }

  $action = 'request';

  if ($am_sender || $am_receiver) $action = 'cancel_request';

  if (in_array($my->uid, $fr)) {
    $action = 'remove';
    $is_friend = true;
  };
}

?>

<div class="u-hdr mshd-1 mb32">
  <div class="u-hdr-inr posrel">
    <div class="disfl fldirrow lt">

      <!-- vielleicht lieblingszitat? -->
      <div class="posrel dno" style="border-radius:50%;height:92px;width:92px;overflow:hidden;background:var(--colour-red);">
        <div class="alignmiddle posabs">
          <p style="color:white;font-weight:700;font-size:2em;"><?php echo substr($user->username, 0, 1) ?></p>
        </div>
      </div>

      <div class="user-action" style="line-height:1;">
        <p class="trimt">
          <?php echo $user->username ?>
        </p>
      </div>
    </div>

    <?php if (LOGGED) { ?>

      <div class="posabs" style="right:32px;">

        <?php if (!($user->uid == $my->uid)) { ?>
          <?php if ($allow_request || !$is_friend) { ?>
            <hellofresh data-action='function:friends,request,actions' data-json='[{"uid":"<?php echo $user->uid; ?>"}]' data-do="<?php echo $action; ?>" class="rd6 big shadowed light friendrequest <?php if ($am_receiver) echo "am-receiver "; ?><?php echo $action; ?>">
              <div class="c-ripple js-ripple">
                <span class="c-ripple__circle"></span>
              </div>

              <div class="disfl fldirrow">
                <div class="mr12 icon">
                  <i class="material-icons small"></i>
                </div>
                <p class="text"></p>
              </div>
            </hellofresh>
          <?php } ?>
        <?php } ?>

      </div>

    <?php } ?>

    <div class="cl"></div>
  </div>
</div>