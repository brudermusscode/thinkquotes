import * as Frontend from "../frontend";
import * as Page from "../page";
import * as Responder from "../elements/responder";

$(function () {
  /**
   * Create Vote
   *
   * @action CREATE
   * @controller VotesController
   */
  $(document).on("click", '[request-do="vote/create"]', function (e) {
    e.preventDefault();

    let button = this;
    let formdata = new FormData();
    let quote = this.closest("[quote]");
    let id = quote.dataset.id;
    let vote_count = quote.find("[vote-count]");
    let vote_type = parseInt(this.dataset.voteType);
    let new_vote_count;
    let other_button_type = vote_type == 1 ? -1 : 1;
    let other_button = vote_count
      .closest("[votes]")
      .find(`[data-vote-type="${other_button_type}"]`);

    formdata.append("reference_id", id);
    formdata.append("reference_type", "quote");
    formdata.append("vote_type", vote_type);

    Frontend.load();
    button.disable();
    other_button?.disable();

    $.ajax({
      url: "/do/" + this.getAttribute("request-do"),
      data: formdata,
      method: "POST",
      contentType: false,
      processData: false,
      success: function (data) {
        Frontend.unload();

        if (data.status) {
          /**
           * Manipulate the used vote button.
           */
          button.activate();
          button.enable();
          button.setAttribute("request-do", "vote/remove");

          /**
           * Calculate new vote count.
           */
          new_vote_count = parseInt(vote_count.innerHTML) + vote_type;

          /**
           * Show the new vote count.
           */
          vote_count.innerHTML = new_vote_count;

          /**
           * Change Vote count color based on the amount of new votes.
           */
          if (new_vote_count > 0) vote_count.setAttribute("color", "green");
          else if (new_vote_count < 0) vote_count.setAttribute("color", "red");
          else vote_count.setAttribute("color", "dynamic");

          /**
           * Set the other button to edit the vote.
           */
          other_button_type = vote_type == 1 ? -1 : 1;
          other_button = vote_count
            .closest("[votes]")
            .find(`[data-vote-type="${other_button_type}"]`);
          other_button?.setAttribute("request-do", "vote/edit");
          other_button?.enable();

          /**
           * Append the vote id to be able to edit/remove the vote again.
           */
          button.closest("[votes]").setAttribute("data-vote-id", data.vote_id);
        } else {
          button.enable();
          new Responder.Responder().add(
            document.body,
            data.message,
            data.status ? "success" : "error"
          );
        }
      },
      error: function (data) {
        button.enable();
        Frontend.unload();
        Frontend.ajax_error(data);
      },
    });
  });

  /**
   * Update Vote
   *
   * @action UPDATE
   * @controller VotesController
   */
  $(document).on("click", '[request-do="vote/edit"]', function (e) {
    e.preventDefault();

    let button = this;
    let formdata = new FormData();
    let quote = this.closest("[quote]");
    let id = button.closest("[votes]").dataset.voteId;
    let vote_count = quote.find("[vote-count]");
    let vote_type = parseInt(this.dataset.voteType);
    let new_vote_count;
    let other_button_type = vote_type == 1 ? -1 : 1;
    let other_button = vote_count
      .closest("[votes]")
      .find(`[data-vote-type="${other_button_type}"]`);

    /**
     * Return nothing if the id is not set.
     */
    if (!id) return;

    formdata.append("id", id);

    Frontend.load();
    button.disable();
    other_button?.disable();

    $.ajax({
      url: "/do/" + this.getAttribute("request-do"),
      data: formdata,
      method: "POST",
      contentType: false,
      processData: false,
      success: function (data) {
        Frontend.unload();

        if (data.status) {
          /**
           * Manipulate the used vote button to remove the newly
           * added vote.
           */
          button.activate();
          button.enable();
          button.setAttribute("request-do", "vote/remove");

          /**
           * Calculate new vote count. Since one vote is being
           * removed and a new one is added to the other side, we
           * need to increase or decrease the vote_count by two.
           */
          new_vote_count =
            parseInt(vote_count.innerHTML) + vote_type + vote_type;

          /**
           * Show the new vote count.
           */
          vote_count.innerHTML = new_vote_count;

          /**
           * Change Vote count color based on the amount of new votes.
           */
          if (new_vote_count > 0) vote_count.setAttribute("color", "green");
          else if (new_vote_count < 0) vote_count.setAttribute("color", "red");
          else vote_count.setAttribute("color", "dynamic");

          /**
           * Set the other button to edit the vote.
           */
          other_button?.setAttribute("request-do", "vote/edit");
          other_button?.unactivate();
          other_button?.enable();
        } else {
          button.enable();
          new Responder.Responder().add(
            document.body,
            data.message,
            data.status ? "success" : "error"
          );
        }
      },
      error: function (data) {
        button.enable();
        Frontend.unload();
        Frontend.ajax_error(data);
      },
    });
  });

  /**
   * Remove Vote
   *
   * @action Delete
   * @controller VotesController
   */
  $(document).on("click", '[request-do="vote/remove"]', function (e) {
    e.preventDefault();

    let button = this;
    let formdata = new FormData();
    let quote = this.closest("[quote]");
    let id = button.closest("[votes]").dataset.voteId;
    let vote_count = quote.find("[vote-count]");
    let vote_type = parseInt(this.dataset.voteType);
    let new_vote_count;
    let other_button_type = vote_type == 1 ? -1 : 1;
    let other_button = vote_count
      .closest("[votes]")
      .find(`[data-vote-type="${other_button_type}"]`);

    /**
     * Return nothing if the id is not set.
     */
    if (!id) return;

    formdata.append("id", id);

    Frontend.load();
    button.disable();
    other_button?.disable();

    $.ajax({
      url: "/do/" + this.getAttribute("request-do"),
      data: formdata,
      method: "POST",
      contentType: false,
      processData: false,
      success: function (data) {
        Frontend.unload();

        if (data.status) {
          /**
           * Manipulate the used vote button to remove the newly
           * added vote.
           */
          button.unactivate();
          button.enable();
          button.setAttribute("request-do", "vote/create");

          /**
           * Calculate new vote count. Since one vote is being
           * removed and a new one is added to the other side, we
           * need to increase or decrease the vote_count by two.
           */
          new_vote_count = parseInt(vote_count.innerHTML) - vote_type;

          /**
           * Show the new vote count.
           */
          vote_count.innerHTML = new_vote_count;

          /**
           * Change Vote count color based on the amount of new votes.
           */
          if (new_vote_count > 0) vote_count.setAttribute("color", "green");
          else if (new_vote_count < 0) vote_count.setAttribute("color", "red");
          else vote_count.setAttribute("color", "dynamic");

          /**
           * Set the other button to edit the vote.
           */
          other_button?.setAttribute("request-do", "vote/create");
          other_button?.unactivate();
          other_button?.enable();
        } else {
          button.enable();
          new Responder.Responder().add(
            document.body,
            data.message,
            data.status ? "success" : "error"
          );
        }
      },
      error: function (data) {
        button.enable();
        Frontend.unload();
        Frontend.ajax_error(data);
      },
    });
  });
});
