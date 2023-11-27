<?php


$data = [ 'name' => 'God', 'age' => -1 ];

header('Content-type: application/json');
echo json_encode( $data );

?>