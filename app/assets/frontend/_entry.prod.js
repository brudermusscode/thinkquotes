/**
 * Vendor
 */
const axios = require("axios");
const jsCookie = require("js-cookie");

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Base
 */
import * as App from "./application";
import * as Settings from "./settings";
import * as Router from "./router";
import * as Request from "./requests";
import * as Audio from "./audio";
import * as Body from "./body";
import * as Cookie from "./cookies";
import * as Frontend from "./frontend";
import * as Images from "./images";
import * as Page from "./page";
import * as URL from "./url";
import * as Utils from "./utils";
import * as Window from "./window";
import * as HTMLElements from "./HTMLElements";

/**
 * Elements
 */
import { Header } from "./elements/header";
import Overlay from "./elements/Overlay";
import * as Responder from "./elements/responder";

/**
 * Models
 */
import * as Quote from "./models/Quote";

/**
 * Pages
 */

/**
 * SCSS
 */
import "../stylesheets/application.prod.scss";
