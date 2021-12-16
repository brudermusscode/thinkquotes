<style>
    [data-structure="hdr:main"] {
        top: 0;
        left: 0;
        width: 100%;
        background: #566E7A;
        height: auto;
        position: fixed;
        z-index: 100000000000;
        transition: all .1s linear;
    }

    [data-structure="hdr:main"] .inr {
        width: var(--main-width);
        margin: 0 auto;
        padding: 12px 0;
    }

    [data-structure="hdr:main"] .inr .new-logo {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    [data-structure="hdr:main"] .inr .new-logo .new-logo--outer {
        height: 48px;
        width: 48px;
        position: relative;
    }

    [data-structure="hdr:main"] .inr .new-logo .new-logo--outer .ac {
        height: 100%;
        width: 100%;
        background: url(https://images.thinkquotes.de/global/new.logo.thq.png) center no-repeat;
        background-size: cover;
        border-radius: 50%;
        transition: all .1s linear;
        cursor: pointer;
    }

    [data-structure="hdr:main"] .inr .new-logo .new-logo--outer .ac:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }

    .hovermenu-h .show-menu {
        top: 0;
        position: absolute;
        height: 0px;
        width: 0px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.1, 0.82, 0.25, 1);
        overflow: hidden;
    }

    .hovermenu-h .show-menu.left {
        left: 0;
    }

    .hovermenu-h .show-menu.right {
        right: 0;
    }

    .hovermenu-h:hover .show-menu {
        height: auto;
        width: 240px;
        opacity: 1;
        visibility: visible;
    }

    .hovermenu-h .show-menu ul {
        list-style: none;
        padding: 12px 0 !important;
        margin: 0 !important;
        width: 240px;
    }

    .hovermenu-h .show-menu ul {
        list-style: none;
        padding: 12px 0 !important;
        margin: 0 !important;
        width: 100%;
    }

    .hovermenu-h .show-menu ul li {
        padding: 0 24px;
        line-height: 3em;
        color: var(--colour-dark);
        text-align: left;
        cursor: pointer;
        transition: all .1s linear;
        overflow: hidden;
    }

    .hovermenu-h .show-menu ul li.has-acon {
        padding: 0 24px 0 62px;
        position: relative;
    }

    .hovermenu-h .show-menu ul li:hover {
        background: #ffebee;
    }

    p {
        margin: 0;
    }

    [data-structure="content:main"] {
        max-width: var(--main-width);
        width: 100%;
        margin: 0 auto;
        margin-bottom: 320px;
        margin-top: 140px;
    }

    .labbel {
        margin-bottom: 12px;
    }

    .labbel .inr {
        padding: 12px 32px;
    }

    .labbel .inr p {
        color: white;
        font-size: 1em;
        font-weight: 600;
        text-transform: uppercase;
        margin-right: 8px;
    }

    .pussy {
        position: relative;
        margin-bottom: 12px;
        border-radius: 6px;
        transition: all .1s linear;
    }

    .pussy:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
        z-index: 1;
        transform: scale(1.01);
    }

    .pussy:active {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }

    .pussy .juice .texterino {
        padding: 32px 48px 32px 0;
        width: 28em;
    }

    .pussy .juice .texterino p {
        color: white;
        font-size: 1em;
    }

    .pussy .juice .texterino p:first-of-type {
        font-size: 2em;
    }

    .pussy .juice .iccon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 64px;
        color: white;
    }

    .pussy .juice.light .iccon p,
    .pussy .juice.light .texterino p {
        color: var(--colour-dark) !important;
    }
</style>

<!--- HDR --->
<div data-structure="hdr:main">

    <div class="inr">
        <div class="new-logo">
            <div class="new-logo--outer">
                <a href="/">
                    <div class="ac mshd-1"></div>
                </a>
            </div>
        </div>

        <div class="lt">

            <hellofresh class="hovermenu-h hellofresh clean rd6 icon-only posrel" style="overflow:visible;color:var(--colour-light);cursor:default;">
                <div class="c-ripple js-ripple">
                    <span class="c-ripple__circle"></span>
                </div>
                <p class="lt posabs alignmiddle"><span class="material-icons-round md-24">more_horiz</span></p>

                <div class="cl"></div>

                <div class="show-menu left rd6 mshd-3" style="position:absolute;">
                    <div style="background:white;">
                        <ul>
                            <li class="trimt">Bibliothek</li>
                        </ul>
                    </div>
                </div>
            </hellofresh>

        </div>
        <div class="rt disflrow">

            <a href="https://roundcube.fh-muenster.de/roundcubemail/">
                <hellofresh class="hellofresh clean rd6 icon-only posrel" style="overflow:visible;color:var(--colour-light);margin-right:12px;">
                    <div class="c-ripple js-ripple">
                        <span class="c-ripple__circle"></span>
                    </div>
                    <p class="lt posabs alignmiddle"><span class="material-icons-round md-24">email</span></p>

                    <div class="cl"></div>
                </hellofresh>
            </a>


            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkStudyPlanner">
                <hellofresh class="hellofresh clean rd6 icon-only posrel" style="overflow:visible;color:var(--colour-light);margin-right:12px;">
                    <div class="c-ripple js-ripple">
                        <span class="c-ripple__circle"></span>
                    </div>
                    <p class="lt posabs alignmiddle"><span class="material-icons-round md-24">view_list</span></p>

                    <div class="cl"></div>
                </hellofresh>
            </a>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkSchedule">
                <hellofresh class="hellofresh clean rd6 icon-only posrel" style="overflow:visible;color:var(--colour-light);margin-right:12px;">
                    <div class="c-ripple js-ripple">
                        <span class="c-ripple__circle"></span>
                    </div>
                    <p class="lt posabs alignmiddle"><span class="material-icons-round md-24">date_range</span></p>

                    <div class="cl"></div>
                </hellofresh>
            </a>

            <hellofresh class="hellofresh fw7 rd6 big mr12 red hovermenu-h" style="overflow:visible;color:var(--colour-light);margin-right:12px;">

                <div class="c-ripple js-ripple">
                    <span class="c-ripple__circle"></span>
                </div>
                <p data-append="button:uniqueid" class="lt">js305125</p>

                <div class="cl"></div>

                <div class="show-menu right mshd-3 rd6">
                    <div style="background:white;">
                        <ul>
                            <a href="https://www.fh-muenster.de/myfh/">
                                <li class="trimt has-acon">
                                    <span class="material-icons-round md-24" style="position:absolute;left:24px;top:50%;transform:translateY(-50%);">next_week</span>
                                    My FH Portal</p>
                                </li>
                            </a>
                            <a href="https://www.fh-muenster.de/myfh/meine-nachrichten.php">
                                <li class="trimt has-acon">
                                    <span class="material-icons-round md-24" style="position:absolute;left:24px;top:50%;transform:translateY(-50%);">chat</span>
                                    Meine Nachrichten</p>
                                </li>
                            </a>
                            <a href="https://www.fh-muenster.de/myfh/myfh-frame.php?m=mid_study&s=sid_doc&view=headless&cat=Mein%20Studium">
                                <li class="trimt has-acon">
                                    <span class="material-icons-round md-24" style="position:absolute;left:24px;top:50%;transform:translateY(-50%);">description</span>
                                    Meine Dokumente</p>
                                </li>
                            </a>
                            <a href="https://www.fh-muenster.de/myfh/portaleinstellungen.php">
                                <li class="trimt posrel has-acon">
                                    <span class="material-icons-round md-24" style="position:absolute;left:24px;top:50%;transform:translateY(-50%);">settings</span>
                                    Portaleinstellungen</p>
                                </li>
                            </a>
                            <a href="https://www.fh-muenster.de/logout.sp">
                                <li class="trimt posrel has-acon" style="color:red;">
                                    <span class="material-icons-round md-24" style="position:absolute;left:24px;top:50%;transform:translateY(-50%);">logout</span>
                                    Logout</p>
                                </li>
                            </a>
                        </ul>
                    </div>
                </div>
            </hellofresh>
        </div>

        <div class="cl"></div>
    </div>

</div>

<!--- SUB HDR --->
<div data-structure="hdr:sub" style="margin-bottom:24px;">
</div>

<div style="height:80px;"></div>

<?php if ($_POST['myfh']) { ?>

    <!-- CONTENT MAIN -->
    <div data-structure="content:main">

        <div class="lt w48" appendhere>

            <div class="labbel">
                <div class="inr disflrow">
                    <p>Wichtiges</p>
                    <p><span class="material-icons-round md-24">expand_more</span></p>
                </div>
            </div>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkStudyPlanner">
                <div class="pussy mshd-1">
                    <div class="juice bgpink rd6">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">login</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">An- und Abmelden</p>
                                <p class="scnd">Prüfungen anmelden und Veranstaltungen belegen</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkSchedule">
                <div class="pussy mshd-1">
                    <div class="juice bgorange rd6">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">date_range</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">Stundenplan</p>
                                <p class="scnd">Wie damals von der Schule</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkAchievements">
                <div class="pussy mshd-1">
                    <div class="juice bggreen rd6">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">heart_broken</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">Leistungen</p>
                                <p class="scnd">Willst du da wirklich reinschauen?</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkOwnEnrollment">
                <div class="pussy mshd-1">
                    <div class="juice bgblue rd6">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">reorder</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">Belegungen</p>
                                <p class="scnd">Liste all deiner belegten Veranstaltungen</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkSearchRooms">
                <div class="pussy mshd-1">
                    <div class="juice bgpurple rd6">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">meeting_room</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">Räume suchen</p>
                                <p class="scnd">Prüfungen anmelden und Veranstaltungen belegen</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>



            <!-- NOT SO IMPORTANTE -->
            <div class="labbel" style="margin-top:42px;">
                <div class="inr disflrow">
                    <p>Nicht so wichtiges</p>
                    <p><span class="material-icons-round md-24">expand_more</span></p>
                </div>
            </div>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkCourseCatalog">
                <div class="pussy mshd-1">
                    <div class="juice bglight light rd6">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">find_replace</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">Vorlesungsverzeichnis</p>
                                <p class="scnd">Alle Fachbereiche</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>

            <a href="https://www.fh-muenster.de/myfh/frame.php?connectorType=getLinkSearchStudyCourseSchedule">
                <div class="pussy mshd-1">
                    <div class="juice bglight rd6 light">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">find_replace</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">Studiengangspläne</p>
                                <p class="scnd">Veranstaltungen eines bestimmten Studiengangs</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>

            <a href="https://www.fh-muenster.de/myfh/myfh-frame.php?m=mid_study&s=sid_photo&view=headless&cat=Mein%20Studium">
                <div class="pussy mshd-1">
                    <div class="juice bglight light rd6">
                        <div class="iccon">
                            <p>
                                <span class="material-icons-round md-62">find_replace</span>
                            </p>
                        </div>

                        <div class="texterino rt">
                            <div class="tittel">
                                <p class="frst">Foto hochladen</p>
                                <p class="scnd">Habe ich schon gemacht, danke!</p>
                            </div>
                        </div>

                        <div class="cl"></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="rt w48">

            <div data-append="messages">
                <div class="labbel">
                    <div class="inr disflrow">
                        <p>Nachrichten</p>
                        <p><span class="material-icons-round md-24">expand_more</span></p>
                    </div>
                </div>
            </div>

            <div data-append="feedback">
                <div class="labbel" style="margin-top:42px;">
                    <div class="inr disflrow">
                        <p>Hilfe</p>
                        <p><span class="material-icons-round md-24">expand_more</span></p>
                    </div>
                </div>
            </div>

        </div>

        <div class="cl"></div>
    </div>

<?php } ?>