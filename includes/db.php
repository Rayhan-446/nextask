<?php

$conn = mysqli_connect(
    "localhost",
    "nextaskuser",
    "1234",
    "nextask"
);

if(!$conn){
    die("Database Connection Failed");
}

?>
