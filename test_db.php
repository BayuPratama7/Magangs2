<?php
$conn = @pg_connect("host=localhost port=5432 user=postgres password=1 dbname=db_magang2");
if ($conn) {
    echo "CONNECTED TO LOCALHOST?!";
} else {
    echo "FAILED TO CONNECT TO LOCALHOST. Error: " . error_get_last()['message'];
}
