<?php

/* Do some operation here, like talk to the database, the file-session
 * The world beyond, limbo, the city of shimmers, and Canada.
 *
 * AJAX generally uses strings, but you can output JSON, HTML and XML as well.
 * It all depends on the Content-type header that you send with your AJAX
 * request. */
$subarr = array('a' => 'konijn', 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
$arr =array('a' => 'konijn', 'b' => 2, 'c' => 3, 'd' => 4, 'e' => $subarr);
echo json_encode($arr); //In the end, you need to echo the result.
                      //All data should be json_encode()d.

                      //You can json_encode() any value in PHP, arrays, strings,
                      //even objects.


?>

