import * as Setting from "./settings.js";
import * as Cookie from "./cookies.js";
import * as Image from "./images.js";
import * as Audio from "./audio.js";
import * as Page from "./page.js";
import * as Utils from "./utils.js";
import * as Frontend from "./frontend.js";
import * as Responder from "./elements/responder.js";

if (!Setting.LOG) console.log = () => {};

/**
 * For search
 */
let __type_search_timeout = null;

document.addEventListener("DOMContentLoaded", async () => {
  let images = document.querySelectorAll("img");
  let overlay_loading = document.querySelector("overlay[loading-app]");

  /**
   * KEYBOARD SHORTCUT
   */
  document.addEventListener("keyup", (e) => {
    if (!e.key) return;

    /**
     * ? ESC
     */
    if (e.key.toLowerCase() === "escape") {
    }
  });

  /**
   * Close all compose ui elements on scroll.
   */
  $(window).on("scroll", function (e) {
    Frontend.close_composer();
  });

  /**
   * Initialize the application.
   */
  await init_application(overlay_loading, images, Setting.INIT_TIMEOUT);

  /**
   * Generalize click event listeners
   */
  document.addEventListener("click", async function (e) {
    let anchor = e.target.closest("a");
    let href;

    /**
     * Close jump menu
     */
    // if (jumper)
    //   jumper.unactivate();

    if (anchor !== null) {
      href = anchor.getAttribute("href");

      if (!anchor.hasAttribute("extern") && href) {
        e.preventDefault();

        await Page.get(href, false, anchor);
      }
    }
  });

  /**
   * Generalize keypress events
   */
  document.addEventListener("keypress", function (e) {
    if (!e.key) return;

    if (e.key.toLowerCase() === "enter") e.preventDefault();
    if (
      e.key.toLowerCase() === "enter" &&
      (e.target.tagName.toLowerCase() === "input" ||
        e.target.tagName.toLowerCase() === "textarea") &&
      e.target.hasAttribute("enter-submitable")
    ) {
      e.preventDefault();

      let form = e.target.closest("form");
      let button = form.querySelector("[submit-closest]");
      if (form && button && !button.hasAttribute("disabled")) button.click();
    }
  });

  /**
   * Generalite scroll event
   */
  document.addEventListener("scroll", (e) => {
    let $scroll_container = document.body.querySelectorAll(
      "[scroll-manipulated]"
    );

    if (!$scroll_container[0]) return;

    if (
      document.documentElement.scrollTop >= 40 ||
      document.body.scrollTop >= 40
    ) {
      $scroll_container.forEach((s) => {
        s.setAttribute("scrolled", true);
      });
    } else {
      $scroll_container.forEach((s) => {
        s.setAttribute("scrolled", false);
      });
    }
  });

  /**
   * Popstate event (going back in history)
   */
  window.addEventListener("popstate", async (e) => {
    if (!e.state) return;

    Frontend.close_overlays();

    if (e.state.href == undefined || !e.state.href) return;

    await Page.get(e.state.href, true);
  });
});

/**
 * Initialize the application
 */
const init_application = async (overlay, images, sleeper) => {
  let __init_overlay = $(document).find("overlay[loading-app]");

  __init_overlay.find("[logo-icon]").css({
    scale: "1",
    opacity: "1",
  });

  setTimeout(() => {
    __init_overlay.find("[logo-icon]").css({
      marginTop: "0em",
      marginBottom: "0em",
    });

    __init_overlay.find("[logo-text]").css({
      scale: "1",
      opacity: "1",
    });

    setTimeout(async () => {
      /** Get the current page */
      await Page.get(window.location.pathname + window.location.search, true);
    }, 600);
  }, 400);

  console.log(
    "%c🌞 Framework/Bruder loaded!",
    "color:light-blue;font-size:1.32em;font-weight:800;",
    "\nheia.kim ©️ 2022-" + new Date().getFullYear()
  );

  /**
   * Set the application to be initialized.
   */
  __init = true;
};

export const get_cookie_domain = () => {
  let explode = window.location.hostname.split(".");
  let cookie_domain =
    window.location.hostname === "localhost"
      ? window.location.hostname
      : explode.join(".");

  return cookie_domain;
};

/**
 * click sound
 */
document.addEventListener("keypress", function () {
  if (__page.is_sounds_enabled) {
    Audio.stop("[click-audio]");
    Audio.play("[click-audio]");
  }
});

/**
 * Creates a button of type submit inside the closest form and
 * triggers a click event on it.
 */
$(document).on("click", "[submit-closest]", function (e) {
  let form = this.closest("form");

  if (!form) return;

  let submit_button = form.querySelector("button[type='submit']");

  if (!submit_button) {
    submit_button = document.createElement("button");
    submit_button.setAttribute("type", "submit");
  }

  form.appendChild(submit_button);
  form.querySelector("button[type='submit']").click();

  if (this.hasAttribute("confirm-submit-button"))
    this.removeAttribute("submit-closest");
});

$(document).on("click", "[confirm-submit-button]", function (e) {
  if (this.hasAttribute("disabled")) return;

  this.setAttribute("submit-closest", "");
});

/**
 * Confirm button
 */
let __submit_confirm_backup_text;
let __submit_confirm_backup_background_value;
let __submit_confirm_is_before_content = false;
Utils.delegate(document, "click", "[confirm]", async function (e) {
  e.preventDefault();

  if (this.hasAttribute("disabled")) return;

  let button_text = this.querySelector(".text");
  let button_before = window.getComputedStyle(button_text, "::before");

  if (!this.hasAttribute("submit-closest")) {
    __submit_confirm_backup_background_value = this.getAttribute("background");

    if (button_before.content != "none") {
      __submit_confirm_is_before_content = true;
      this.setAttribute("sureconfirm", "");
    } else {
      __submit_confirm_backup_text = button_text.innerHTML;
      button_text.innerHTML = "Are you sure?";
      this.setAttribute("color", "white");
    }

    this.setAttribute("submit-closest", "");
    this.setAttribute("background", "red");

    return;
  } else {
    if (__submit_confirm_is_before_content) {
      __submit_confirm_is_before_content = false;
      this.removeAttribute("sureconfirm");
    } else button_text.innerHTML = __submit_confirm_backup_text;

    this.removeAttribute("color");
    this.setAttribute("disabled", "");
    this.setAttribute("background", __submit_confirm_backup_background_value);
    __submit_confirm_backup_text = null;

    this.removeAttribute("submit-closest");

    return;
  }
});

/** Form input/change handler */
Utils.delegate(document, "input", "form", function (e) {
  e.preventDefault();

  let button = this.querySelector("[confirm]");

  if (!button) return;

  let input = e.target;
  let input_backup = input.dataset.backup;

  if (input.value === input_backup) button.setAttribute("disabled", "");
  else button.removeAttribute("disabled");
});

/**
 * Copy to clipboard
 */
let clipboard_copy = (text) => {
  navigator.clipboard.writeText(text).then(() => {
    new Responder.Responder().add(
      document.body,
      "Copied to clipboard!",
      "success",
      "keyevent"
    );
  });
};

Utils.delegate(document, "click", "[clipboard-copy]", function (e) {
  let tocopy = this.getAttribute("clipboard-copy");
  clipboard_copy(tocopy);
});

/**
 * Appends loading module (material)
 */
export const append_material_loader = async function (appendix) {
  appendix.insertAdjacentHTML(
    "afterbegin",
    '<div style="position:absolute;top:0;left:0;width:100%;" class="linear-progress-material"><div class="bar bar1"></div><div class="bar bar2"></div></div>'
  );

  return appendix.querySelector(".linear-progress-material");
};

/**
 * Enable or disable HTML elements
 */
export const disable = async (element) => {
  return element.setAttribute("disabled", "");
};

export const enable = async (element) => {
  return element.removeAttribute("disabled");
};

/**
 * Resize textareas on input
 */
$(function () {
  $(document).on("input", "textarea[auto-resize]", function () {
    this.style.height = "auto";
    this.style.height = "calc(" + this.scrollHeight + "px)";
  });
});

export const resize_textareas = () => {
  let textareas = document.find_all("textarea[auto-resize]");

  textareas.forEach((t) => {
    t.style.height = t.scrollHeight;
  });
};

$(function () {
  /**
   * Toggle pure mode.
   */
  $(document).on("click", '[js-action="pure-mode:toggle"]', function (e) {
    let puremode_cookie = Cookie.get("PUREMODE");
    let puremode_enabled = puremode_cookie !== null && puremode_cookie != 0;

    Cookie.set("PUREMODE", puremode_enabled ? 0 : 1, 365);

    __body.setAttribute("puremode", puremode_enabled ? 0 : 1);

    if (puremode_enabled) this.unactivate();
    else this.activate();
  });

  /**
   * Toggle dark mode.
   */
  $(document).on("click", '[js-action="dark-mode:toggle"]', function (e) {
    let darkmode_cookie = Cookie.get("DARKMODE");
    let darkmode_enabled = darkmode_cookie !== null && darkmode_cookie != 0;

    Cookie.set("DARKMODE", darkmode_enabled ? 0 : 1, 365);

    __body.classList.remove("theme--cartoon");
    __body.classList.remove("theme--cartoon-dark");

    __body.classList.add("theme--cartoon" + (darkmode_enabled ? "" : "-dark"));

    if (darkmode_enabled) this.unactivate();
    else this.activate();
  });

  /**
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   * ,,,,,,,,,,,,,,,,, INFINITE SCROLLING ,,,,,,,,,,,,,,,,,
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   */
  document.addEventListener("scroll", async (e) => {
    let _container = document.find('[scroll="infinite"]');
    let form = document.find('[data-form="infinite-scroll"]');
    let _type = document.find("[scroll-type]");
    let offset = document.find('[data-react="infinite-scroll-offset"]');
    let loader = document.find('[data-react="scroll:reached-end"]');
    let page_end_bird = document.find("[page-end-bird]");
    let real_bodyScrollHeight = document.body.scrollHeight - window.innerHeight;
    let formdata;
    let formatted_data;
    let url;

    /**
     * Return if there is no infinite scroll container.
     */
    if (!_container || !form || !_type || __page.is_loading) return;

    _type = _type.getAttribute("scroll-type");
    let offset_number = parseInt(offset.value);

    let limit_number = form.find("input[name=limit]").value;
    formdata = new FormData(form);
    formatted_data = new URLSearchParams(formdata);

    if (_type === "squad") url = "/get/squads/score/fetch";
    if (_type === "beatmaps") url = "/get/beatmaps/fetch";
    if (_type === "squads") url = "/get/squads/fetch";

    if (
      window.scrollY >= real_bodyScrollHeight - __infinite_scroll.page_offset &&
      !(__infinite_scroll.reached_end || __infinite_scroll.reached_full_end)
    ) {
      __page.is_loading = true;
      __infinite_scroll.reached_end = true;
      loader.setAttribute("show-loader", "");
      loader.removeAttribute("style");
      page_end_bird.style.display = "none";

      url = url + "?" + formatted_data;

      $.ajax({
        url: url,
        method: "GET",
        processData: false,
        contentType: false,
        success: function (data) {
          __page.is_loading = false;

          if (data.data) {
            _container.insertAdjacentHTML("beforeend", data.data);
            offset.value = offset_number + parseInt(limit_number);

            __infinite_scroll.reached_end = false;
          } else {
            console.log("Reached full end! No more maps to fetch.");
            loader.remove();
            page_end_bird.removeAttribute("style");
            __infinite_scroll.reached_full_end = true;

            if (data.notification)
              document
                .find("footer")
                .insertAdjacentHTML("beforebegin", data.notification);
          }

          Frontend.reload_images();

          if (!data.status)
            new Responder.Responder().add(
              document.body,
              data.message,
              "error",
              "beatmaps"
            );
        },
        error: function (data) {
          __page.is_loading = false;
          page_end_bird.removeAttribute("style");
          page_end_bird.style.display = "none";
          loader.removeAttribute("show-loader");
          new Responder.Responder().add(
            document.body,
            data.statusText,
            "error",
            "beatmaps"
          );
        },
      });
    }
  });

  /**
   * Change the language
   */
  $(document).on("click", "[locale]", function (e) {
    let button = this;
    let locale = this.getAttribute("locale");
    let current_url = window.location.href;

    Frontend.load();
    button.disable();

    /**
     * Remove the locale query param, if it exists.
     */
    if (current_url.includes("&lang="))
      current_url = current_url.replace(/&lang=[^&]*/, "");

    /**
     * Redirect the user to the current page with the new locale
     * set as a query param.
     */
    return window.location.replace(current_url.concat(`&lang=${locale}`));
  });
});
