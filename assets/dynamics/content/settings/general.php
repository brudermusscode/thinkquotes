<?php

require_once "../../../../session/session.inc.php";

if (isset($_POST) && $isLoggedIn) {

?>


    <!-- friendrequests -->
    <box-model class="normal mshd-1 rd12 mb12 slideUp">
        <div class="nb-inr">
            <div class="pv42">
                <div class="nb-label red left-border mb12">
                    <p>Friendrequests</p>
                </div>

                <div class="pv32">

                    <div>
                        <p>I want to receive friendrequests from...</p>
                    </div>

                    <div class="mt12">
                        <radio-model class="disfl fldirrow std green">

                            <div class="rd12 single dark <?php if ($my['send_friendrequests'] === 'all') echo 'isActive'; ?>" data-value="all">
                                <p class="tac">All</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my['send_friendrequests'] === 'friendsoffriends') echo 'isActive'; ?>" data-value="friendsoffriends">
                                <p class="tac">Friends of friends</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my['send_friendrequests'] === 'nobody') echo 'isActive'; ?>" data-value="nobody">
                                <p class="tac">Nobody</p>
                            </div>

                            <div class="cl"></div>

                            <input type="hidden" name="send_friendrequests" data-react="element:radio" value="<?php echo $my['send_friendrequests']; ?>">
                        </radio-model>
                    </div>
                </div>
            </div>

        </div>
    </box-model>

<?php

} else {
    exit('0');
}

?>