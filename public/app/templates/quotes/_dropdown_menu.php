<?php if (!isset($elementInclude)) header('location: /404'); ?>

<div data-element="dropdown" class="posrel" travelhereboy data-react="function:quotes,edit,hide">
  <div class="q-top-tools">

    <?php

    // in addition, if the quote is archived, show special button
    // instead of the dropdown menu
    if ($elementInclude->deleted) { ?>

      <div class="sizing unarchive disfl fldirrow" data-action="popups:quotes,delete">
        <p class="pt4 mr4">
          <i class="material-icons small">unarchive</i>
        </p>
        <p>Unarchive</p>
      </div>

    <?php

      // if it's not archived, show the dropdown menu with dynamic
      // content specified for each user
    } else { ?>

      <div class="sizing" data-action="dropdown:open">
        <p>
          <i class="ri-arrow-down-s-line std"></i>
        </p>
      </div>

      <dropdown data-dropdown="header,usermenu" data-react="dropdown:open" class="mshd-2">
        <div class="dd-inr">
          <ul>

            <?php

            // those tools should be shown if the quote belongs to
            // the viewing user
            if ($is_my_quote) { ?>

              <li class="has-icon trimt disabled" data-action="popup:quotes,edit">
                <p>
                  <i class="ri-edit-circle-fill small"></i>
                </p>
                <p>Edit</p>
              </li>

              <li class="has-icon trimt archive" data-action="popups:quotes,delete">
                <p class="icon">
                  <i class="material-icons small"></i>
                </p>
                <p class="text"></p>
              </li>

            <?php

              // if it's not the quote of the viewing user, show the options
              // beneath
            } else { ?>

              <li class="has-icon trimt" data-action="popup:quotes,report">
                <p>
                  <i class="ri-flag-2-fill small"></i>
                </p>
                <p>Report</p>
              </li>

            <?php } ?>

          </ul>
        </div>
      </dropdown>

    <?php } ?>

  </div>
</div>