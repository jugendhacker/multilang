<?php
include "translate.php";
if (isset($_GET['langs'])) {
    header_remove();
    http_response_code(200);
    header("Content-type:application/json");
    echo json_encode($dictionary);
}elseif (isset($_GET['keys'])){
    header_remove();
    http_response_code(200);
    header("Content-type: application/json");
    echo json_encode(array_keys($dictionary[array_keys($dictionary)[0]]));
}