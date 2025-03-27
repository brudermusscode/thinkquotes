<?php

use Bruder\Env\Env;

?>

<!-- Stylesheets -->
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.min.css" rel="stylesheet">

<link href="/assets/fonts/siimple-icons.css" rel="stylesheet">

<style>
  /** Material icons. */
  @font-face {
    font-family: Material Icons;
    font-style: normal;
    font-weight: 500;
    src: url(/assets/fonts/OpenMoji-color-colr0_svg.woff2) format("woff");
  }


  /** Material font */
  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 300;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/light.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1, u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 300;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/light.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf, u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 300;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/light.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da, u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215, u+feff, u+fffd;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 400;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/regular.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1, u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 400;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/regular.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf, u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 400;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/regular.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da, u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215, u+feff, u+fffd;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 500;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/medium.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1, u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 500;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/medium.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf, u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 500;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/medium.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da, u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215, u+feff, u+fffd;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 600;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/semibold.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1, u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 600;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/semibold.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf, u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 600;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/semibold.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da, u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215, u+feff, u+fffd;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 800;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/bold.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1, u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 800;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/bold.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf, u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: Material;
    font-style: normal;
    font-weight: 800;
    src: url(https://raw.githubusercontent.com/brudermusscode/heia.kim/master/fonts/jakarta-sans/bold.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da, u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215, u+feff, u+fffd;
  }


  /** Good readable font */

  /** Regular */
  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 400;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Regular.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1,
      u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 400;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Regular.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf,
      u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 400;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Regular.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da,
      u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215,
      u+feff, u+fffd;
  }

  /** Medium */
  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 500;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Medium.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1,
      u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 500;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Medium.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf,
      u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 500;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Medium.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da,
      u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215,
      u+feff, u+fffd;
  }

  /** SemiBold */
  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 600;
    src: url(/assets/fonts/ebgaramond/EBGaramond-SemiBold.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1,
      u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 600;
    src: url(/assets/fonts/ebgaramond/EBGaramond-SemiBold.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf,
      u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 600;
    src: url(/assets/fonts/ebgaramond/EBGaramond-SemiBold.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da,
      u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215,
      u+feff, u+fffd;
  }

  /** Bold */
  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 800;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Bold.ttf) format("truetype");
    unicode-range: u+0102-0103, u+0110-0111, u+0128-0129, u+0168-0169, u+01a0-01a1,
      u+01af-01b0, u+1ea0-1ef9, u+20ab;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 800;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Bold.ttf) format("truetype");
    unicode-range: u+0100-024f, u+0259, u+1e??, u+2020, u+20a0-20ab, u+20ad-20cf,
      u+2113, u+2c60-2c7f, u+a720-a7ff;
  }

  @font-face {
    font-display: swap;
    font-family: EBGARAMOND;
    font-style: normal;
    font-weight: 800;
    src: url(/assets/fonts/ebgaramond/EBGaramond-Bold.ttf) format("truetype");
    unicode-range: u+00??, u+0131, u+0152-0153, u+02bb-02bc, u+02c6, u+02da,
      u+02dc, u+2000-206f, u+2074, u+20ac, u+2122, u+2191, u+2193, u+2212, u+2215,
      u+feff, u+fffd;
  }
</style>

<!-- Javascript -->
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
  let __project = {
    environment: "<?php echo Env::get("ENVIRONMENT"); ?>",
  };

  let __page = {
    current: "<?php echo filter_input(INPUT_GET, "page", FILTER_SANITIZE_SPECIAL_CHARS); ?>",
    marked: "home",
    is_loading: false,
    is_darkmode: <?php echo APP->dark_mode_enabled == 0 ? "0" : "1"; ?>,
  };

  let __infinite_scroll = {
    page_offset: 1620,
    start: 0,
    limit: 40,
    reached_end: false,
    reached_full_end: false,
  };

  let __current_overlay = null;
  let __current_second_overlay;
  let __current_audio_element;
  let __current_hover_card;

  let __submit;
  let __submit_timeout = 0;
  let __submit_timeout_delay = 324;

  const echo = (msg) => {
    console.log(msg);
  };

  document.find = (selector) => {
    return document.querySelector(selector);
  };

  document.find_all = (selector) => {
    return document.querySelectorAll(selector);
  };

  Element.prototype.find = function(selector) {
    return this.querySelector(selector);
  };

  Element.prototype.find_all = function(selector) {
    return this.querySelectorAll(selector);
  };

  Element.prototype.disable = function(selector) {
    return this.setAttribute("disabled", "");
  };

  Element.prototype.disabled = function(selector) {
    return this.hasAttribute("disabled", "");
  };

  Element.prototype.enable = function(selector) {
    return this.removeAttribute("disabled");
  };

  Element.prototype.activate = function(selector) {
    return this.setAttribute("active", true);
  };

  Element.prototype.unactivate = function(selector) {
    return this.removeAttribute("active");
  };

  Element.prototype.set_inactive = function(selector) {
    return this.setAttribute("inactive", "");
  };

  Element.prototype.unset_inactive = function(selector) {
    return this.removeAttribute("inactive");
  };

  Element.prototype.set_not_active = function(selector) {
    return this.setAttribute("active", false);
  };

  Element.prototype.set_loading = function(selector) {
    return this.setAttribute("loading", "");
  };

  Element.prototype.unset_loading = function(selector) {
    return this.removeAttribute("loading");
  };

  Element.prototype.unstyle = function(selector) {
    return this.removeAttribute("style");
  };

  Element.prototype.make_tag = function(selector) {
    this.setAttribute("tag", "");
    this.enable();
    this.removeAttribute("submit-closest");
    this.removeAttribute("confirm-button");
    this.removeAttribute("submit");
    return;
  };

  Element.prototype.is_activated = function(selector) {
    return this.hasAttribute("active");
  };

  Element.prototype.fade_out = function(selector) {
    return this.setAttribute("invisible", "");
  };
</script>

<?php

/**
 * Pass get params to an js object.
 *
 * @param object __get_params Object making get params
 *    accessible in js code.
 */
include TEMPLATE . "/global/_get_params.js.php";

/**
 * Main JavaScript entry file.
 */
include TEMPLATE . "/global/_bundled_js.php";
