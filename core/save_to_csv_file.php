
<?php
function csv_from_mysql_Login_History($result, $filename)
{

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    foreach ($result as $row) {
        if (!$isPrintHeader) {
            echo implode(',', array_keys($row)) . "\n";

            $isPrintHeader = true;
        }
        foreach ($row as &$value) {
            $value = str_replace("\r\n", "", $value);
            $value = "\"" . $value . "\"";
            $value = str_replace("SELECT * FROM user WHERE", utf8_encode("Quelqu'un s'est connecté avec ces informations : "), $value);
        }

        echo implode(',', array_values($row)) . "\n";
    }
    exit();
}
function csv_from_mysql_new_recu_status($filename, $result, $count, $link_to_sncft)
{
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    $IsprintedStatus = false;
    $title=array("Status");

    while ($row = mysqli_fetch_array($result)) {
        $str = $row['argument'];
        $substring = substr($str, 61);
        $Fresult = Search_For_Recu_new_status($substring, $link_to_sncft);
        $DesResult = Search_For_Recu($substring, $link_to_sncft);
        $DesResult_data = mysqli_fetch_array($DesResult);
        $recu_status_id = $DesResult_data['id_recu_status'];
        $recu_status_result = Search_For_Recu_status($recu_status_id, $link_to_sncft);
        $recu_status_data = mysqli_fetch_array($recu_status_result);
        foreach ($Fresult as $row) {

            if (!$isPrintHeader) {
                echo implode(',', array_keys($row)) . ",";
                echo implode(',', $title) . "\n";

                $isPrintHeader = true;
            }

            foreach ($row as &$value) {
                $value = str_replace("\r\n", "", $value);
                $value = "\"" . $value . "\"";
            }
            $output = array();
            $output = array_slice($recu_status_data, 0, 1);
            echo implode(',', array_values($row)) . ',';
            echo implode(',', array_values($output)) . "\n";
        }
    }

    exit();
}
function  csv_from_mysql_new_recu($filename, $result, $count, $link_to_sncft)
{

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    while ($row = mysqli_fetch_array($result)) {
        $str = $row['argument'];
        $substring = string_between_two_string($str, 'VALUES', ',');
        $substring = preg_replace("/[^a-zA-Z0-9]/", "", $substring);
        $Fresult = Search_For_new_Recu($substring, $link_to_sncft);
        $User_data = mysqli_fetch_array($Fresult);
        foreach ($Fresult as $row) {
            if (!$isPrintHeader) {
                echo implode(',', array_keys($row)) . "\n";
                $isPrintHeader = true;
            }

            foreach ($row as &$value) {
                $value = str_replace("\r\n", "", $value);
                $value = "\"" . $value . "\"";
            }

            echo implode(',', array_values($row)) . "\n";
        }
    }
    exit();
}
function csv_from_mysql_new_ures($filename, $result, $count, $link_to_sncft)
{

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    while ($row = mysqli_fetch_array($result)) {
        $str = $row['argument'];
        $substring = string_between_two_string($str, 'VALUES', ',');
        $substring = preg_replace("/[^a-zA-Z0-9]/", "", $substring);
        $Fresult = Search_For_new_User($substring, $link_to_sncft);
        $User_data = mysqli_fetch_array($Fresult);
        foreach ($Fresult as $row) {
            if (!$isPrintHeader) {
                echo implode(',', array_keys($row)) . "\n";
                $isPrintHeader = true;
            }

            foreach ($row as &$value) {
                $value = str_replace("\r\n", "", $value);
                $value = "\"" . $value . "\"";
            }

            echo implode(',', array_values($row)) . "\n";
        }
    }
    exit();
}
?>