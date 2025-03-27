import * as Utils from "./utils.js";
import * as Frontend from "./frontend.js";

export const APP_NAME = "ThinkQuotes";
export const SCRIPT = "/assets/javascript";

export const routes = {
  not_found: {},

  home: {
    params: "/:sub",
    is_main_page: true,
  },

  "": {
    params: "/:sub",
    mark: "home",
    is_main_page: true,
  },

  topic: {
    params: "/:id",
    mark: "topics",
    is_main_page: false,
  },

  author: {
    params: "/:id",
    mark: "authors",
    is_main_page: false,
    hide_header: true,
  },
};

export const router = async (route) => {
  let match;
  const matches_any = route in routes ? true : null;

  if (!matches_any) {
    match = routes.not_found;
  } else {
    match = routes[route];
  }

  return match;
};
