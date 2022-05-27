<?php

$is_page = true;
$page = "intern";
$subPage = "intern:privacy";
$pageTitle = "Privacy Policies";

// mysql database
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/init.php";

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

            <div class="normal-box" id="m1">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Einleitung</p>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Mit der folgenden Datenschutzerklärung möchten wir Sie darüber aufklären, welche Arten Ihrer personenbezogenen Daten (nachfolgend auch kurz als "Daten“ bezeichnet) wir zu welchen Zwecken und in welchem Umfang verarbeiten. Die Datenschutzerklärung gilt für alle von uns durchgeführten Verarbeitungen personenbezogener Daten, sowohl im Rahmen der Erbringung unserer Leistungen als auch insbesondere auf unseren Webseiten, in mobilen Applikationen sowie innerhalb externer Onlinepräsenzen, wie z.B. unserer Social-Media-Profile (nachfolgend zusammenfassend bezeichnet als "Onlineangebot“).</p>
                    <p>Die verwendeten Begriffe sind nicht geschlechtsspezifisch.</p>
                    <p style="background:rgba(230, 129, 152, 0.12);padding:0 18px;line-height:2.4;" class="rd6 rt">Stand: 5. September 2021</p>

                    <div class="cl"></div>
                </div>
            </div>

            <div class="normal-box" id="m2">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Verantwortlicher</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/28.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Justin-Leon Seidel</p>
                    <p>Driverstr. 7</p>
                    <p>49377 Vechta</p>
                    <p>Deutschland</p>

                    <div class="mt12">
                        <p class="posrel lt mr12" style="color:white;background:var(--colour-red);border-radius:50%;height:32px;width:32px;">
                            <i class="posabs alignmiddle material-icons std">alternate_email</i>
                        </p>
                        <p class="lt mt6">E-Mail Adresse: <a href="mailto:hou@thinkquotes.de">hou@thinkquotes.de</a></p>

                        <div class="cl"></div>
                    </div>

                    <div>
                        <p class="posrel lt mr12" style="color:white;background:var(--colour-bluegrey);border-radius:50%;height:32px;width:32px;">
                            <span class="posabs alignmiddle material-icons std">web</span>
                        </p>
                        <p class="lt mt6">Impressum: <a href="<?php echo $url->intern; ?>/imprint"><?php echo $url->intern; ?>/imprint</a></p>

                        <div class="cl"></div>
                    </div>

                </div>
            </div>

            <div class="normal-box">
                <div class="label-box">
                    <p class="trimt">Inhaltsübersicht</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/16.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <ul class="index">
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m1">Einleitung</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m2">Verantwortlicher</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#overview">Übersicht der Verarbeitungen</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m3">Maßgebliche Rechtsgrundlagen</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m27">Sicherheitsmaßnahmen</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m4">Datenverarbeitung in Drittländern</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m5">Löschung von Daten</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m6">Einsatz von Cookies</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m7">Bereitstellung des Onlineangebotes und Webhosting</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m8">Registrierung, Anmeldung und Nutzerkonto</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m9">Webanalyse, Monitoring und Optimierung</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m10">Onlinemarketing</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m11">Plugins und eingebettete Funktionen sowie Inhalte</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m12">Änderung und Aktualisierung der Datenschutzerklärung</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m13">Rechte der betroffenen Personen</a></li>
                        <li><span class="material-icons std lt mr12">keyboard_arrow_right</span><a class="index-link" href="#m14">Begriffsdefinitionen</a></li>
                    </ul>
                </div>
            </div>

            <div class="normal-box" id="overview">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Übersicht der Verarbeitung</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/render_856.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Die nachfolgende Übersicht fasst die Arten der verarbeiteten Daten und die Zwecke ihrer Verarbeitung zusammen und verweist auf die betroffenen Personen.</p>

                    <div class="section">
                        <div class="line"></div>

                        <div class="dot-outer">
                            <div class="dot"></div>

                            <h3>Arten der verarbeiteten Daten</h3>
                            <ul>
                                <li>Bestandsdaten (z.B. Namen, Adressen).</li>
                                <li>Inhaltsdaten (z.B. Eingaben in Onlineformularen).</li>
                                <li>Kontaktdaten (z.B. E-Mail, Telefonnummern).</li>
                                <li>Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
                                <li>Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).</li>
                                <li>Vertragsdaten (z.B. Vertragsgegenstand, Laufzeit, Kundenkategorie).</li>
                                <li>Zahlungsdaten (z.B. Bankverbindungen, Rechnungen, Zahlungshistorie).</li>
                            </ul>
                        </div>

                        <div class="dot-outer">
                            <div class="dot"></div>
                            <h3>Kategorien betroffener Personen</h3>
                            <ul>
                                <li>Kommunikationspartner.</li>
                                <li>Kunden.</li>
                                <li>Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
                            </ul>
                        </div>

                        <div class="dot-outer">
                            <div class="dot"></div>
                            <h3>Zwecke der Verarbeitung</h3>
                            <ul>
                                <li>Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.</li>
                                <li>Direktmarketing (z.B. per E-Mail oder postalisch).</li>
                                <li>Marketing.</li>
                                <li>Kontaktanfragen und Kommunikation.</li>
                                <li>Profile mit nutzerbezogenen Informationen (Erstellen von Nutzerprofilen).</li>
                                <li>Reichweitenmessung (z.B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher).</li>
                                <li>Sicherheitsmaßnahmen.</li>
                                <li>Erbringung vertraglicher Leistungen und Kundenservice.</li>
                                <li>Verwaltung und Beantwortung von Anfragen.</li>
                            </ul>
                        </div>

                        <div class="dot-outer" id="m3">
                            <div class="dot"></div>
                            <h3>Maßgebliche Rechtsgrundlagen</h3>
                            <p>Im Folgenden erhalten Sie eine Übersicht der Rechtsgrundlagen der DSGVO, auf deren Basis wir personenbezogene Daten verarbeiten. Bitte nehmen Sie zur Kenntnis, dass neben den Regelungen der DSGVO nationale Datenschutzvorgaben in Ihrem bzw. unserem Wohn- oder Sitzland gelten können. Sollten ferner im Einzelfall speziellere Rechtsgrundlagen maßgeblich sein, teilen wir Ihnen diese in der Datenschutzerklärung mit.</p>
                            <ul class="glossary">
                                <li><strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a. DSGVO)</strong> - Die betroffene Person hat ihre Einwilligung in die Verarbeitung der sie betreffenden personenbezogenen Daten für einen spezifischen Zweck oder mehrere bestimmte Zwecke gegeben.</li>
                                <li><strong>Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO)</strong> - Die Verarbeitung ist für die Erfüllung eines Vertrags, dessen Vertragspartei die betroffene Person ist, oder zur Durchführung vorvertraglicher Maßnahmen erforderlich, die auf Anfrage der betroffenen Person erfolgen.</li>
                                <li><strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO)</strong> - Die Verarbeitung ist zur Wahrung der berechtigten Interessen des Verantwortlichen oder eines Dritten erforderlich, sofern nicht die Interessen oder Grundrechte und Grundfreiheiten der betroffenen Person, die den Schutz personenbezogener Daten erfordern, überwiegen.</li>
                            </ul>
                            <p class="mt32"><strong>Nationale Datenschutzregelungen in Deutschland</strong>: Zusätzlich zu den Datenschutzregelungen der Datenschutz-Grundverordnung gelten nationale Regelungen zum Datenschutz in Deutschland. Hierzu gehört insbesondere das Gesetz zum Schutz vor Missbrauch personenbezogener Daten bei der Datenverarbeitung (Bundesdatenschutzgesetz – BDSG). Das BDSG enthält insbesondere Spezialregelungen zum Recht auf Auskunft, zum Recht auf Löschung, zum Widerspruchsrecht, zur Verarbeitung besonderer Kategorien personenbezogener Daten, zur Verarbeitung für andere Zwecke und zur Übermittlung sowie automatisierten Entscheidungsfindung im Einzelfall einschließlich Profiling. Des Weiteren regelt es die Datenverarbeitung für Zwecke des Beschäftigungsverhältnisses (§ 26 BDSG), insbesondere im Hinblick auf die Begründung, Durchführung oder Beendigung von Beschäftigungsverhältnissen sowie die Einwilligung von Beschäftigten. Ferner können Landesdatenschutzgesetze der einzelnen Bundesländer zur Anwendung gelangen.</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Sicherheitsmaßnahmen -->
            <div class="normal-box" id="m27">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Sicherheitsmaßnahmen</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="width:400px;background:url(<?php echo $url->img; ?>/intern/400/24.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Wir treffen nach Maßgabe der gesetzlichen Vorgaben unter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeiten und des Ausmaßes der Bedrohung der Rechte und Freiheiten natürlicher Personen geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten.</p>
                    <p>Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen und elektronischen Zugangs zu den Daten als auch des sie betreffenden Zugriffs, der Eingabe, der Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, die Löschung von Daten und Reaktionen auf die Gefährdung der Daten gewährleisten. Ferner berücksichtigen wir den Schutz personenbezogener Daten bereits bei der Entwicklung bzw. Auswahl von Hardware, Software sowie Verfahren entsprechend dem Prinzip des Datenschutzes, durch Technikgestaltung und durch datenschutzfreundliche Voreinstellungen.</p>
                    <p><strong>SSL-Verschlüsselung (https)</strong>: Um Ihre via unserem Online-Angebot übermittelten Daten zu schützen, nutzen wir eine SSL-Verschlüsselung. Sie erkennen derart verschlüsselte Verbindungen an dem Präfix https:// in der Adresszeile Ihres Browsers.</p>

                </div>
            </div>

            <!-- Datenverarbeitung in Drittländern -->
            <div class="normal-box" id="m4">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Datenverarbeitung in Drittländern</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/06.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Sofern wir Daten in einem Drittland (d.h., außerhalb der Europäischen Union (EU), des Europäischen Wirtschaftsraums (EWR)) verarbeiten oder die Verarbeitung im Rahmen der Inanspruchnahme von Diensten Dritter oder der Offenlegung bzw. Übermittlung von Daten an andere Personen, Stellen oder Unternehmen stattfindet, erfolgt dies nur im Einklang mit den gesetzlichen Vorgaben. </p>
                    <p>Vorbehaltlich ausdrücklicher Einwilligung oder vertraglich oder gesetzlich erforderlicher Übermittlung verarbeiten oder lassen wir die Daten nur in Drittländern mit einem anerkannten Datenschutzniveau, vertraglichen Verpflichtung durch sogenannte Standardschutzklauseln der EU-Kommission, beim Vorliegen von Zertifizierungen oder verbindlicher internen Datenschutzvorschriften verarbeiten (Art. 44 bis 49 DSGVO, Informationsseite der EU-Kommission: <a href="https://ec.europa.eu/info/law/law-topic/data-protection/international-dimension-data-protection_de" target="_blank">https://ec.europa.eu/info/law/law-topic/data-protection/international-dimension-data-protection_de</a>).</p>
                </div>
            </div>

            <!-- Löschung von Daten -->
            <div class="normal-box" id="m5">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Löschung von Daten</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/05.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Die von uns verarbeiteten Daten werden nach Maßgabe der gesetzlichen Vorgaben gelöscht, sobald deren zur Verarbeitung erlaubten Einwilligungen widerrufen werden oder sonstige Erlaubnisse entfallen (z.B. wenn der Zweck der Verarbeitung dieser Daten entfallen ist oder sie für den Zweck nicht erforderlich sind).</p>
                    <p>Sofern die Daten nicht gelöscht werden, weil sie für andere und gesetzlich zulässige Zwecke erforderlich sind, wird deren Verarbeitung auf diese Zwecke beschränkt. D.h., die Daten werden gesperrt und nicht für andere Zwecke verarbeitet. Das gilt z.B. für Daten, die aus handels- oder steuerrechtlichen Gründen aufbewahrt werden müssen oder deren Speicherung zur Geltendmachung, Ausübung oder Verteidigung von Rechtsansprüchen oder zum Schutz der Rechte einer anderen natürlichen oder juristischen Person erforderlich ist.</p>
                    <p>Unsere Datenschutzhinweise können ferner weitere Angaben zu der Aufbewahrung und Löschung von Daten beinhalten, die für die jeweiligen Verarbeitungen vorrangig gelten.</p>
                </div>
            </div>

            <!-- Einsatz von Cookies -->
            <div class="normal-box" id="m6">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Einsatz von Cookies</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/render_819.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Cookies sind Textdateien, die Daten von besuchten Websites oder Domains enthalten und von einem Browser auf dem Computer des Benutzers gespeichert werden. Ein Cookie dient in erster Linie dazu, die Informationen über einen Benutzer während oder nach seinem Besuch innerhalb eines Onlineangebotes zu speichern. Zu den gespeicherten Angaben können z.B. die Spracheinstellungen auf einer Webseite, der Loginstatus, ein Warenkorb oder die Stelle, an der ein Video geschaut wurde, gehören. Zu dem Begriff der Cookies zählen wir ferner andere Technologien, die die gleichen Funktionen wie Cookies erfüllen (z.B. wenn Angaben der Nutzer anhand pseudonymer Onlinekennzeichnungen gespeichert werden, auch als "Nutzer-IDs" bezeichnet)</p>
                    <p><strong>Die folgenden Cookie-Typen und Funktionen werden unterschieden:</strong></p>
                    <ul class="glossary">
                        <li><strong>Temporäre Cookies (auch: Session- oder Sitzungs-Cookies):</strong>&nbsp;Temporäre Cookies werden spätestens gelöscht, nachdem ein Nutzer ein Online-Angebot verlassen und seinen Browser geschlossen hat.</li>
                        <li><strong>Permanente Cookies:</strong>&nbsp;Permanente Cookies bleiben auch nach dem Schließen des Browsers gespeichert. So kann beispielsweise der Login-Status gespeichert oder bevorzugte Inhalte direkt angezeigt werden, wenn der Nutzer eine Website erneut besucht. Ebenso können die Interessen von Nutzern, die zur Reichweitenmessung oder zu Marketingzwecken verwendet werden, in einem solchen Cookie gespeichert werden.</li>
                        <li><strong>First-Party-Cookies:</strong>&nbsp;First-Party-Cookies werden von uns selbst gesetzt.</li>
                        <li><strong>Third-Party-Cookies (auch: Drittanbieter-Cookies)</strong>: Drittanbieter-Cookies werden hauptsächlich von Werbetreibenden (sog. Dritten) verwendet, um Benutzerinformationen zu verarbeiten.</li>
                        <li><strong>Notwendige (auch: essentielle oder unbedingt erforderliche) Cookies:</strong> Cookies können zum einen für den Betrieb einer Webseite unbedingt erforderlich sein (z.B. um Logins oder andere Nutzereingaben zu speichern oder aus Gründen der Sicherheit).</li>
                        <li><strong>Statistik-, Marketing- und Personalisierungs-Cookies</strong>: Ferner werden Cookies im Regelfall auch im Rahmen der Reichweitenmessung eingesetzt sowie dann, wenn die Interessen eines Nutzers oder sein Verhalten (z.B. Betrachten bestimmter Inhalte, Nutzen von Funktionen etc.) auf einzelnen Webseiten in einem Nutzerprofil gespeichert werden. Solche Profile dienen dazu, den Nutzern z.B. Inhalte anzuzeigen, die ihren potentiellen Interessen entsprechen. Dieses Verfahren wird auch als "Tracking", d.h., Nachverfolgung der potentiellen Interessen der Nutzer bezeichnet. Soweit wir Cookies oder "Tracking"-Technologien einsetzen, informieren wir Sie gesondert in unserer Datenschutzerklärung oder im Rahmen der Einholung einer Einwilligung.</li>
                    </ul>
                    <p class="mt32"><strong>Hinweise zu Rechtsgrundlagen: </strong> Auf welcher Rechtsgrundlage wir Ihre personenbezogenen Daten mit Hilfe von Cookies verarbeiten, hängt davon ab, ob wir Sie um eine Einwilligung bitten. Falls dies zutrifft und Sie in die Nutzung von Cookies einwilligen, ist die Rechtsgrundlage der Verarbeitung Ihrer Daten die erklärte Einwilligung. Andernfalls werden die mithilfe von Cookies verarbeiteten Daten auf Grundlage unserer berechtigten Interessen (z.B. an einem betriebswirtschaftlichen Betrieb unseres Onlineangebotes und dessen Verbesserung) verarbeitet oder, wenn der Einsatz von Cookies erforderlich ist, um unsere vertraglichen Verpflichtungen zu erfüllen.</p>
                    <p><strong>Speicherdauer: </strong>Sofern wir Ihnen keine expliziten Angaben zur Speicherdauer von permanenten Cookies mitteilen (z. B. im Rahmen eines sog. Cookie-Opt-Ins), gehen Sie bitte davon aus, dass die Speicherdauer bis zu zwei Jahre betragen kann.</p>
                    <p><strong>Allgemeine Hinweise zum Widerruf und Widerspruch (Opt-Out): </strong> Abhängig davon, ob die Verarbeitung auf Grundlage einer Einwilligung oder gesetzlichen Erlaubnis erfolgt, haben Sie jederzeit die Möglichkeit, eine erteilte Einwilligung zu widerrufen oder der Verarbeitung Ihrer Daten durch Cookie-Technologien zu widersprechen (zusammenfassend als "Opt-Out" bezeichnet). Sie können Ihren Widerspruch zunächst mittels der Einstellungen Ihres Browsers erklären, z.B., indem Sie die Nutzung von Cookies deaktivieren (wobei hierdurch auch die Funktionsfähigkeit unseres Onlineangebotes eingeschränkt werden kann). Ein Widerspruch gegen den Einsatz von Cookies zu Zwecken des Onlinemarketings kann auch mittels einer Vielzahl von Diensten, vor allem im Fall des Trackings, über die Webseiten <a href="https://optout.aboutads.info" target="_blank">https://optout.aboutads.info</a> und <a href="https://www.youronlinechoices.com/" target="_blank">https://www.youronlinechoices.com/</a> erklärt werden. Daneben können Sie weitere Widerspruchshinweise im Rahmen der Angaben zu den eingesetzten Dienstleistern und Cookies erhalten.</p>
                    <p><strong>Verarbeitung von Cookie-Daten auf Grundlage einer Einwilligung</strong>: Wir setzen ein Verfahren zum Cookie-Einwilligungs-Management ein, in dessen Rahmen die Einwilligungen der Nutzer in den Einsatz von Cookies, bzw. der im Rahmen des Cookie-Einwilligungs-Management-Verfahrens genannten Verarbeitungen und Anbieter eingeholt sowie von den Nutzern verwaltet und widerrufen werden können. Hierbei wird die Einwilligungserklärung gespeichert, um deren Abfrage nicht erneut wiederholen zu müssen und die Einwilligung entsprechend der gesetzlichen Verpflichtung nachweisen zu können. Die Speicherung kann serverseitig und/oder in einem Cookie (sogenanntes Opt-In-Cookie, bzw. mithilfe vergleichbarer Technologien) erfolgen, um die Einwilligung einem Nutzer, bzw. dessen Gerät zuordnen zu können. Vorbehaltlich individueller Angaben zu den Anbietern von Cookie-Management-Diensten, gelten die folgenden Hinweise: Die Dauer der Speicherung der Einwilligung kann bis zu zwei Jahren betragen. Hierbei wird ein pseudonymer Nutzer-Identifikator gebildet und mit dem Zeitpunkt der Einwilligung, Angaben zur Reichweite der Einwilligung (z. B. welche Kategorien von Cookies und/oder Diensteanbieter) sowie dem Browser, System und verwendeten Endgerät gespeichert.</p>
                    <ul class="glossary">
                        <li><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
                        <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
                        <li><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</li>
                    </ul>

                </div>
            </div>

            <!-- Bereitstellung des Onlineangebots und Webhosting -->
            <div class="normal-box" id="m7">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Bereitstellung des Onlineangebots und Webhosting</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/02.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Um unser Onlineangebot sicher und effizient bereitstellen zu können, nehmen wir die Leistungen von einem oder mehreren Webhosting-Anbietern in Anspruch, von deren Servern (bzw. von ihnen verwalteten Servern) das Onlineangebot abgerufen werden kann. Zu diesen Zwecken können wir Infrastruktur- und Plattformdienstleistungen, Rechenkapazität, Speicherplatz und Datenbankdienste sowie Sicherheitsleistungen und technische Wartungsleistungen in Anspruch nehmen.</p>
                    <p>Zu den im Rahmen der Bereitstellung des Hostingangebotes verarbeiteten Daten können alle die Nutzer unseres Onlineangebotes betreffenden Angaben gehören, die im Rahmen der Nutzung und der Kommunikation anfallen. Hierzu gehören regelmäßig die IP-Adresse, die notwendig ist, um die Inhalte von Onlineangeboten an Browser ausliefern zu können, und alle innerhalb unseres Onlineangebotes oder von Webseiten getätigten Eingaben.</p>
                    <p><strong>Erhebung von Zugriffsdaten und Logfiles</strong>: Wir selbst (bzw. unser Webhostinganbieter) erheben Daten zu jedem Zugriff auf den Server (sogenannte Serverlogfiles). Zu den Serverlogfiles können die Adresse und Name der abgerufenen Webseiten und Dateien, Datum und Uhrzeit des Abrufs, übertragene Datenmengen, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite) und im Regelfall IP-Adressen und der anfragende Provider gehören.</p>
                    <p>Die Serverlogfiles können zum einen zu Zwecken der Sicherheit eingesetzt werden, z.B., um eine Überlastung der Server zu vermeiden (insbesondere im Fall von missbräuchlichen Angriffen, sogenannten DDoS-Attacken) und zum anderen, um die Auslastung der Server und ihre Stabilität sicherzustellen.</p>
                    <ul class="glossary">
                        <li><strong>Verarbeitete Datenarten:</strong> Inhaltsdaten (z.B. Eingaben in Onlineformularen), Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
                        <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
                        <li><strong>Zwecke der Verarbeitung:</strong> Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.</li>
                        <li><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</li>
                    </ul>

                </div>
            </div>

            <!-- Registrierung, Anmeldung und Nutzerkonto -->
            <div class="normal-box" id="m8">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Registrierung, Anmeldung und Nutzerkonto</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/01.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Nutzer können ein Nutzerkonto anlegen. Im Rahmen der Registrierung werden den Nutzern die erforderlichen Pflichtangaben mitgeteilt und zu Zwecken der Bereitstellung des Nutzerkontos auf Grundlage vertraglicher Pflichterfüllung verarbeitet. Zu den verarbeiteten Daten gehören insbesondere die Login-Informationen (Nutzername, Passwort sowie eine E-Mail-Adresse).</p>
                    <p>Im Rahmen der Inanspruchnahme unserer Registrierungs- und Anmeldefunktionen sowie der Nutzung des Nutzerkontos speichern wir die IP-Adresse und den Zeitpunkt der jeweiligen Nutzerhandlung. Die Speicherung erfolgt auf Grundlage unserer berechtigten Interessen als auch jener der Nutzer an einem Schutz vor Missbrauch und sonstiger unbefugter Nutzung. Eine Weitergabe dieser Daten an Dritte erfolgt grundsätzlich nicht, es sei denn, sie ist zur Verfolgung unserer Ansprüche erforderlich oder es besteht eine gesetzliche Verpflichtung hierzu.</p>
                    <p>Die Nutzer können über Vorgänge, die für deren Nutzerkonto relevant sind, wie z.B. technische Änderungen, per E-Mail informiert werden.</p>
                    <p><strong>Registrierung mit Pseudonymen</strong>: Nutzer dürfen statt Klarnamen Pseudonyme als Nutzernamen verwenden.</p>
                    <p><strong>Profile der Nutzer sind öffentlich</strong>: Die Profile der Nutzer sind öffentlich sichtbar und zugänglich.</p>
                    <p><strong>Einstellung der Sichtbarkeit von Profilen</strong>: Die Nutzer können mittels Einstellungen bestimmen, in welchem Umfang ihre Profile für die Öffentlichkeit oder nur für bestimmte Personengruppen sichtbar, bzw. zugänglich sind.</p>
                    <p><strong>Löschung von Daten nach Kündigung</strong>: Wenn Nutzer ihr Nutzerkonto gekündigt haben, werden deren Daten im Hinblick auf das Nutzerkonto, vorbehaltlich einer gesetzlichen Erlaubnis, Pflicht oder Einwilligung der Nutzer, gelöscht.</p>
                    <p>Es obliegt den Nutzern, ihre Daten bei erfolgter Kündigung vor dem Vertragsende zu sichern. Wir sind berechtigt, sämtliche während der Vertragsdauer gespeicherte Daten des Nutzers unwiederbringlich zu löschen.</p>
                    <ul class="m-elements">
                        <li><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B. E-Mail, Telefonnummern), Inhaltsdaten (z.B. Eingaben in Onlineformularen), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
                        <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
                        <li><strong>Zwecke der Verarbeitung:</strong> Erbringung vertraglicher Leistungen und Kundenservice, Sicherheitsmaßnahmen, Verwaltung und Beantwortung von Anfragen.</li>
                        <li><strong>Rechtsgrundlagen:</strong> Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</li>
                    </ul>
                </div>
            </div>

            <!-- Webanalyse, Monitoring und Optimierung -->
            <div class="normal-box" id="m9">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Webanalyse, Monitoring und Optimierung</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/04.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Die Webanalyse (auch als "Reichweitenmessung" bezeichnet) dient der Auswertung der Besucherströme unseres Onlineangebotes und kann Verhalten, Interessen oder demographische Informationen zu den Besuchern, wie z.B. das Alter oder das Geschlecht, als pseudonyme Werte umfassen. Mit Hilfe der Reichweitenanalyse können wir z.B. erkennen, zu welcher Zeit unser Onlineangebot oder dessen Funktionen oder Inhalte am häufigsten genutzt werden oder zur Wiederverwendung einladen. Ebenso können wir nachvollziehen, welche Bereiche der Optimierung bedürfen. </p>
                    <p>Neben der Webanalyse können wir auch Testverfahren einsetzen, um z.B. unterschiedliche Versionen unseres Onlineangebotes oder seiner Bestandteile zu testen und optimieren.</p>
                    <p>Zu diesen Zwecken können sogenannte Nutzerprofile angelegt und in einer Datei (sogenannte "Cookie") gespeichert oder ähnliche Verfahren mit dem gleichen Zweck genutzt werden. Zu diesen Angaben können z.B. betrachtete Inhalte, besuchte Webseiten und dort genutzte Elemente und technische Angaben, wie der verwendete Browser, das verwendete Computersystem sowie Angaben zu Nutzungszeiten gehören. Sofern Nutzer in die Erhebung ihrer Standortdaten eingewilligt haben, können je nach Anbieter auch diese verarbeitet werden.</p>
                    <p>Es werden ebenfalls die IP-Adressen der Nutzer gespeichert. Jedoch nutzen wir ein IP-Masking-Verfahren (d.h., Pseudonymisierung durch Kürzung der IP-Adresse) zum Schutz der Nutzer. Generell werden die im Rahmen von Webanalyse, A/B-Testings und Optimierung keine Klardaten der Nutzer (wie z.B. E-Mail-Adressen oder Namen) gespeichert, sondern Pseudonyme. D.h., wir als auch die Anbieter der eingesetzten Software kennen nicht die tatsächliche Identität der Nutzer, sondern nur den für Zwecke der jeweiligen Verfahren in deren Profilen gespeicherten Angaben.</p>
                    <p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.</p>
                    <ul class="glossary">
                        <li><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
                        <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
                        <li><strong>Zwecke der Verarbeitung:</strong> Reichweitenmessung (z.B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher), Profile mit nutzerbezogenen Informationen (Erstellen von Nutzerprofilen).</li>
                        <li><strong>Sicherheitsmaßnahmen:</strong> IP-Masking (Pseudonymisierung der IP-Adresse).</li>
                        <li><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</li>
                    </ul>
                    <p><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p>
                    <ul class="glossary">
                        <li><strong>Google Analytics:</strong> Reichweitenmessung und Webanalyse; Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://marketingplatform.google.com/intl/de/about/analytics/" target="_blank">https://marketingplatform.google.com/intl/de/about/analytics/</a>; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>.</li>
                    </ul>


                </div>
            </div>

            <!-- Onlinemarketing -->
            <div class="normal-box" id="m10">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Onlinemarketing</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/15.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Wir verarbeiten personenbezogene Daten zu Zwecken des Onlinemarketings, worunter insbesondere die Vermarktung von Werbeflächen oder Darstellung von werbenden und sonstigen Inhalten (zusammenfassend als "Inhalte" bezeichnet) anhand potentieller Interessen der Nutzer sowie die Messung ihrer Effektivität fallen kann. </p>
                    <p>Zu diesen Zwecken werden sogenannte Nutzerprofile angelegt und in einer Datei (sogenannte "Cookie") gespeichert oder ähnliche Verfahren genutzt, mittels derer die für die Darstellung der vorgenannten Inhalte relevante Angaben zum Nutzer gespeichert werden. Zu diesen Angaben können z.B. betrachtete Inhalte, besuchte Webseiten, genutzte Onlinenetzwerke, aber auch Kommunikationspartner und technische Angaben, wie der verwendete Browser, das verwendete Computersystem sowie Angaben zu Nutzungszeiten gehören. Sofern Nutzer in die Erhebung ihrer Standortdaten eingewilligt haben, können auch diese verarbeitet werden.</p>
                    <p>Es werden ebenfalls die IP-Adressen der Nutzer gespeichert. Jedoch nutzen wir zur Verfügung stehende IP-Masking-Verfahren (d.h., Pseudonymisierung durch Kürzung der IP-Adresse) zum Schutz der Nutzer. Generell werden im Rahmen des Onlinemarketingverfahren keine Klardaten der Nutzer (wie z.B. E-Mail-Adressen oder Namen) gespeichert, sondern Pseudonyme. D.h., wir als auch die Anbieter der Onlinemarketingverfahren kennen nicht die tatsächlich Identität der Nutzer, sondern nur die in deren Profilen gespeicherten Angaben.</p>
                    <p>Die Angaben in den Profilen werden im Regelfall in den Cookies oder mittels ähnlicher Verfahren gespeichert. Diese Cookies können später generell auch auf anderen Webseiten die dasselbe Onlinemarketingverfahren einsetzen, ausgelesen und zu Zwecken der Darstellung von Inhalten analysiert als auch mit weiteren Daten ergänzt und auf dem Server des Onlinemarketingverfahrensanbieters gespeichert werden.</p>
                    <p>Ausnahmsweise können Klardaten den Profilen zugeordnet werden. Das ist der Fall, wenn die Nutzer z.B. Mitglieder eines sozialen Netzwerks sind, dessen Onlinemarketingverfahren wir einsetzen und das Netzwerk die Profile der Nutzer mit den vorgenannten Angaben verbindet. Wir bitten darum, zu beachten, dass Nutzer mit den Anbietern zusätzliche Abreden, z.B. durch Einwilligung im Rahmen der Registrierung, treffen können.</p>
                    <p>Wir erhalten grundsätzlich nur Zugang zu zusammengefassten Informationen über den Erfolg unserer Werbeanzeigen. Jedoch können wir im Rahmen sogenannter Konversionsmessungen prüfen, welche unserer Onlinemarketingverfahren zu einer sogenannten Konversion geführt haben, d.h. z.B., zu einem Vertragsschluss mit uns. Die Konversionsmessung wird alleine zur Analyse des Erfolgs unserer Marketingmaßnahmen verwendet.</p>
                    <p>Solange nicht anders angegeben, bitten wir Sie davon auszugehen, dass verwendete Cookies für einen Zeitraum von zwei Jahren gespeichert werden.</p>
                    <p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.</p>
                    <ul class="glossary">
                        <li><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
                        <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
                        <li><strong>Zwecke der Verarbeitung:</strong> Marketing, Profile mit nutzerbezogenen Informationen (Erstellen von Nutzerprofilen).</li>
                        <li><strong>Sicherheitsmaßnahmen:</strong> IP-Masking (Pseudonymisierung der IP-Adresse).</li>
                        <li><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</li>
                        <li><strong>Widerspruchsmöglichkeit (Opt-Out):</strong> Wir verweisen auf die Datenschutzhinweise der jeweiligen Anbieter und die zu den Anbietern angegebenen Widerspruchsmöglichkeiten (sog. "Opt-Out"). Sofern keine explizite Opt-Out-Möglichkeit angegeben wurde, besteht zum einen die Möglichkeit, dass Sie Cookies in den Einstellungen Ihres Browsers abschalten. Hierdurch können jedoch Funktionen unseres Onlineangebotes eingeschränkt werden. Wir empfehlen daher zusätzlich die folgenden Opt-Out-Möglichkeiten, die zusammenfassend auf jeweilige Gebiete gerichtet angeboten werden:

                            a) Europa: <a href="https://www.youronlinechoices.eu" target="_blank">https://www.youronlinechoices.eu</a>.
                            b) Kanada: <a href="https://www.youradchoices.ca/choices" target="_blank">https://www.youradchoices.ca/choices</a>.
                            c) USA: <a href="https://www.aboutads.info/choices" target="_blank">https://www.aboutads.info/choices</a>.
                            d) Gebietsübergreifend: <a href="https://optout.aboutads.info" target="_blank">https://optout.aboutads.info</a>.</li>
                    </ul>

                    <p class="mt32"><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p>
                    <ul class="glossary">
                        <div class="section">

                            <div class="line"></div>

                            <li>
                                <div class="dot-outer">
                                    <div class="dot"></div>
                                    <strong>Google Analytics:</strong> Onlinemarketing und Webanalyse; Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://marketingplatform.google.com/intl/de/about/analytics/" target="_blank">https://marketingplatform.google.com/intl/de/about/analytics/</a>; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>; Widerspruchsmöglichkeit (Opt-Out): Opt-Out-Plugin: <a href="https://tools.google.com/dlpage/gaoptout?hl=de" target="_blank">https://tools.google.com/dlpage/gaoptout?hl=de</a>, Einstellungen für die Darstellung von Werbeeinblendungen: <a href="https://adssettings.google.com/authenticated" target="_blank">https://adssettings.google.com/authenticated</a>.
                                </div>
                            </li>
                            <li>
                                <div class="dot-outer">
                                    <div class="dot"></div><strong>Google Adsense mit personalisierten Anzeigen:</strong> Wir nutzen den Dienst Google Adsense mit personalisierten Anzeigen, mit dessen Hilfe innerhalb unseres Onlineangebotes Anzeigen eingeblendet werden und wir für deren Einblendung oder sonstige Nutzung eine Entlohnung erhalten; Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Ireland, parent company: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://marketingplatform.google.com" target="_blank">https://marketingplatform.google.com</a>; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>
                                </div>
                            </li>
                        </div>

                    </ul>


                </div>
            </div>

            <!-- plugins -->
            <div class="normal-box" id="m11">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Plugins und eingebettete Funktionen sowie Inhalte</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/20.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">

                    <p>Wir binden in unser Onlineangebot Funktions- und Inhaltselemente ein, die von den Servern ihrer jeweiligen Anbieter (nachfolgend bezeichnet als "Drittanbieter”) bezogen werden. Dabei kann es sich zum Beispiel um Grafiken, Videos oder Stadtpläne handeln (nachfolgend einheitlich bezeichnet als "Inhalte”).</p>
                    <p>Die Einbindung setzt immer voraus, dass die Drittanbieter dieser Inhalte die IP-Adresse der Nutzer verarbeiten, da sie ohne die IP-Adresse die Inhalte nicht an deren Browser senden könnten. Die IP-Adresse ist damit für die Darstellung dieser Inhalte oder Funktionen erforderlich. Wir bemühen uns, nur solche Inhalte zu verwenden, deren jeweilige Anbieter die IP-Adresse lediglich zur Auslieferung der Inhalte verwenden. Drittanbieter können ferner sogenannte Pixel-Tags (unsichtbare Grafiken, auch als "Web Beacons" bezeichnet) für statistische oder Marketingzwecke verwenden. Durch die "Pixel-Tags" können Informationen, wie der Besucherverkehr auf den Seiten dieser Webseite, ausgewertet werden. Die pseudonymen Informationen können ferner in Cookies auf dem Gerät der Nutzer gespeichert werden und unter anderem technische Informationen zum Browser und zum Betriebssystem, zu verweisenden Webseiten, zur Besuchszeit sowie weitere Angaben zur Nutzung unseres Onlineangebotes enthalten als auch mit solchen Informationen aus anderen Quellen verbunden werden.</p>
                    <p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.</p>
                    <ul class="glossary">
                        <li><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
                        <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
                        <li><strong>Zwecke der Verarbeitung:</strong> Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit, Erbringung vertraglicher Leistungen und Kundenservice.</li>
                        <li><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</li>
                    </ul>


                    <p class="mt32"><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p>
                    <div class="section">

                        <div class="line"></div>

                        <ul class="glossary">


                            <li>
                                <div class="dot-outer">
                                    <div class="dot"></div><strong>Google Fonts:</strong> Wir binden die Schriftarten ("Google Fonts") des Anbieters Google ein, wobei die Daten der Nutzer allein zu Zwecken der Darstellung der Schriftarten im Browser der Nutzer verwendet werden. Die Einbindung erfolgt auf Grundlage unserer berechtigten Interessen an einer technisch sicheren, wartungsfreien und effizienten Nutzung von Schriftarten, deren einheitlicher Darstellung sowie unter Berücksichtigung möglicher lizenzrechtlicher Restriktionen für deren Einbindung. Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://fonts.google.com/" target="_blank">https://fonts.google.com/</a>; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>.
                                </div>
                            </li>


                        </ul>
                    </div>
                </div>

            </div>

            <!-- Änderung und Aktualisierung der Datenschutzerklärung -->
            <div class="normal-box" id="m12">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Änderung und Aktualisierung der Datenschutzerklärung</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/08.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Wir bitten Sie, sich regelmäßig über den Inhalt unserer Datenschutzerklärung zu informieren. Wir passen die Datenschutzerklärung an, sobald die Änderungen der von uns durchgeführten Datenverarbeitungen dies erforderlich machen. Wir informieren Sie, sobald durch die Änderungen eine Mitwirkungshandlung Ihrerseits (z.B. Einwilligung) oder eine sonstige individuelle Benachrichtigung erforderlich wird.</p>
                    <p>Sofern wir in dieser Datenschutzerklärung Adressen und Kontaktinformationen von Unternehmen und Organisationen angeben, bitten wir zu beachten, dass die Adressen sich über die Zeit ändern können und bitten die Angaben vor Kontaktaufnahme zu prüfen.</p>

                </div>
            </div>

            <!-- Rechte der betroffenen Personen -->
            <div class="normal-box" id="m13">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Rechte der betroffenen Personen</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/09.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>Ihnen stehen als Betroffene nach der DSGVO verschiedene Rechte zu, die sich insbesondere aus Art. 15 bis 21 DSGVO ergeben:</p>
                    <ul class="glossary">
                        <li><strong>Widerspruchsrecht:</strong> Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, jederzeit gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten, die aufgrund von Art. 6 Abs. 1 lit. e oder f DSGVO erfolgt, Widerspruch einzulegen; dies gilt auch für ein auf diese Bestimmungen gestütztes Profiling. Werden die Sie betreffenden personenbezogenen Daten verarbeitet, um Direktwerbung zu betreiben, haben Sie das Recht, jederzeit Widerspruch gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten zum Zwecke derartiger Werbung einzulegen; dies gilt auch für das Profiling, soweit es mit solcher Direktwerbung in Verbindung steht.</li>
                        <li><strong>Widerrufsrecht bei Einwilligungen:</strong> Sie haben das Recht, erteilte Einwilligungen jederzeit zu widerrufen.</li>
                        <li><strong>Auskunftsrecht:</strong> Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere Informationen und Kopie der Daten entsprechend den gesetzlichen Vorgaben.</li>
                        <li><strong>Recht auf Berichtigung:</strong> Sie haben entsprechend den gesetzlichen Vorgaben das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.</li>
                        <li><strong>Recht auf Löschung und Einschränkung der Verarbeitung:</strong> Sie haben nach Maßgabe der gesetzlichen Vorgaben das Recht, zu verlangen, dass Sie betreffende Daten unverzüglich gelöscht werden, bzw. alternativ nach Maßgabe der gesetzlichen Vorgaben eine Einschränkung der Verarbeitung der Daten zu verlangen.</li>
                        <li><strong>Recht auf Datenübertragbarkeit:</strong> Sie haben das Recht, Sie betreffende Daten, die Sie uns bereitgestellt haben, nach Maßgabe der gesetzlichen Vorgaben in einem strukturierten, gängigen und maschinenlesbaren Format zu erhalten oder deren Übermittlung an einen anderen Verantwortlichen zu fordern.</li>
                        <li><strong>Beschwerde bei Aufsichtsbehörde:</strong> Sie haben unbeschadet eines anderweitigen verwaltungsrechtlichen oder gerichtlichen Rechtsbehelfs das Recht auf Beschwerde bei einer Aufsichtsbehörde, insbesondere in dem Mitgliedstaat ihres gewöhnlichen Aufenthaltsorts, ihres Arbeitsplatzes oder des Orts des mutmaßlichen Verstoßes, wenn Sie der Ansicht sind, dass die Verarbeitung der Sie betreffenden personenbezogenen Daten gegen die Vorgaben der DSGVO verstößt.</li>
                    </ul>

                </div>
            </div>

            <!-- Begriffsdefinitionen -->
            <div class="normal-box small-margin" id="m14">
                <div class="label-box" id="mOverview">
                    <p class="trimt">Begriffsdefinitionen</p>

                    <div class="nice-render-outer">
                        <div class="nice-render" style="background:url(<?php echo $url->img; ?>/intern/400/12.png) top center / cover no-repeat;">
                        </div>
                    </div>
                </div>

                <style>
                    .glossary li {
                        margin-top: 12px;
                    }
                </style>

                <div class="nb-inr posrel" style="z-index:1;">
                    <p>In diesem Abschnitt erhalten Sie eine Übersicht über die in dieser Datenschutzerklärung verwendeten Begrifflichkeiten. Viele der Begriffe sind dem Gesetz entnommen und vor allem im Art. 4 DSGVO definiert. Die gesetzlichen Definitionen sind verbindlich. Die nachfolgenden Erläuterungen sollen dagegen vor allem dem Verständnis dienen. Die Begriffe sind alphabetisch sortiert.</p>
                    <ul class="glossary">
                        <li><strong>IP-Masking:</strong> Als "IP-Masking” wird eine Methode bezeichnet, bei der das letzte Oktett, d.h., die letzten beiden Zahlen einer IP-Adresse, gelöscht wird, damit die IP-Adresse nicht mehr der eindeutigen Identifizierung einer Person dienen kann. Daher ist das IP-Masking ein Mittel zur Pseudonymisierung von Verarbeitungsverfahren, insbesondere im Onlinemarketing </li>
                        <li><strong>Personenbezogene Daten:</strong> "Personenbezogene Daten“ sind alle Informationen, die sich auf eine identifizierte oder identifizierbare natürliche Person (im Folgenden "betroffene Person“) beziehen; als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer Online-Kennung (z.B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden kann, die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen oder sozialen Identität dieser natürlichen Person sind. </li>
                        <li><strong>Profile mit nutzerbezogenen Informationen:</strong> Die Verarbeitung von "Profilen mit nutzerbezogenen Informationen", bzw. kurz "Profilen" umfasst jede Art der automatisierten Verarbeitung personenbezogener Daten, die darin besteht, dass diese personenbezogenen Daten verwendet werden, um bestimmte persönliche Aspekte, die sich auf eine natürliche Person beziehen (je nach Art der Profilbildung können dazu unterschiedliche Informationen betreffend die Demographie, Verhalten und Interessen, wie z.B. die Interaktion mit Webseiten und deren Inhalten, etc.) zu analysieren, zu bewerten oder, um sie vorherzusagen (z.B. die Interessen an bestimmten Inhalten oder Produkten, das Klickverhalten auf einer Webseite oder den Aufenthaltsort). Zu Zwecken des Profilings werden häufig Cookies und Web-Beacons eingesetzt. </li>
                        <li><strong>Reichweitenmessung:</strong> Die Reichweitenmessung (auch als Web Analytics bezeichnet) dient der Auswertung der Besucherströme eines Onlineangebotes und kann das Verhalten oder Interessen der Besucher an bestimmten Informationen, wie z.B. Inhalten von Webseiten, umfassen. Mit Hilfe der Reichweitenanalyse können Webseiteninhaber z.B. erkennen, zu welcher Zeit Besucher ihre Webseite besuchen und für welche Inhalte sie sich interessieren. Dadurch können sie z.B. die Inhalte der Webseite besser an die Bedürfnisse ihrer Besucher anpassen. Zu Zwecken der Reichweitenanalyse werden häufig pseudonyme Cookies und Web-Beacons eingesetzt, um wiederkehrende Besucher zu erkennen und so genauere Analysen zur Nutzung eines Onlineangebotes zu erhalten. </li>
                        <li><strong>Verantwortlicher:</strong> Als "Verantwortlicher“ wird die natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet. </li>
                        <li><strong>Verarbeitung:</strong> "Verarbeitung" ist jeder mit oder ohne Hilfe automatisierter Verfahren ausgeführte Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten, sei es das Erheben, das Auswerten, das Speichern, das Übermitteln oder das Löschen. </li>
                    </ul>

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

        <div class="cl"></div>
    </div>

</div>

<?php include_once TEMPLATES . "/global/footer.php"; ?>