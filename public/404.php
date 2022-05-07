<?php

    $page = "error";
    $is_page = true;

    // mysql database
    require_once "./session/session.inc.php";

    // Head section
    include_once "./assets/templates/global/head.php";

?>

            

            <div class="alignmiddle posfix tac">
                
                <p class="mb24" style="font-size:8em;color:white;text-shadow:0 4px 0 rgba(0,0,0,.28);line-height:1;">
                    404
                </p>
                
                <div class="posrel">
                    <p style="font-size:2em;color:white;text-shadow:0 1px 0 rgba(0,0,0,.28);line-height:1;">The way is blurred. Let's go back...</p>
                    
                    <a onclick="window.history.back()">
                    <hellofresh class="rd6 icon-only orange shadowed fw7 align-mid-horiz mt24">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        <div class="posabs alignmiddle">
                            <span class="material-icons-round md-24">west</span>
                        </div>
                    </hellofresh>
                    </a>
                    
                </div>
                
            </div>


<?php

    // foot section
    include_once "./assets/templates/global/footer.php";

?>