<?php

require_once dirname($_SERVER["DOCUMENT_ROOT"]) . "/config/get_requirements.php";

use Bruder\Controller\VotesController;

$return = (new VotesController)->remove($_POST);

exit(json_encode($return));
