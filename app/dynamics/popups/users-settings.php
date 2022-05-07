<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST) && $isLoggedIn) {

?>

    <div data-element="overlay:progress">
        <div class="progress-bar"></div>
    </div>

    <div id="settings-main">


        <div style="top:3em;position:absolute;left:0;width:100%;">
            <div data-action="popup:close" class="close dark posabs align-mid-vert" style="right:32px;line-height:1;">
                <p class="posabs alignmiddle"><span class="material-icons-round md24">close</span></p>
            </div>
        </div>

        <div class="lt-cont">
            <div class="settings-menu-outer">
                <ul>
                    <li class="isActive" data-action="users:settings,page" data-settings-page="privacy">
                        <p>Privacy</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="rt-cont">

            <div class="sm-label">
                <div class="sm-label-inr">
                    <p class="lt">Settings</p>
                    <p class="lt"><span class="material-icons-round md18">arrow_right</span></p>
                    <p class="lt fadeIn" data-react="users:settings,page"></p>

                    <div class="cl"></div>
                </div>
            </div>

            <form data-react="users:settings,content" data-form="users:settings"></form>

        </div>
    </div>


<?php

} else {
    exit("0");
}

?>