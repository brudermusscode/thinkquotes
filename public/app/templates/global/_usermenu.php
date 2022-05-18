<?php

if (!$is_page) {
  header("location: /");
}

?>

<usermainmenu>
  <div class="disfl fldirrow">

    <div data-react="check:friends,request" class="posrel" style="z-index:2;" travelhereboy>

      <?php if (!$my->check_friendrequests) { ?>

        <pulse class="roundedPulse small"></pulse>

      <?php } ?>

      <hellofresh data-action="dropdown:open" class="hellofresh hover-shadow clean dark rounded icon-only">
        <div class="c-ripple js-ripple">
          <span class="c-ripple__circle"></span>
        </div>

        <p class="lt posabs alignmiddle">
          <i class="material-icons std">more_vert</i>
        </p>

        <div class="cl"></div>
      </hellofresh>

      <dropdown data-dropdown="header,usermenu" data-react="dropdown:open" class="mshd-4" style="z-index:11;">
        <div class="dd-inr">
          <ul>

            <li class="trimt" onclick="window.location.replace('/u/<?php echo $my->username; ?>');">
              <p>
                <i class="ri-user-smile-fill small"></i>
              </p>
              <p>Profile</p>
            </li>

            <?php if ($hasFriendsRequests) { ?>

              <div data-react="remove:friendrequest,container">
                <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

                <li data-action="popup:users,friendrequests" class="friendrequest <?php if (!$my->check_friendrequests) echo "hasRequest "; ?> trimt">
                  <p class="align-mid-vert">
                    <span class="material-icons-round md-18">emoji_people</span>
                  </p>
                  Friendrequests
                </li>

                <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>
              </div>

            <?php } ?>

            <div>

              <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

              <p style="padding:4px 32px 0;color:rgba(0,0,0,.24);">Quotes</p>

              <li class="trimt" onclick="window.location.replace('/u/<?php echo $my->username; ?>');">
                <p>
                  <i class="ri-dashboard-fill small"></i>
                </p>
                <p>Your quotes</p>
              </li>

              <li class="trimt" onclick="window.location.replace('/f/<?php echo $my->username; ?>');">
                <p>
                  <i class="ri-heart-3-fill small"></i>
                </p>
                <p>Favorite quotes</p>
              </li>

              <li class="trimt" onclick="window.location.replace('/d/<?php echo $my->username; ?>');">
                <p>
                  <i class="ri-eye-off-fill small"></i>
                </p>
                <p>Drafts</p>
              </li>

              <li class="trimt" onclick="window.location.replace('/a/<?php echo $my->username; ?>');">
                <p>
                  <i class="ri-archive-fill small"></i>
                </p>
                <p>Archive</p>
              </li>

            </div>

            <div>

              <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

              <p style="padding:4px 32px 0;color:rgba(0,0,0,.24);">Setup</p>

              <li class="trimt" data-action="popup:users,settings">
                <p>
                  <i class="ri-settings-6-fill small"></i>
                </p>
                <p>Settings</p>
              </li>

              <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

              <li class="trimt" data-action='users:sign,out' style="color:var(--colour-red);">
                <p>
                  <i class="ri-logout-circle-r-fill small"></i>
                </p>
                <p>Leave</p>
              </li>

            </div>

          </ul>
        </div>
      </dropdown>
    </div>

  </div>
</usermainmenu>