<?php

use Bruder\Model\User;

/**
 * @var User $current_user
 */

?>

<mbutton <?php echo PUREMODE_ENABLED ? "active" : ""; ?> js-action="pure-mode:toggle" material has-icon=left size=std background=slighter hoverable>
  <i class="si-square-half"></i>
  Pure
</mbutton>

<mbutton dark-mode <?php echo DARKMODE_ENABLED ? "active" : ""; ?> js-action="dark-mode:toggle" material has-icon=left size=std background=slighter hoverable>
  <div dark>
    <i class="si-moon"></i>
    Dark
  </div>
  <div light>
    <i class="si-sun"></i>
    Light
  </div>
</mbutton>