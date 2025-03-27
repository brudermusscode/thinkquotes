import * as App from "./application.js";
import * as Page from "./page.js";
import * as Image from "./images.js";
import * as Utils from "./utils.js";
import * as Frontend from "./frontend.js";
import * as Window from "./window.js";
import Overlay from "./elements/Overlay.js";
import * as Responder from "./elements/responder.js";
import * as Setting from "./settings.js";

let Cookie = require("js-cookie");

/**
 * KEYBOARD SHORTCUT
 */
document.addEventListener("keyup", (e) => {
  if (!e.key) return;

  /**
   * ESC
   */
  if (e.key.toLowerCase() === "escape") {
    let has_overlays = document.querySelector("overlay");

    /**
     * Close all overlays
     */
    if (has_overlays) close_overlays();

    return;
  }
});

window.addEventListener("scroll", function () {
  if (window.scrollY >= 100) {
    document.find("header[main]").style.opacity = 0;
    document.find("header[main]").style.top = "-4.2em";
  } else {
    document.find("header[main]").removeAttribute("style");
  }
});

export const ajax_error = (data) => {
  unload();

  /**
   * Activate all submit buttons, so the user can try again.
   */
  let buttons = document.find_all("[submit-closest]");
  if (buttons)
    buttons.forEach((button) => {
      button.enable();
    });

  console.log(data);

  /**
   * Append exception if one occured.
   */
  if (data.responseText.includes("HRNSHN")) {
    const regex = /HRNSHN(.*?)ENDHRNSHN/g;
    let matches = [];
    let match;

    let exception_text = data.responseText
      .split("HRNSHN")[1]
      .split("ENDHRNSHN")[0]
      .replace("END", "");

    document.body.insertAdjacentHTML("afterbegin", exception_text);
  }

  create_responder(data.statusText, "error");
};

/**
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 * ? Frontend state
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 */
export const load = async () => {
  __page.is_loading = true;

  let overlays = document.find_all("overlay");

  if (overlays.length > 0) {
    overlays[0].insertAdjacentHTML(
      "afterbegin",
      `
    <div material-bar-loader class="linear-progress-material" style="position:absolute;top:0;left:0;width:100vw;">
      <div class="bar bar1"></div>
      <div class="bar bar2"></div>
    </div>
    `
    );
  } else {
    document.body.querySelectorAll("#logo").forEach((l) => {
      l.setAttribute("loading", "");
    });
  }
};

export const unload = async () => {
  __page.is_loading = false;

  let material_bar_loaders = document.find_all("[material-bar-loader]");

  material_bar_loaders.forEach((loader) => {
    loader.remove();
  });

  document.body.querySelectorAll("#logo").forEach((l) => {
    l.removeAttribute("loading");
  });
};

export const reload_images = async () => {
  const images = document.find_all("img:not([loaded])");
  await Image.load_images(images);
};

export const append_loader = async (element) => {
  element.insertAdjacentHTML(
    "afterbegin",
    '<div style="position:absolute;top:0;left:0;width:100%;" class="linear-progress-material"><div class="bar bar1"></div><div class="bar bar2"></div></div>'
  );

  return element.querySelector(".linear-progress-material");
};

/**
 * using the axios GET method, this loads a component and awaits
 * receiving a JSON response with a data object holding the HTML
 * to be appended to the react container specified.
 */
export const load_component = async (
  url,
  data = null,
  append_to = document.body,
  empty_before_append = false
) => {
  load();

  axios
    .get(url, data)
    .then(async (data) => {
      console.log(data);

      if (data.data.status) {
        if (empty_before_append) append_to.innerHTML = "";
        append_to.insertAdjacentHTML("afterbegin", data.data.data);
      }

      await reload_images();
    })
    .finally(() => {
      unload();
      return true;
    });
};

export const activate_current_anchor = (url) => {
  let all_links = document.find_all("a:not([extern])");

  all_links.forEach((a) => {
    if (!a.hasAttribute("sub")) {
      a.unactivate();
    }
  });

  all_links.forEach((a) => {
    let a_href = a.getAttribute("href");
    if (a_href && a_href.includes(url) && !a.hasAttribute("sub")) {
      a.activate();
    }
  });
};

/**
 * Creates a new responder with default values set.
 */
export const create_responder = (
  message,
  status = "error",
  append_to = document.body
) => {
  new Responder.Responder().add(append_to, message, status);
};

/**
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 * ? Prompt animation
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 */
let __prompt_animation_playing = false;

export const slide_out_prompt = async (prompt) => {
  if (!prompt || __prompt_animation_playing) return;

  __prompt_animation_playing = true;

  let outer_box = prompt.closest("box-model");
  let inner_prompt = prompt.closest("[has-inner-prompt]");
  let prompt_elements = [
    prompt.find("[prompt-header]"),
    prompt.find("[prompt-inner-content]"),
  ];

  prompt.unactivate();
  outer_box?.unactivate();
  inner_prompt?.unactivate();
  prompt_elements.forEach((element) => {
    element.unactivate();
  });

  setTimeout(() => {
    prompt.unstyle();

    __prompt_animation_playing = false;
  }, 110);
};

/**
 * Closes all open overlays.
 */
export const close_overlays = () => {
  let overlays = document.querySelectorAll("overlay");

  if (!overlays) return;

  overlays.forEach((overlay) => {
    overlay.removeAttribute("visible");

    setTimeout(() => {
      overlay.remove();

      if (
        document.body.hasAttribute("toggled") &&
        document.body.getAttribute("toggled") == "true"
      )
        document.body.setAttribute("toggled", "false");

      __prompt_animation_playing = false;
    }, 400);
  });

  __current_overlay = null;
  __current_second_overlay = null;
};

/**
 * Select-Model
 *
 * Open a select model's dropdown and close all others.
 */
Utils.delegate(document, "click", "select-model", function (e) {
  const selects = document.querySelectorAll("select-model");
  const current_select = this;
  let dropdown = this.querySelector("[select-model-dropdown]");
  let dropdown_height = dropdown.querySelector("[get-height]").clientHeight;
  let option;
  let value = this.querySelector("[select-model-value]");
  let input = this.querySelector("input");
  let input_value;

  let is_only_select = this.hasAttribute("only-select");
  let is_join_values = this.hasAttribute("join-values");
  let is_option =
    e.target.matches(".select_model__dropdown_option") ||
    (e.target.closest(".select_model__dropdown_option") &&
      e.target
        .closest(".select_model__dropdown_option")
        .matches(".select_model__dropdown_option"));

  /**
   * Close all other dropdowns
   */
  selects.forEach((select) => {
    select.removeAttribute("active");
    select.querySelector("[select-model-dropdown]").removeAttribute("style");
  });

  /**
   * Evaluate if the clicked element is an option inside the
   * select model and close this if true.
   */
  if (is_option) {
    option = e.target.matches("[select-model-dropdown-option]")
      ? e.target
      : e.target.closest("[select-model-dropdown-option]");

    let has_data_value = option.hasAttribute("data-value");

    e.target.closest("select-model").removeAttribute("active");
    e.target.closest("[select-model-dropdown]").removeAttribute("style");

    /**
     * Replace the text shown in the select with the text shown of
     * the option that has been clicked. It considers about a
     * data-value attribute being present on the target element
     * and uses this instead of the innerHTML.
     */
    if (!is_only_select) {
      value.innerHTML = option.innerHTML;
      if (input) {
        if (has_data_value) input.value = option.dataset.value;
        else input.value = option.innerHTML;
      }
    }

    /**
     * Join all values
     *
     * When clicked on the options inside the select model, it
     * will join the values into the input inside it seperated by
     * a comma.
     */
    if (is_join_values) {
      value = option.getAttribute("value");
      input_value = input.value;
      let input_split_values = input_value.split(",");
      let should_add = true;

      input_split_values.forEach((val) => {
        if (val === value) {
          should_add = false;
        }
      });

      if (should_add)
        input.value = input_value ? `${input_value},${value}` : value;
    }

    /**
     * If the clicked element is the select mdoel itself, it
     * should open it
     */
  } else {
    if (current_select.hasAttribute("active")) return;

    this.setAttribute("active", true);
    dropdown.style.height = dropdown_height + "px";
  }
});

/**
 * Select-Model
 *
 * Close all dropdowns when clicked outside.
 */
document.addEventListener("click", function (e) {
  const target = e.target;
  const selects = document.querySelectorAll("select-model");

  if (!target.matches("select-model") && !target.closest("select-model")) {
    selects.forEach(function (element) {
      element.removeAttribute("active");
      element.querySelector("[select-model-dropdown]").removeAttribute("style");
    });
  }
});

/**
 * Set done.
 *
 * Sets an attribute "done" to the given element.
 */
HTMLDivElement.prototype.set_done = () => {
  this.setAttribute("done", "");
};

HTMLElement.prototype.set_done = () => {
  this.setAttribute("done", "");
};

/**
 * Sets the body's background color.
 */
export const set_background_color = (color) => {
  return (document.body.style.backgroundColor = color);
};

//,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
//,,,,,,,,,, BUTTON RIPPLE EFFECT ,,,,,,,,,,,,,
//,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

/**
 * Creates a new element of class `.ripple-effect` and adds it to
 * the material button. We want the animation to finish, so we set
 * a timeout and set the effects_done variable beanth to true,
 * when the timeout has finished.
 */
Utils.delegate(document, "mousedown", "[ripple-effect]", function (e) {
  let button = this;
  let rect = button.getBoundingClientRect();
  let offsetX = e.clientX - rect.left;
  let offsetY = e.clientY - rect.top;
  let computedStyle = getComputedStyle(button);
  let borderRadius = computedStyle.getPropertyValue("border-radius");

  if (this.querySelector(".ripple-effect")) return;

  __material_button_ripple_effect_done = false;

  /**
   * Create the ripple element and set it's attributes to be shown
   * at the clicked position.
   */
  let ripple = document.createElement("span");

  ripple.classList.add("ripple-effect");
  ripple.style.top = `${offsetY}px`;
  ripple.style.left = `${offsetX}px`;

  if (borderRadius == "50%") ripple.style.borderRadius = "50%";
  else ripple.style.borderRadius = "200px";

  this.insertBefore(ripple, this.firstChild);

  setTimeout(() => {
    ripple.setAttribute("active", true);
    ripple.style.top = "-.6px";
    ripple.style.left = "-.6px";

    if (borderRadius != "50%") ripple.style.borderRadius = borderRadius;

    setTimeout(() => {
      __material_button_ripple_effect_done = true;
    }, 400);
  }, 10);
});

/**
 * Removes the ripple effect from a button.
 * Respects the effects_done variable on top.
 */
Utils.delegate(document, "mouseup", "[ripple-effect]", function (e) {
  let ripple = this.querySelector(".ripple-effect");

  if (ripple && __material_button_ripple_effect_done) {
    ripple.setAttribute("active", "false");

    setTimeout(() => {
      ripple.remove();
    }, 400);
  }
});

/**
 * Init ripple effect elements
 *
 * Queries the DOM for all buttons from element type `mbutton` and
 * adds an event listener on mouse leave to it. This way we can
 * add a ripple effect to it.
 */
export const init_material_buttons = () => {
  const __material_buttons = document.querySelectorAll("[ripple-effect]");

  __material_buttons.forEach((button) => {
    button.addEventListener("mouseleave", (e) => {
      remove_material_button_ripple(e.target);
    });
  });
};

/**
 * Remove ripple effect
 */
export const remove_material_button_ripple = (target) => {
  let ripple = target.querySelector(".ripple-effect");
  let interval;

  if (ripple) {
    interval = setInterval(() => {
      if (__material_button_ripple_effect_done) {
        clearInterval(interval);

        ripple.setAttribute("active", "false");

        setTimeout(() => {
          ripple.remove();
        }, __material_button_ripple_effect_remove_interval);
      }
    }, 100);
  }
};

//,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
//,,,,,,,,,,,,,,,,,,,, THEME ,,,,,,,,,,,,,,,,,,
//,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

/**
 * Switch dark or light mode.
 */
$(document).on("click", "theme-switcher", function (e) {
  let current_theme = __page.theme;
  let body = document.body;

  /**
   * Remove all theme classes from body element.
   */
  document.body.className.split(" ").forEach((classs) => {
    if (classs.startsWith("theme--")) body.classList.remove(classs);
  });

  /**
   * Set the new theme class.
   */
  body.classList.add(
    "theme--" + current_theme + (__page.is_darkmode ? "" : "-dark")
  );

  /**
   * Manipulate all theme switcher elements on page to shwo the
   * new state of dark mode enabled.
   */
  if (this.hasAttribute("active"))
    document.querySelectorAll("theme-switcher").forEach((item) => {
      item.removeAttribute("active");
    });
  else
    document.querySelectorAll("theme-switcher").forEach((item) => {
      item.setAttribute("active", "");
    });

  Cookie.set("DARKMODE", __page.is_darkmode ? 0 : 1, {
    expires: 365,
    domain: Utils.serialize_cookie_domain(),
  });

  __page.is_darkmode = __page.is_darkmode ? 0 : 1;
});

/**
 * Set new theme
 */
$(document).on("click", '[data-action="my:website,theme"]', function (e) {
  let theme = this.getAttribute("chooser-option");
  let body = document.body;

  body.className.split(" ").forEach((classs) => {
    if (classs.startsWith("theme--")) body.classList.remove(classs);
  });

  body.classList.add("theme--" + theme + (__page.is_darkmode ? "-dark" : ""));

  Cookie.set("THEME", theme, {
    expires: 365,
    domain: Utils.serialize_cookie_domain(),
  });

  __page.theme = theme;
});

/**
 * Carousel
 */
Utils.delegate(
  document,
  "click",
  ".carousel-shelf .carousel-shelf-button-group mbutton",
  function (e) {
    let wrapper = this.closest(".carousel-shelf");
    let action = this.getAttribute("carousel-action");
    let scrollable = wrapper.find(".carousel");
    let next = wrapper.find("[carousel-action='next']");
    let previous = wrapper.find("[carousel-action='previous']");

    const maxScroll = scrollable.scrollWidth - scrollable.clientWidth;

    let margin_right = window
      .getComputedStyle(scrollable.find(".carousel-item"))
      .getPropertyValue("margin-right");
    let scroll_amount = scrollable.clientWidth + parseInt(margin_right);

    if (action == "next") scrollable.scrollLeft += scroll_amount;
    else if (action == "previous") scrollable.scrollLeft -= scroll_amount;

    if (maxScroll - scrollable.scrollLeft <= 100) {
      next.setAttribute("disabled", "");
      previous.removeAttribute("disabled");
    } else {
      if (next.hasAttribute("disabled")) next.removeAttribute("disabled");
    }

    if (maxScroll - scrollable.scrollLeft + 100 > maxScroll) {
      next.removeAttribute("disabled");
      previous.setAttribute("disabled", "");
    } else {
      if (previous.hasAttribute("disabled"))
        previous.removeAttribute("disabled");
    }
  }
);

export const open_popup = async (href) => {
  if (__page.is_loading) return;

  load();

  $.ajax({
    url: href,
    method: "GET",
    contentType: false,
    processData: false,
    success: function (data) {
      unload();

      if (data.status) {
        let overlay = new Overlay();
        overlay.append(data.data);
      } else {
        new Responder.Responder().add(document.body, data.message, "error");
      }
    },
    error: function (data) {
      unload();
      ajax_error(data);
    },
  });
};

const construct_get_request_url = (
  element,
  baseUrl,
  prefix = "request-get-attribute-"
) => {
  // Initialize query string
  let queryString = "?";

  // Iterate over attributes of the element
  for (const attr of element.attributes) {
    if (attr.name.startsWith(prefix)) {
      // Extract the attribute name without the prefix
      const queryParamName = attr.name
        .slice(prefix.length)
        .replace(/([A-Z])/g, "-$1")
        .replace("-", "_")
        .toLowerCase();
      queryString += `${queryParamName}=${encodeURIComponent(attr.value)}&`;
    }
  }

  // Remove trailing '&' if present
  queryString = queryString.slice(0, -1);

  // Construct full URL
  const fullUrl = baseUrl + queryString;

  return fullUrl;
};

/**
 * Createsa a responder based on the `responder` attribute being
 * set or not and the status of the data passed.
 *
 * @param {JSON} data
 * @param {boolean} responder
 * @returns {}
 */
export const create_dynamic_responder = (data, responder) => {
  if (data.status)
    if (responder === "success")
      Frontend.create_responder(data.message, "success");
    else if (responder === "error")
      Frontend.create_responder(data.message, "error");

  if (responder === "always")
    Frontend.create_responder(data.message, data.status ? "success" : "error");
};

/**
 *
 * @param {string} href
 * @param {Element} append_to
 * @param {boolean} show_responder
 * @param {boolean} overlay
 * @returns {}
 */
export const get_content = async (href, append_to, show_responder, overlay) => {
  if (__page.is_loading) return;

  load();

  return new Promise((resolve, reject) => {
    $.ajax({
      url: href,
      method: "GET",
      contentType: false,
      processData: false,
      success: function (data) {
        unload();

        if (data.status) {
          if (!data.data) return resolve(data);

          if (show_responder !== undefined && show_responder === "success")
            create_responder(data.message, "succes");

          if (overlay) {
            let overlay = new Overlay();
            overlay.append(data.data);
            overlay.overlay.find("[autofocus]")?.focus();
          } else if (append_to) {
            append_to.insertAdjacentHTML("beforeend", data.data);
            append_to.find("[autofocus]")?.focus();
          } else {
            __main.insertAdjacentHTML("beforeend", data.data);
            __main.find("[autofocus]")?.focus();
          }
          reload_images();
        } else {
          if (show_responder !== undefined && show_responder === "error")
            create_responder(data.message, "error");
        }

        if (show_responder !== undefined && show_responder === "always")
          create_responder(data.message, data.status ? "success" : "error");

        resolve(data);
      },
      error: function (data) {
        ajax_error(data);
        reject(data);
      },
    });
  });
};

/**
 * Adds the given string to the INFO_WINDOWS cookie to disable it.
 */
export const disable_info_window = (str) => {
  let info_windows_cookie = Cookie.get("INFO_WINDOWS");
  Cookie.set("INFO_WINDOWS", info_windows_cookie + "," + str, 365);
};

export const show_header_notice = async (elem) => {
  if (!elem) return;

  elem.removeAttribute("donotshow");
  let elem2 = elem.querySelector(".hover_card");

  if (!elem2) return;

  setTimeout(() => {
    elem2.setAttribute("active", "true");
  }, 200);
};

export const remove_header_notice = async (elem) => {
  if (elem) {
    let active_elements = elem.querySelectorAll("[active=true]");

    if (active_elements)
      active_elements.forEach((a) => {
        a.removeAttribute("active");
      });

    await Utils.sleep(400);
    elem.setAttribute("animation", "zoom-out");
    await Utils.sleep(400);
    elem.remove();
  }
};

export const close_notifications = () => {
  let center = document.find("[notifications-center]");

  if (!center) return;

  let button = document.find('[data-action="user:notifications,check"]');
  let categorories = center.find_all("[data-category]");

  /**
   * Deactivate all buttons and reactivate the `all` one to show
   * the correct button activated when notifications are started
   * up again.
   */
  categorories.forEach((button) => {
    if (button.dataset.category == "all") button.activate();
    else button.unactivate();
  });

  if (!button) return;

  button.removeAttribute("active");
  center.find("[append-notifications]").innerHTML = "";
  center.removeAttribute("active");
};

export const close_user_menu = () => {
  let user_menu = document.find("user-menu");

  if (!user_menu) return;

  let append = user_menu.closest("user-menu-outer");

  user_menu.remove();
  append?.unactivate();
};

$(document).on("click", "[data-action='filters:open']", function (e) {
  let overlay = new Overlay(null, true);
  let filters = document.find("filters");

  if (filters) {
    overlay.hide_loader();
    overlay.overlay.insertAdjacentHTML("afterbegin", filters.innerHTML);
  } else {
    overlay.close();
  }
});

export const close_composer = () => {
  let composer = document.find("[composer]");
  let reactions = document.find("[reactions-window]");

  if (composer) {
    composer.setAttribute("unactive", true);
    setTimeout(() => {
      composer.remove();
    }, 400);
  }

  if (reactions) {
    reactions.setAttribute("unactive", true);
    setTimeout(() => {
      reactions.remove();
    }, 400);
  }
};

export const close_responder = (responder) => {
  new Responder.Responder().close(responder);
};

$(document).on("click", "[close-responder]", function (e) {
  e.preventDefault();

  let responder = this.closest("responder");

  close_responder(responder);
});

// ################################################## //

/**
 * Toggle switches.
 */
$(document).on("click", "toggle-switch", function (e) {
  let input = this.find('input[type="hidden"]');

  if (this.getAttribute("toggled") === "false") {
    this.setAttribute("toggled", true);
    if (input && !this.hasAttribute("keep-value")) input.value = "1";
  } else {
    this.setAttribute("toggled", false);
    if (input && !this.hasAttribute("keep-value")) input.value = "0";
  }
});

/**
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 * ? DOMContentLoaded
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 */
$(function () {
  /**
   * Dynamically update boolean values in cookies.
   *
   * If the cookie doesn't exist, it will automatically set it to 0,
   * assuming the user wants to disable a setting that has not been
   * touched yet.
   */
  $(document).on("click", "[update-cookie-bool]", function (e) {
    let setting = this.getAttribute("update-cookie-bool");
    let uppercase = setting.toUpperCase();
    let cookie = Cookie.get(uppercase);

    let disable = cookie == 1 || cookie == undefined;

    Cookie.set(uppercase, disable ? 0 : 1, {
      domain: Utils.serialize_cookie_domain(),
      expires: 365,
    });

    if (uppercase === "SOUNDS") __page.is_sounds_enabled = disable ? 0 : 1;
    else if (uppercase === "ANIMATIONS")
      __page.is_animations_enabled = disable ? 0 : 1;
  });

  /**
   * Generalized click events, mostly for closing different popups
   * and prompts.
   */
  $(document).on("click", function (e) {
    /**
     * Close inner prompts.
     */
    let inner_prompts = document.find_all("[has-inner-prompt][active]");
    if (inner_prompts && !__prompt_animation_playing)
      inner_prompts.forEach(async (i) => {
        if (e.target.closest("[has-inner-prompt]") !== i && e.target !== i) {
          let prompt = i.find("[inner-prompt]");
          if (prompt) await slide_out_prompt(prompt);
          i.unactivate();
        }
      });
  });

  /**
   * Open inner prompts.
   */
  $(document).on("click", "[open-inner-prompt]", async function (e) {
    if (__prompt_animation_playing) return;

    let prompt_outer = this.closest("[has-inner-prompt]");
    if (prompt_outer?.is_activated()) return;

    let prompt = prompt_outer.find("[inner-prompt]");

    if (prompt_outer && !prompt_outer.hasAttribute("active")) {
      await slide_in_prompt(prompt);
    } else {
      await slide_out_prompt(prompt);
    }
  });

  /**
   * Close all overlays.
   */
  $(document).on(
    "click",
    '[close-overlay], [o-closer], [data-action="overlays:close"]',
    function (e) {
      close_overlays();
    }
  );

  /**
   * Open popups dynamically.
   */
  $(document).on("click", "[data-action='popup:open']", function (e) {
    open_popup(this.dataset.href);
  });

  /**
   * Get content from some url and append it to the main container.
   */
  $(document).on("click", "[request-get]", async function (e) {
    let append_to = eval(this.getAttribute("request-append-to"));
    let show_responder = this.getAttribute("responder");
    let url = "/get/" + this.getAttribute("request-get");
    let overlay = this.hasAttribute("overlay");

    console.log("Started GET request for", url);

    if (append_to !== null && !(append_to instanceof Element)) return;

    url = construct_get_request_url(this, url, "request-get-attribute-");

    console.log("Constructed URL for GET request:", url);

    try {
      let resolved = await get_content(url, append_to, show_responder, overlay);

      if ((resolved.status && !resolved.data) || resolved.end === true) {
        this.setAttribute("done", "");
        this.disable();
      }

      if (!resolved.data) {
        console.log("No data came back.");

        if (resolved.error || resolved.message)
          create_responder(resolved.error || resolved.message);

        return;
      }
    } catch (error) {
      return create_responder(`An error occured: ${error}`, "error");
    }

    // If offset and limit are set as attributes, we want to
    // increase the offset by the limit. It's probably always
    // fetching new data.
    let limit = this.getAttribute("request-get-attribute-limit");
    let offset = this.getAttribute("request-get-attribute-offset");

    if (limit && offset) {
      console.log("Fetched data with limit", limit, "and offset", offset);
      this.setAttribute(
        "request-get-attribute-offset",
        parseInt(offset) + parseInt(limit)
      );
    }
  });

  /**
   * Scroll to the top.
   */
  $(document).on("click", "[scroll-top]", function (e) {
    Window.scroll_to_top();
  });

  /**
   * Play a random audio file from the audio-tags in the body.
   */
  $(document).on("click", "[play-random-sound]", function (e) {
    let audios = document.querySelectorAll("audio");

    if (!audios.length || !__page.is_sounds_enabled) return;

    Utils.random(audios).play();
  });

  /**
   * Set a given animation and remove it after the in css set
   * animation duration.
   */
  $(document).on("click", "[toggle-animation]", function (e) {
    let animation = this.getAttribute("toggle-animation");

    this.setAttribute(animation, "");

    let style = window.getComputedStyle(this);
    let duration = style.getPropertyValue("animation-duration");
    let milliseconds = parseFloat(duration) * 1000;

    console.log(milliseconds);

    setTimeout(() => {
      this.removeAttribute(animation);
    }, milliseconds);
  });

  $(document).on("click", "mode-menu", function (e) {
    let is_open = this.hasAttribute("active");
    let is_loading = this.hasAttribute("loading");

    if (is_open || is_loading) return;

    let menu = this.find("jump-menu");
    let menu_inr = menu.find("[jm-inr]");

    this.activate();

    menu.style.height = menu_inr.clientHeight - 40 + "px";
    menu.activate();
    menu.style.height = menu_inr.clientHeight + "px";
  });

  $(document).on("click", "mode-menu [mm-menu] a", function (e) {
    let menu = this.closest("jump-menu");
    let mode_menu = menu.closest("mode-menu");
    let mode_name = this.find("p").innerHTML;
    let mod_icon_class = this.find("mi").className;
    let button = mode_menu.find("[mm-open]");

    button.find("mi").className = mod_icon_class;
    button.find("p").innerHTML = mode_name;

    menu.unactivate();
  });

  $(document).on("click", "[expand-more-show]", function (e) {
    const menu = this.closest("[expand-more]");
    const hidden = menu.find("[expand-more-hidden]");
    const text = menu.find("[expand-more-button-text]");

    let is_collapsed = menu.hasAttribute("active");

    is_collapsed ? menu.unactivate() : menu.activate();
  });

  /**
   * Initialize all the material buttons to open up the ripple effect.
   */
  init_material_buttons();

  $(document).on("click", "[open-user-menu]", function (e) {
    e.preventDefault();

    let button = this;
    let user_menu = document.find("user-menu");
    let append = button.closest("user-menu-outer");

    /**
     * Delete the user-menu if it is open already.
     */
    if (append && append.hasAttribute("active")) {
      user_menu.remove();
      append?.unactivate();

      return;
    }

    Frontend.load();
    button.disable();

    $.ajax({
      url: "/get/ui/user-menu",
      processData: false,
      contentType: false,
      success: function (data) {
        unload();
        button.enable();

        if (data.status) {
          append?.insertAdjacentHTML("beforeend", data.data);
          append?.activate();
          Frontend.reload_images();
        }
      },
      error: function (data) {
        unload();
        button.enable();
      },
    });
  });

  /**
   * Loads a given href of the dataset of the button dynamically
   * into the app container.
   */
  Utils.delegate(document, "click", '[data-action="get"]', async function (e) {
    e.preventDefault();

    let button = this;
    let url = this.dataset.href;
    let composer = this.hasAttribute("open-composer");

    if (composer && document.find("[composer]")) return;
    if (!url) return;

    button.disable();
    Frontend.load();

    $.ajax({
      url: url,
      contentType: false,
      processData: false,
      success: function (d) {
        unload();
        button.enable();

        if (d.status && d.data) {
          __body.insertAdjacentHTML("beforeend", d.data);
          Frontend.reload_images();
        } else new Responder.Responder().add(__body, e.statusText, "error");
      },
      error: function (e) {
        unload();
        button.enable();
        new Responder.Responder().add(__body, e.statusText, "error");
      },
    });
  });

  /**
   * Toggle sub-menu
   */
  Utils.delegate(document, "click", "toggle-sub-menu", function (e) {
    let sub_menu = document.find("sub-menu");

    if (sub_menu.hasAttribute("active")) {
      this.unactivate();
      sub_menu.unactivate();
    } else {
      this.activate();
      sub_menu.activate("active", "");
    }
  });

  /**
   * Close dialogues dynamically.
   */
  $(document).on("click", "[close-dialogue]", function (e) {
    let dialogue = this.closest("[dialogue]");

    if (dialogue) dialogue.remove();

    if (dialogue && this.dataset.infoWindow)
      disable_info_window(this.dataset.infoWindow);
  });

  /**
   * Choose element
   *
   * Basically a radio element but cooler.
   */
  $(document).on("click", "[chooser] [chooser-option]", function (e) {
    let input = $(this).closest("[chooser]").find("[chooser-input]");
    let chooser = $(this).closest("[chooser]");
    let option_value = $(this).attr("chooser-option");
    let options = chooser[0].find_all("[chooser-option]");

    if (option_value) input.value = option_value;

    options.forEach(function (option) {
      option.unactivate();
    });

    this.activate();
  });
});
