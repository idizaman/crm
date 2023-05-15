<?php
    // try connecting to the database
    $conn = oci_connect('WMSP2', 'WMSP2', '11G_ORAAPP2.BANGLALINKGSM.COM');

    // check for any errors
    if (!$conn)
    {
     $e = oci_error();
     print htmlentities($e['message']);
     exit;
    }

    // else there weren't any errors
    else
    {
     echo 'I am an Oracle mack daddy.';
    }

 ?>
