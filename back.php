<?php
include "translate.php";
if (isset($_GET['langs'])) {
    header_remove();
    http_response_code(200);
    header("Content-type:application/json");
    echo json_encode(get_languages());
}elseif (isset($_GET['keys'])){
    header_remove();
    http_response_code(200);
    header("Content-tyüe: application/json");
    echo json_encode(array_keys(get_languages()));
}