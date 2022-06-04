<?php

$is_page = true;
$page = "intern";
$subPage = "intern:imprint";
$pageTitle = "Impurinto";

// mysql database
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/init.php";

// Head section
include_once TEMPLATES . "/global/head.php";
include_once TEMPLATES . "/global/header.php";

?>

<div id="main" class="wpx--intern">

  <?php include_once TEMPLATES . "/intern/_head_tools.php"; ?>

  <div class="intern--outer">

    <div class="rt-content">
      <?php include_once TEMPLATES . "/widgets/discord.html"; ?>
    </div>

    <div class="lt-content posrel">

      <div class="whole-line"></div>

      <div class="normal-box" id="m2">
        <div class="label-box" id="mOverview">
          <p class="trimt">Diensteanbieter</p>
        </div>

        <div class="nb-inr posrel" style="z-index:1;">
          <p>Justin-Leon Seidel</p>
          <p>Markt 5</p>
          <p>48565 Steinfurt</p>
          <p>Deutschland</p>

          <a href="<?php echo $url->intern; ?>/privacy" target="_blank">
            <div class="rd12 p12 mt12" style="background:rgba(0,0,0,.04);">
              <div class="posrel lt mr12 rd12"
                style="color:white;background:var(--colour-red);height:42px;width:42px;font-size:1.2em;">
                <i class="posabs alignmiddle ri-fingerprint-line"></i>
              </div>
              <div class="lt" style="line-height:1em;padding-top:.2em;">
                <div style="font-size:.8em;text-transform:uppercase;color:rgba(0,0,0,.32);">Link-To</div>
                <div>Datenschutzerklärung</div>
              </div>
              <div class="cl"></div>
            </div>
          </a>

        </div>
      </div>

      <div class="normal-box small-margin" id="m1">
        <div class="label-box" id="mOverview">
          <p class="trimt">Kontaktmöglichkeiten</p>

          <div class="nice-render-outer">
            <div class="nice-render"
              style="background:url(<?php echo IMAGE; ?>/intern/400/101.png) top center / cover no-repeat;">
            </div>
          </div>
        </div>

        <div class="nb-inr posrel" style="z-index:1;">

          <a href="mailto:justinleonseidel@proton.me" target="_blank">
            <div class="rd12 p12 mb12" style="background:rgba(0,0,0,.04);">
              <div class="posrel lt mr12 rd12"
                style="color:white;background:var(--colour-orange);height:42px;width:42px;font-size:1.2em;">
                <span class="posabs alignmiddle material-icons std">alternate_email</span>
              </div>
              <div class="lt" style="line-height:1em;padding-top:.2em;">
                <div style="font-size:.8em;text-transform:uppercase;color:rgba(0,0,0,.32);">E-Mail</div>
                <div>justinleonseidel@proton.me</div>
              </div>
              <div class="cl"></div>
            </div>
          </a>

          <div class="rd12 p12 mb12" style="background:rgba(0,0,0,.04);">
            <div class="posrel lt mr12 rd12"
              style="color:white;background:var(--colour-darkred);height:42px;width:42px;font-size:1.4em;">
              <i class="posabs alignmiddle ri-smartphone-line"></i>
            </div>
            <div class="lt" style="line-height:1em;padding-top:.2em;">
              <div style="font-size:.8em;text-transform:uppercase;color:rgba(0,0,0,.32);">MOBIL</div>
              <div>+49 176 21635892</div>
            </div>
            <div class="cl"></div>
          </div>

          <a href="https://discord.gg/cJM2hck4GD" target="_blank">
            <div class="rd12 p12" style="background:rgba(0,0,0,.04);">
              <div class="posrel lt mr12 rd12"
                style="color:white;background:#6570F7;height:42px;width:42px;font-size:1.2em;">
                <span class="posabs alignmiddle material-icons std">discord</span>
              </div>
              <div class="lt" style="line-height:1em;padding-top:.2em;">
                <div style="font-size:.8em;text-transform:uppercase;color:rgba(0,0,0,.32);">Discord</div>
                <div>&lt;brudermusscode/&gt;</div>
              </div>
              <div class="cl"></div>
            </div>
          </a>

          <div class="cl"></div>
        </div>
      </div>

      <div class="normal-box small-margin" id="m1">
        <div class="label-box" id="mOverview">
          <p class="trimt">Social Media und andere Onlinepräsenzen</p>
        </div>

        <div class="nb-inr posrel" style="z-index:1;">
          <p>Dieses Impressum gilt auch für die folgenden Social-Media-Präsenzen und Onlineprofile:</p>

          <a href="https://discord.gg/cJM2hck4GD" target="_blank">
            <div class="rd12 p12 mt12" style="background:rgba(0,0,0,.04);">
              <div class="posrel lt mr12 rd12"
                style="color:white;background:#6570F7;height:42px;width:42px;font-size:1.2em;">
                <span class="posabs alignmiddle material-icons std">discord</span>
              </div>
              <div class="lt" style="line-height:1em;padding-top:.2em;">
                <div style="font-size:.8em;text-transform:uppercase;color:rgba(0,0,0,.32);">Discord</div>
                <div>&lt;brudermusscode/&gt;</div>
              </div>
              <div class="cl"></div>
            </div>
          </a>

          <a href="https://www.twitch.tv/brudermusscode" target="_blank">
            <div class="rd12 p12 mt12" style="background:rgba(0,0,0,.04);">
              <div class="posrel lt mr12 rd12"
                style="color:white;background:var(--colour-lila);height:42px;width:42px;font-size:1.4em;">
                <i class="posabs alignmiddle ri-twitch-fill"></i>
              </div>
              <div class="lt" style="line-height:1em;padding-top:.2em;">
                <div style="font-size:.8em;text-transform:uppercase;color:rgba(0,0,0,.32);">Twitch</div>
                <div>brudermusscode</div>
              </div>
              <div class="cl"></div>
            </div>
          </a>

          <div class="cl"></div>
        </div>
      </div>

      <div class="normal-box small-margin" id="m1">
        <div class="label-box" id="disclaimer">
          <p class="trimt">Haftungs- und Schutzrechtshinweise</p>
        </div>

        <div class="nb-inr posrel" style="z-index:1;">
          <p><strong>Haftungsausschluss</strong>: Die Inhalte dieses Onlineangebotes wurden sorgfältig und nach unserem
            aktuellen Kenntnisstand erstellt, dienen jedoch nur der Information und entfalten keine rechtlich bindende
            Wirkung, sofern es sich nicht um gesetzlich verpflichtende Informationen (z.B. das Impressum, die
            Datenschutzerklärung, AGB oder verpflichtende Belehrungen von Verbrauchern) handelt. Wir behalten uns vor,
            die Inhalte vollständig oder teilweise zu ändern oder zu löschen, soweit vertragliche Verpflichtungen
            unberührt bleiben. Alle Angebote sind freibleibend und unverbindlich. </p>
          <p><strong>Links auf fremde Webseiten</strong>: Die Inhalte fremder Webseiten, auf die wir direkt oder
            indirekt verweisen, liegen außerhalb unseres Verantwortungsbereiches und wir machen sie uns nicht zu Eigen.
            Für alle Inhalte und Nachteile, die aus der Nutzung der in den verlinkten Webseiten aufrufbaren
            Informationen entstehen, übernehmen wir keine Verantwortung.</p>
          <p><strong>Urheberrechte und Markenrechte</strong>: Alle auf dieser Website dargestellten Inhalte, wie Texte,
            Fotografien, Grafiken, Marken und Warenzeichen sind durch die jeweiligen Schutzrechte (Urheberrechte,
            Markenrechte) geschützt. Die Verwendung, Vervielfältigung usw. unterliegen unseren Rechten oder den Rechten
            der jeweiligen Urheber bzw. Rechteinhaber.</p>
          <p><strong>Hinweise auf Rechtsverstöße</strong>: Sollten Sie innerhalb unseres Internetauftritts
            Rechtsverstöße bemerken, bitten wir Sie uns auf diese hinzuweisen. Wir werden rechtswidrige Inhalte und
            Links nach Kenntnisnahme unverzüglich entfernen.</p>
        </div>
      </div>

      <div class="normal-box small-margin" id="m1">

        <div class="nb-inr posrel" style="z-index:1;">
          <div style="background:white;" class="tac">
            <p class="seal"><a href="https://datenschutz-generator.de/?l=de"
                title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken." target="_blank"
                rel="noopener noreferrer nofollow">Erstellt mit kostenlosem Datenschutz-Generator.de von Dr. Thomas
                Schwenke</a></p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


<?php include_once TEMPLATES . "/global/footer.php"; ?>