<?php

/* Do some operation here, like talk to the database, the file-session
 * The world beyond, limbo, the city of shimmers, and Canada.
 *
 * AJAX generally uses strings, but you can output JSON, HTML and XML as well.
 * It all depends on the Content-type header that you send with your AJAX
 * request. */


header('Content-type: application/json');
//$_POST['functionname']
$aResult = array();
if (isset($_GET['functionname'])) {
	$aResult['result'] = $_GET['functionname'] . " youruser id is ";
}
else {$aResult['result'] = 'faal';}

echo json_encode($aResult);


?>

