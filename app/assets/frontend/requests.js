import * as Frontend from "./frontend";
import * as Page from "./page";

$(document).on("submit", "[request]", function (e) {
  e.preventDefault();

  let request_url = this.getAttribute("request");

  if (!request_url) return;

  let formdata = new FormData(this);
  let button = this.find("[submit-closest]");
  let method = this.getAttribute("method");
  let responder = this.getAttribute("responder");
  let redirect = this.getAttribute("redirect");
  let reload = this.getAttribute("reload");

  button.disable();
  Frontend.load();

  $.ajax({
    url: request_url,
    data: formdata,
    method: method ?? "GET",
    contentType: false,
    processData: false,
    success: function (data) {
      Frontend.unload();

      if (data.status) {
        if (reload !== null) Page.reload();
        if (redirect) Page.get(redirect);
        if (responder !== null && responder === "success")
          Frontend.create_responder(data.message, "success");
      } else {
        if (responder !== null && responder === "error")
          Frontend.create_responder(data.message, "error");
        button.enable();
      }

      if (responder !== null && responder === "always")
        Frontend.create_responder(
          data.message,
          data.status ? "success" : "error"
        );
    },
    error: function (error) {
      button.enable();
      Frontend.unload();
      Frontend.ajax_error(error);
    },
  });
});
