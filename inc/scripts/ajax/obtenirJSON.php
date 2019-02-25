<?php
header( 'Content-type: application/json; charset=utf-8');

$obj = json_decode(file_get_contents('../../../assets/js/objMessageErreur.json'));

echo json_encode($obj);
