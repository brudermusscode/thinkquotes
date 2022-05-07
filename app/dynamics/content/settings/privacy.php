<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST) && $logged) {

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

                            <div class="rd12 single dark <?php if ($my->send_friendrequests === 'all') echo 'isActive'; ?>" data-value="all">
                                <p class="tac">All</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->send_friendrequests === 'friendsoffriends') echo 'isActive'; ?>" data-value="friendsoffriends">
                                <p class="tac">Friends of friends</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->send_friendrequests === 'nobody') echo 'isActive'; ?>" data-value="nobody">
                                <p class="tac">Nobody</p>
                            </div>

                            <div class="cl"></div>

                            <input type="hidden" name="send_friendrequests" data-react="element:radio" value="<?php echo $my->send_friendrequests; ?>">
                        </radio-model>
                    </div>
                </div>
            </div>

        </div>
    </box-model>



    <!-- profile -->
    <box-model class="normal mshd-1 rd12 slideUp">

        <div class="nb-inr">
            <div class="pv42 mb12">
                <div class="nb-label red left-border mb12">
                    <p>Profile</p>
                </div>

                <div style="padding:0 0 0 32px;">
                    <div>
                        <p>Tell us, who shall be able to visit your...</p>
                    </div>
                </div>
            </div>

            <div class="showMoreClick mb6">
                <div getHeight class="pv44" style="background:rgba(28, 49, 58, .12);">
                    <div class="ml32 pb12">
                        <div class="mb4 clickArea pt12" style="color:var(--colour-dark);">
                            <p class="fw7 lt">Profile</p>

                            <div class="icon rt mr8 mb8">
                                <span class="material-icons-round md24">keyboard_arrow_down</span>
                            </div>

                            <div class="cl"></div>
                        </div>

                        <radio-model class="disfl fldirrow std green">

                            <div class="rd12 single dark <?php if ($my->show_profile === 'all') echo 'isActive'; ?>" data-value="all">
                                <p class="tac">All</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->show_profile === 'friends') echo 'isActive'; ?>" data-value="friends">
                                <p class="tac">Friends</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->show_profile === 'friendsoffriends') echo 'isActive'; ?>" data-value="friendsoffriends">
                                <p class="tac">Friends of friends</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->show_profile === 'nobody') echo 'isActive'; ?>" data-value="nobody">
                                <p class="tac">Nobody</p>
                            </div>

                            <div class="cl"></div>

                            <input type="hidden" name="show_profile" data-react="element:radio" value="<?php echo $my->show_profile; ?>">
                        </radio-model>
                    </div>
                </div>
            </div>

            <div class="showMoreClick">
                <div getHeight class="pv44" style="background:rgba(28, 49, 58, .12);">
                    <div class="ml32 pb12">
                        <div class="mb4 clickArea pt12" style="color:var(--colour-dark);">
                            <p class="fw7 lt">Favorite quotes</p>

                            <div class="icon rt mr8 mb8">
                                <span class="material-icons-round md24">keyboard_arrow_down</span>
                            </div>

                            <div class="cl"></div>
                        </div>

                        <radio-model class="disfl fldirrow std green">

                            <div class="rd12 single dark <?php if ($my->show_profile_favorites === 'all') echo 'isActive'; ?>" data-value="all">
                                <p class="tac">All</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->show_profile_favorites === 'friends') echo 'isActive'; ?>" data-value="friends">
                                <p class="tac">Friends</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->show_profile_favorites === 'friendsoffriends') echo 'isActive'; ?>" data-value="friendsoffriends">
                                <p class="tac">Friends of friends</p>
                            </div>

                            <div class="rd12 single dark <?php if ($my->show_profile_favorites === 'nobody') echo 'isActive'; ?>" data-value="nobody">
                                <p class="tac">Nobody</p>
                            </div>

                            <div class="cl"></div>

                            <input type="hidden" name="show_profile_favorites" data-react="element:radio" value="<?php echo $my->show_profile_favorites; ?>">
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