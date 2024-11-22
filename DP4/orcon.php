<?php

/*function connecttooracle() {
    $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.168)(PORT = 1521))
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.169)(PORT = 1521))
      (LOAD_BALANCE = YES)
      (FAILOVER=YES)
    )
    (CONNECT_DATA = (SERVICE_NAME = clarity))
  )";

    if ($c = oci_connect("ossrpt", "ossrpt123", $db)) {
        // echo "Successfully connected to Oracle.\n";
        return $c;
        //ocilogoff($c);
    } else {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}*/

function connecttooracle() {
    $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
";

    if ($c = oci_connect("ossrpt", "ossrpt123", $db)) {
        // echo "Successfully connected to Oracle.\n";
        return $c;
        //ocilogoff($c);
    } else {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}

function connecttooracleprg() {
    $db = "(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
    )
    (CONNECT_DATA = (SID=clty))
  )
";

    if ($c = oci_connect("ossprg", "prgoss456", $db)) {
        // echo "Successfully connected to Oracle.\n";
        return $c;
        //ocilogoff($c);
    } else {
        $err = OCIError();
        echo "Connection failed." . $err[text];
    }
}
?>

