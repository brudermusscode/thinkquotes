<?php

$is_page = true;
$page = "intern";
$subPage = "intern:imprint";
$pageTitle = "Impurinto";

// mysql database
require_once "../session/session.inc.php";

// Head section
include_once "../assets/templates/global/head.php";
include_once "../assets/templates/global/header.php";

?>

<div id="main" class="wpx--main">

    <?php include_once "../assets/templates/intern/header.tools.php"; ?>

    <div class="intern--outer">

        <div class="rt-content">
            <?php include_once "../assets/dynamics/content/discord-widget.php"; ?>
        </div>

        <div class="lt-content posrel">

            <div class="whole-line"></div>

            <div class="normal-box" id="m2">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Diensteanbieter</p>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Justin-Leon Seidel</p>
                    <p>Driverstr. 7</p>
                    <p>49377 Vechta</p>
                    <p>Deutschland</p>

                    <div class="mt12">
                        <p class="posrel lt mr12" style="color:white;background:var(--colour-bluegrey);border-radius:50%;height:32px;width:32px;">
                            <span class="posabs alignmiddle material-icons std">web</span>
                        </p>
                        <p class="lt mt6">Datenschutzerklärung: <a href="<?php echo $url->intern; ?>/privacy"><?php echo $url->intern; ?>/privacy</a></p>

                        <div class="cl"></div>
                    </div>

                </div>
            </div>

            <div class="normal-box small-margin" id="m1">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Kontaktmöglichkeiten</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/101.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">

                    <div>
                        <p class="posrel lt mr12" style="color:white;background:var(--colour-red);border-radius:50%;height:32px;width:32px;">
                            <span class="posabs alignmiddle material-icons std">alternate_email</span>
                        </p>
                        <p class="lt mt6">E-Mail-Adresse: <a href="mailto:hou@thinkquotes.de">hou@thinkquotes.de</a></p>

                        <div class="cl"></div>
                    </div>

                    <div>
                        <p class="posrel lt mr12" style="color:white;background:var(--colour-orange);border-radius:50%;height:32px;width:32px;">
                            <span class="posabs alignmiddle material-icons std">phone_iphone</span>
                        </p>
                        <p class="lt mt6">Telefon: <a href="https://discord.gg/b5ZsgPjN" target="_blank">015773602821</a></p>

                        <div class="cl"></div>
                    </div>

                    <div>
                        <p class="posrel lt mr12" style="color:white;background:#6570F7;border-radius:50%;height:32px;width:32px;">
                            <span class="posabs alignmiddle material-icons std">discord</span>
                        </p>
                        <p class="lt mt6">Discord: <a href="https://discord.gg/b5ZsgPjN" target="_blank">https://discord.gg/b5ZsgPjN</a></p>

                        <div class="cl"></div>
                    </div>

                    <div class="cl"></div>
                </div>
            </div>

            <div class="normal-box small-margin" id="m1">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Social Media und andere Onlinepräsenzen</p>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Dieses Impressum gilt auch für die folgenden Social-Media-Präsenzen und Onlineprofile:</p>
                    <div class="mt24">
                        <p class="posrel lt mr12" style="color:white;background:#6570F7;border-radius:50%;height:32px;width:32px;">
                            <span class="posabs alignmiddle material-icons std">discord</span>
                        </p>
                        <p class="lt mt6">Discord: <a href="https://discord.gg/b5ZsgPjN" target="_blank">https://discord.gg/b5ZsgPjN</a></p>

                        <div class="cl"></div>
                    </div>
                    <div>
                        <p class="posrel lt mr12" style="color:white;background:var(--colour-lila);border-radius:50%;height:32px;width:32px;">
                            <span class="posabs alignmiddle material-icons std">stream</span>
                        </p>
                        <p class="lt mt6">Twitch: <a href="https://www.twitch.tv/brudermusscode" target="_blank">https://www.twitch.tv/brudermusscode</a></p>

                        <div class="cl"></div>
                    </div>

                    <div class="cl"></div>
                </div>
            </div>

            <div class="normal-box small-margin" id="m1">
                <div class="label-box" id="disclaimer">
                    <p class="trimt">Haftungs- und Schutzrechtshinweise</p>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p><strong>Haftungsausschluss</strong>: Die Inhalte dieses Onlineangebotes wurden sorgfältig und nach unserem aktuellen Kenntnisstand erstellt, dienen jedoch nur der Information und entfalten keine rechtlich bindende Wirkung, sofern es sich nicht um gesetzlich verpflichtende Informationen (z.B. das Impressum, die Datenschutzerklärung, AGB oder verpflichtende Belehrungen von Verbrauchern) handelt. Wir behalten uns vor, die Inhalte vollständig oder teilweise zu ändern oder zu löschen, soweit vertragliche Verpflichtungen unberührt bleiben. Alle Angebote sind freibleibend und unverbindlich. </p>
                    <p><strong>Links auf fremde Webseiten</strong>: Die Inhalte fremder Webseiten, auf die wir direkt oder indirekt verweisen, liegen außerhalb unseres Verantwortungsbereiches und wir machen sie uns nicht zu Eigen. Für alle Inhalte und Nachteile, die aus der Nutzung der in den verlinkten Webseiten aufrufbaren Informationen entstehen, übernehmen wir keine Verantwortung.</p>
                    <p><strong>Urheberrechte und Markenrechte</strong>: Alle auf dieser Website dargestellten Inhalte, wie Texte, Fotografien, Grafiken, Marken und Warenzeichen sind durch die jeweiligen Schutzrechte (Urheberrechte, Markenrechte) geschützt. Die Verwendung, Vervielfältigung usw. unterliegen unseren Rechten oder den Rechten der jeweiligen Urheber bzw. Rechteinhaber.</p>
                    <p><strong>Hinweise auf Rechtsverstöße</strong>: Sollten Sie innerhalb unseres Internetauftritts Rechtsverstöße bemerken, bitten wir Sie uns auf diese hinzuweisen. Wir werden rechtswidrige Inhalte und Links nach Kenntnisnahme unverzüglich entfernen.</p>
                </div>
            </div>

            <div class="normal-box small-margin" id="m1">

                <div class="nb-inr posrel" style="z-index:1;">
                    <div style="background:white;" class="tac">
                        <p class="seal"><a href="https://datenschutz-generator.de/?l=de" title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken." target="_blank" rel="noopener noreferrer nofollow">Erstellt mit kostenlosem Datenschutz-Generator.de von Dr. Thomas Schwenke</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php include_once "../assets/templates/global/footer.php"; ?>