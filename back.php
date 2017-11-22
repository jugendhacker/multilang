<?php
include "translate.php";
header_remove();
http_response_code(200);
header("Content-type:application/json");
echo json_encode($dictionary);
