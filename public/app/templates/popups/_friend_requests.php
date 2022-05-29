<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (!LOGGED) exit(json_encode($return));

$q =
  "SELECT ufr.*, u.username username
    FROM users_friends_requests ufr
    JOIN users u ON ufr.sent = u.id
    JOIN users_settings us ON u.id = us.uid
    WHERE ufr.got = ?
    ORDER BY ufr.timestamp";
$get_friend_requests = $THQ->select($pdo, $q, [$my->uid], true);

?>

<popup-module>
  <div class="inr">

    <?php

    // get freindrequests
    if ($get_friend_requests->stmt->rowCount() < 1) { ?>

      <div style="height:20em;width:20em;background:url(<?php echo IMAGES . "/flat/11098.jpg"; ?>) center bottom no-repeat;background-size:cover;border-radius:50%;" class="mb32 disn"></div>

      <label for="popup-module" class="mb32">
        <div class="label-inr light p32">
          <p style=font-size:2em;line-height:1em;letter-spacing:-.04em;>Leer bedeutet leer von etwas. Die Schale kann nicht leer von nichts sein. "Leer" muss also, um überhaupt etwas zu bedeuten, erläutert, definiert werden: leer von was? Meine Schale ist leer von Wasser, aber sie ist nicht leer von Luft. </p>
          <p style=text-align:right;font-size:1.8em;margin-top:1em;opacity:.8;><i>Thich Nhat Hanh</i></p>
        </div>
      </label>

    <?php } else { ?>

      <label for="popup-module" class="mb32">
        <div class="label-inr light">
          <p>Pending requests</p>
        </div>
      </label>

      <?php

      $timeAgoObject = new convertToAgo;

      foreach ($get_friend_requests->fetch as $fr) {
        $when = $timeAgoObject->timeago($fr->timestamp); ?>

        <div class="friendrequests-outer rd14 mshd-1 p12 mb12" style="background:var(--colour-dark);" data-id=<?php echo $fr->id; ?>>


          <div class="fr-inr" data-append="overlay">

            <div class="image-outer">
              <div class="actual">
                <p class="posabs alignmiddle isDark"><?php echo strtoupper(substr($fr->username, 0, 1)); ?></p>
              </div>
            </div>

            <div class="text-outer">
              <div class="username">
                <p class="fw7 trimt"><?php echo $fr->username; ?></p>
              </div>

              <div class="timestamp" style="font-style:italic;opacity:.6;font-size:.8em;">
                <p><?php echo $when; ?></p>
              </div>
            </div>

            <div class="cl"></div>

            <div class="options">
              <div class="disfl fldirrow">

                <hellofresh data-action='function:friends,request,answer' data-json='[{"id":"<?php echo $fr->id; ?>","user_sent_id":"<?php echo $fr->sent; ?>","action":"accept_request"}]' class="hellofresh green rd6 icon-only mr12 circled small">
                  <div class="c-ripple js-ripple">
                    <span class="c-ripple__circle"></span>
                  </div>
                  <p class="lt posabs alignmiddle">
                    <i class="ri-check-line"></i>
                  </p>
                  <div class="cl"></div>
                </hellofresh>

                <hellofresh data-action='function:friends,request,answer' data-json='[{"id":"<?php echo $fr->id; ?>","user_sent_id":"<?php echo $fr->sent; ?>","action":"decline_request"}]' class="hellofresh darkred dark rd6 icon-only circled small">
                  <div class="c-ripple js-ripple">
                    <span class="c-ripple__circle"></span>
                  </div>
                  <p class="lt posabs alignmiddle">
                    <i class="ri-close-line"></i>
                  </p>
                  <div class="cl"></div>
                </hellofresh>

                <div class="cl"></div>
              </div>
            </div>

          </div>

        </div>

      <?php } ?>
    <?php } ?>

  </div>
</popup-module>

<script class="dno">
  $(() => {
    setTimeout(() => {
      let $popupModule = $(document).find("popup-module");
      $popupModule.addClass("active");
    }, 10);
  });
</script>