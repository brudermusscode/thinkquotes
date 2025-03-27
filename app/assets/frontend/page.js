import * as Router from "./router.js";
import * as Image from "./images.js";
import * as Page from "./page.js";
import * as Utils from "./utils.js";
import * as Frontend from "./frontend.js";
import * as Window from "./window.js";
import * as Cookies from "./cookies.js";
import { Header } from "./elements/header.js";
import * as Responder from "./elements/responder.js";
import Overlay from "./elements/Overlay.js";

import * as Home from "./pages/home.js";

/**
 * Page settings
 */
let scroll_interval;

/**
 * Reloads the page by calling the get function and setting the
 * reload parameter to true.
 */
export const reload = (keep_overlays = false) => {
  // console.log("Reloading page...");
  get(
    window.location.pathname + window.location.search,
    false,
    null,
    false,
    true,
    keep_overlays
  );
};

$(document).on("click", "[reload-page-icon]", function () {
  reload();
});

/**
 * TODO: Opening a link in a new tab will not work. Pages won't be loaded
 * properly, since the URL is staying in a key value parameter format
 * and won't be transformed to SEO friendly URLS. I might fix this by
 * loading the page in at page startup.
 */
export const get = async (
  href,
  state = false,
  anchor = null,
  scroll_top = true,
  reload = false,
  keep_overlays = false
) => {
  /**
   * If the page is in loading state, return.
   */
  if (__page.is_loading && !reload) return;
  if (__page.current === "maintenance") return;

  /**
   * Close all the open things.
   */
  Frontend.close_composer();
  Frontend.close_user_menu();
  Frontend.close_notifications();

  let url = href;

  let main_container = document.body.querySelector("main");
  // let csrf_token = Utils.get_csrf_token();
  let title;

  /**
   * Serialize the route the user is coming from.
   */
  let coming_from_path = window.location.pathname;
  let coming_from_path_split = coming_from_path.split("/");

  /**
   * A string holding all query params.
   */
  let request_params;

  /**
   * Prepare a reload.
   */
  if (reload) url = url.concat("&reload=" + random_string(8));

  /**
   * Split the url by ? to get the query parameter or fallback to
   * false, if none are set.
   */
  let query_params_split = url.split("?");
  let query_params = query_params_split[1] ?? false;
  let url_no_query_params = query_params_split[0];

  /**
   * Split the url for base parameter by `/`.
   */
  let url_parameter = url_no_query_params.split("/");

  /**
   * Remove the first element in the parameter array, since it
   * will be empty.
   */
  url_parameter.shift();

  /**
   * Get the route by extracting the first component of the url
   * eg. /leaderboard, /beatmaps and remove the starting slash.
   */
  let route = url_parameter[0];

  /**
   * Profile Editor is only available on Desktop by now. Redirect
   * users that try to access it through a small device.
   */
  if (
    route == "editor" &&
    (window.innerHeight < 812 || window.innerWidth < 812)
  ) {
    console.log("Profile Editor only available on Desktop by now.");
    if (window.location.pathname.split("/")[1] !== "editor")
      Frontend.open_popup("/get/unavailable?type=profileeditor");
    else get("/home");
    return;
  }

  /**
   * Get the router object and serialize the params key by
   * splitting it by a slash (/) and extract the params each.
   * Removes the colon (:) from the beginning of the string.
   */
  let Route = await Router.router(route);
  let Route_params = Route.params ? Route.params.split("/") : null;
  let params = [];
  Route_params?.forEach((param) => {
    if (param.startsWith(":")) params.push(param.substring(1));
  });

  /**
   * Prepare the request query params string for objectifying it
   * to put it into the history state.
   */
  request_params = `?page=${route}`;

  /**
   * Prepare the request url for ajax.
   */
  let request_url = `/page/${route}`;
  if (url_parameter.length > 1)
    params.forEach((param, index) => {
      if (url_parameter[index + 1]) {
        let key_value = `${param}=${url_parameter[index + 1]}`;
        request_url = request_url.concat("&" + key_value);
        request_params = request_params.concat(`&${key_value}`);
      }
    });

  /**
   * Append query params to the request url params.
   */
  if (query_params) request_url = request_url.concat(`&${query_params}`);

  /**
   * Create the object with params for the history.
   */
  request_params = request_params.concat(`&${query_params}`);
  let history_params = request_params
    ? objectify_query_params(request_params)
    : {};
  history_params["href"] = url;

  /**
   * Check if the current location is the same as the
   * requested url. Return nothing in this case. Defines a variable
   * is_same_location to use around this function as well as a
   * variable that just figures out if the current location
   * and the destinated one are from the same oruigin page
   */
  let current_location_route = window.location.pathname.split("/").shift()[0];
  let is_same_location =
    window.location.pathname.concat(window.location.search) == url;
  let is_same_history_route = url == current_location_route;

  /**
   * Return nothing if the current location is the same as the
   * requested one.
   */
  if (!state && is_same_location) return;

  /**
   * Create a new overlay. We are loading!
   */
  let overlay = new Overlay(null, false);

  /**
   * Begin the new page load.
   */
  Frontend.load();

  /**
   * Scroll to the top if the param is set to true.
   */
  if (scroll_top) Window.scroll_to_top();

  /**
   * Get CSRF token.
   */
  const __csrf_token = document
    .find("head meta[name=csrf_token]")
    .getAttribute("content");

  /**
   * Set it as the default header.
   */
  axios.defaults.headers.common["X-CSRF-Token"] = __csrf_token;

  await axios
    .get(request_url)
    .then(async (data) => {
      /**
       * Close overlays if.
       */
      if (!keep_overlays) Frontend.close_overlays();

      title = data.data.title;

      /**
       * Update the page global.
       */
      __page.current = route;

      /**
       * Pushes the coming state to the browser history and sets a proper
       * title to the document.
       */
      if (!state && !reload) {
        history.pushState(history_params, title, url);
        document.title = title;
      }

      /**
       * Stop playing audio.
       */
      if (__current_audio_element) {
        __current_audio_element.pause();
        __current_audio_element.remove();
        __current_audio_element = null;
      }

      /**
       * For each page load, we need to reset the infinite scrolling variables
       * to let the new page, if available, can access those freshly and calculate
       * when to add new items
       */
      __infinite_scroll.start = 0;
      __infinite_scroll.reached_end = false;
      __infinite_scroll.reached_full_end = false;

      clearInterval(scroll_interval);

      /**
       * Include the new main content.
       */
      if (typeof data.data === "object" && "include_template" in data.data)
        main_container.innerHTML = data.data.include_template;
      else main_container.innerHTML = data.data;

      /**
       * Set header to scrolled.
       */
      if (window.scrollY >= 20)
        document.find("[scroll-manipulated]")?.setAttribute("scrolled", "true");

      /**
       * Check for an exception and move it to a direct child of
       * the body to be present in the very foreground.
       */
      let exception = main_container.find("exception-container");
      if (exception) {
        exception.remove();
        document.body.appendChild(exception);
      }

      /**
       * If a redirect exists, redirect to the page inside the to attribute.
       */
      let redirector = main_container.find("redirect");
      if (redirector && redirector.hasAttribute("to"))
        return window.location.replace(redirector.getAttribute("to"));

      /**
       * Autofocus any input that has the attribute.
       */
      if (document.body.find("[autofocus]"))
        document.body.find("[autofocus]").focus();

      /**
       * Execute once function will only be fired when first
       * accessing a new page, which is determined by the body
       * carrying an attribute named after the route itself.
       */
      if (
        typeof Route.execute_once === "function" &&
        !document.body.hasAttribute(route)
      )
        Route.execute_once(url);

      /**
       * Remove all route attributes from any section where it will be
       * added to.
       */
      Object.keys(Router.routes).forEach((index) => {
        document.body.removeAttribute(index);
      });

      /**
       * Set route attributes.
       */
      document.body.setAttribute(
        route == ""
          ? "home"
          : Route.body_attribute !== undefined
            ? Route.body_attribute
            : route,
        ""
      );

      /**
       * Find the header and hide it, if the current page is set
       * to hide it.
       */
      let __header = document.find("header[main]");
      if (Route.hide_header === true) {
        __header.set_inactive();
      } else __header.unset_inactive();

      /**
       * Free the clicking on other links by disabling page loading.
       */
      Frontend.unload();

      /**
       * Find all get-content tags and load from the given paths.
       */
      let get_contents = document.find_all("get-content");
      let from;
      get_contents.forEach((getc) => {
        from = getc.getAttribute("from");
        if (from)
          $.ajax({
            url: from,
            method: "GET",
            contentType: false,
            processData: false,
            success: function (data) {
              if (data.status) {
                getc.innerHTML = data.data;
                Frontend.reload_images();
                $.globalEval($(getc).find("script").text());
              }
            },
            error: function (data) {
              Frontend.ajax_error(data);
            },
          });
      });

      /**
       * Deactivate all main navigation buttons.
       */
      document.find_all("[page]").forEach((button) => {
        button.unactivate();
      });

      /**
       * Set main navigation button to activate.
       */
      if (Route.mark)
        document
          .find_all(`[page=${Route.mark}]`)
          ?.forEach((button) => button.activate());
      else
        document
          .find_all(`[page=${route}]`)
          ?.forEach((button) => button.activate());

      // Set the current page to be marked.
      // __page.marked = Route.mark ? Route.mark : route;

      // The previous Router, basically the router for the page
      // the user is coming from.
      let PreviousRoute = await Router.router(coming_from_path_split[1]);

      /**
       * Set the pressed anchor to be active and unactivate all others.
       */
      // if ((anchor && !anchor.hasAttribute("sub")) || !anchor)
      //   Frontend.activate_current_anchor(url);

      /**
       * Reinitialize all material buttons.
       */
      Frontend.init_material_buttons();

      /**
       * Reload all images.
       */
      Frontend.reload_images();

      /** Set body to initialized */
      document.body.setAttribute("initialized", true);

      /**
       * Fill topics for home page.
       */
      if (!route || route === "home") Home.fill_topics();

      return true;
    })
    .catch((error) => {
      console.log(error);
      Frontend.unload();
      Frontend.reload_images();
    });
};

export const get_component = async (
  react,
  url,
  data = null,
  empty_container = false,
  where = "top"
) => {
  $.ajax({
    url: url,
    data: data,
    method: "GET",
    processData: false,
    contentType: "JSON",
    success: function (data) {
      if (!data.status)
        return new Responder.Responder().add(
          document.body,
          data.message,
          "error"
        );

      if (empty_container) {
        react.innerHTML = data.data;
      } else {
        if (where === "top") react.insertAdjacentHTML("afterbegin", data.data);
        else react.insertAdjacentHTML("beforeend", data.data);
      }

      Frontend.reload_images();
    },
    error: function (data) {
      new Responder.Responder().add(
        document.body,
        data.message,
        "error",
        "user"
      );
    },
  });
};

export const objectify_query_params = (query) => {
  if (!query) return;

  query = query.replace("?", "");

  let params = query.split("&");

  if (!params[0] && params.length > 0) params.shift();

  let obj = {};

  params.forEach((param) => {
    let ass = param.split("=");
    obj[ass[0]] = ass[1];
  });

  return obj;
};

export const disable_scroll = () => {
  let TopScroll = window.pageY || document.documentElement.scrollTop;
  let LeftScroll = window.pageX || document.documentElement.scrollLeft;

  window.onscroll = function () {
    window.scrollTo(LeftScroll, TopScroll);
  };
};

export const enable_scroll = () => {
  window.onscroll = function () {};
};

Utils.delegate(
  document,
  "click",
  "[data-action='legal:consent,forward']",
  function (e) {
    let page = this.dataset.legalPage;

    Cookies.set("POLICIES_CONSENT_STEP", page, 365);
  }
);

export const random_string = (length) => {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let randomString = "";

  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    randomString += characters.charAt(randomIndex);
  }

  return randomString;
};

/**
 * Create an install app prompt.
 */
$(function () {
  window.addEventListener("beforeinstallprompt", (event) => {
    // Prevent Chrome 76 and later from showing the automatic install prompt
    event.preventDefault();

    // Store the event for later use
    let deferredPrompt = event;

    // Show your own custom install button
    // For example, you can have an "Install" button on your webpage
    const installButton = document.find("installButton");

    if (installButton) {
      installButton.style.display = "block";

      installButton?.addEventListener("click", () => {
        // Trigger the deferred prompt
        deferredPrompt.prompt();

        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === "accepted") {
            console.log("User accepted the install prompt");
          } else {
            console.log("User dismissed the install prompt");
          }

          // Reset the deferred prompt
          deferredPrompt = null;
          installButton.style.display = "none";
        });
      });
    }
  });
});
