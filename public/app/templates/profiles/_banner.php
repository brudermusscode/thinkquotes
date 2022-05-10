<?php if (!$is_page) header(NOT_FOUND); ?>

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

        <?php

        if (!($user->uid == $my->uid)) {

          # check if friendrequest exists
          $getFriendRequest = $pdo->prepare("SELECT * FROM users_friends_requests WHERE (sent = ? AND got = ?) OR (sent = ? AND got = ?)");
          $getFriendRequest->execute([$my->uid, $user->uid, $user->uid, $my->uid]);

          # show remove friend button
          if (in_array($my->uid, $fr)) { ?>

            <hellofresh data-action='function:friends,request,send/cancel/remove' data-json='[{"uid":"<?php echo $user->uid; ?>", "action":"removeFriendRequest"}]' class="rd6 big shadowed light friendrequest deleteFriend">
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

          <?php

            # show cancel friendrequest button
          } else if ($getFriendRequest->rowCount() > 0) {  ?>

            <hellofresh data-action='function:friends,request,send/cancel/remove' data-json='[{"uid":"<?php echo $user->uid; ?>", "action":"cancelFriend"}]' class="rd6 big shadowed light friendrequest cancelRequest">
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

            <?php

          } else {

            # check permissions
            switch ($user->send_friendrequests) {
              case "all":
                $canSend = true;
                break;
              case "friendsoffriends":
                if (!in_array($my->uid, $frofr)) {
                  $canSend = false;
                } else {
                  $canSend = true;
                }
                break;
              default:
                $canSend = false;
            }

            if ($canSend) { ?>

              <hellofresh data-action='function:friends,request,send/cancel/remove' data-json='[{"uid":"<?php echo $user->uid; ?>", "action":"addFriend"}]' class="rd6 big shadowed light friendrequest addFriend">
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

          <?php

            }
          }
        } else { ?>

          <hellofresh data-action="popup:profile,edit" class="rd6 big shadowed fw7 blue">
            <div class="c-ripple js-ripple">
              <span class="c-ripple__circle"></span>
            </div>
            <div class="disfl fldirrow">
              <div class="mr12">
                <i class="material-icons std" style="line-height:1.8em;">auto_fix_normal</i>
              </div>
              <p>Profile editor</p>
            </div>
          </hellofresh>

        <?php } ?>

      </div>
    <?php } ?>

    <div class="cl"></div>
  </div>
</div>