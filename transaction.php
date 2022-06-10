<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/config.php";

    function begin(){
        global $mysqli;
        mysqli_query($mysqli, "BEGIN"); // starting of transaction queries.
    }

    function commit(){
        global $mysqli;
        mysqli_query($mysqli,"COMMIT"); // queries in commit cannot be rolled back, end of transaction usage
    }

    function rollback(){
        global $mysqli;
        mysqli_query($mysqli, "ROLLBACK"); // cancels all queries in current transaction if one does not run
    }

?>