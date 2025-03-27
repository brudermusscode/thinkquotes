let Cookie = require("js-cookie");

/**
 * If logs should be send to the console or not.
 */
export const LOG = true;

/**
 * A timeout, to show the loading screen longer.
 */
export const INIT_TIMEOUT = 1;

/**
 * The time, general CSS animations will take to finish.
 */
export const ANIMATION_TIME = 810;

/**
 * Determine, if a cookie is set and if the boolean
 * value of it is true.
 */
export const cookie_enabled = (name) => {
  let cookie = Cookie.get(name);
  return (cookie !== undefined && cookie == 1) || cookie === undefined;
};
