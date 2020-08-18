
<?php
require_once '../config/config.php';
require_once 'save_to_csv_file.php';
require_once 'Search_Querys.php';
$count = 0;
$db = new DbConnect();
$link = $db->Connect();
$link_to_sncft = $db->Connect_To_SNCFT_db();
session_start();

function Set_Sessions_Variables($from, $to)
{
    $_SESSION['From'] = $from;
    $_SESSION['To'] = $to;
}
function Set_Sessions_Where_Variable($where)
{
    $_SESSION['Where'] = $where;
}
function Get_Sessions_Where_Variable()
{
    return $_SESSION['Where'];
}
function Get_Sessions_From_Variable()
{
    return $_SESSION['From'];
}
function Get_Sessions_To_Variable()
{
    return $_SESSION['To'];
}
function string_between_two_string($str, $starting_word, $ending_word)
{
    $subtring_start = strpos($str, $starting_word);
    //Adding the strating index of the strating word to  
    //its length would give its ending index 
    $subtring_start += strlen($starting_word);
    //Length of our required sub string 
    $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
    // Return the substring from the index substring_start of length size  
    return substr($str, $subtring_start, $size);
}
if (isset($_POST['Search'])) {
    if (!empty($_POST['Fromdate']) && !empty($_POST['todate']) && !empty($_POST['Where_Argument'])) {
        Set_Sessions_Variables($_POST['Fromdate'], $_POST['todate']);
        Set_Sessions_Where_Variable($_POST['Where_Argument']);
        $from = Get_Sessions_From_Variable();
        $to = Get_Sessions_To_Variable();
        $where = Get_Sessions_Where_Variable();
        switch ($where) {
            case "SELECT * FROM user":
                $sql = "SELECT * FROM slow_log WHERE start_time  BETWEEN '$from' AND '$to'
				AND  sql_text like 'SELECT * FROM user WHERE username%'
			  ORDER BY `start_time` DESC ";
                if ($result = mysqli_query($link, $sql)) {
                    $count = mysqli_num_rows($result);
                } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                break;
            default:
                $sql = "SELECT * FROM slow_log WHERE start_time  BETWEEN '$from' AND '$to'
				AND  sql_text like '$where%'
			  ORDER BY `start_time` DESC ";
                if ($result = mysqli_query($link, $sql)) {
                    $count = mysqli_num_rows($result);
                } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                break;
        }
    } else if (empty($_POST['Fromdate']) && empty($_POST['todate']) && !empty($_POST['Where_Argument'])) {
        Set_Sessions_Where_Variable($_POST['Where_Argument']);
        $from = Get_Sessions_From_Variable();
        $to = Get_Sessions_To_Variable();
        $where = Get_Sessions_Where_Variable();
        switch ($where) {
            case "SELECT * FROM user":
                $sql = "SELECT * FROM slow_log WHERE start_time  BETWEEN '$from' AND '$to'
				AND  sql_text like 'SELECT * FROM user WHERE username%'
			  ORDER BY `start_time` DESC ";
                if ($result = mysqli_query($link, $sql)) {
                    $count = mysqli_num_rows($result);
                } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                break;
            default:
                $sql = "SELECT * FROM slow_log WHERE start_time  BETWEEN '$from' AND '$to'
				AND  sql_text like '$where%'
			  ORDER BY `start_time` DESC ";
                if ($result = mysqli_query($link, $sql)) {
                    $count = mysqli_num_rows($result);
                } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                break;
        }
    } else {

        echo "<script>alert('veuillez sélectionner la date de début, la date de fin et la condition');</script>";
    }
}

if (isset($_POST['save'])) {
    $from = Get_Sessions_From_Variable();
    $to = Get_Sessions_To_Variable();
    $where = Get_Sessions_Where_Variable();
    switch ($where) {
        case "SELECT * FROM user":
            $sql = "SELECT * FROM general_log WHERE event_time  BETWEEN '$from' AND '$to'
    AND  argument like 'SELECT * FROM user WHERE username%'
  ORDER BY `event_time` DESC ";
            if ($result = mysqli_query($link, $sql)) {
                $count = mysqli_num_rows($result);
                $timestamp = time();
                $filename = 'Export_log_' . $timestamp . '.csv';
                csv_from_mysql_Login_History($result, $filename);
            } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            break;

        case "INSERT INTO `user`":
            $sql = "SELECT * FROM general_log WHERE event_time  BETWEEN '$from' AND '$to'
            AND  argument like '$where%'
          ORDER BY `event_time` DESC ";

            if ($result = mysqli_query($link, $sql)) {
                $count = mysqli_num_rows($result);
                $timestamp = time();
                $filename = 'Export_log_' . $timestamp . '.csv';
                csv_from_mysql_new_ures($filename, $result, $count, $link_to_sncft);
            } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            break;

        case "INSERT INTO `recu`":
            $sql = "SELECT * FROM general_log WHERE event_time  BETWEEN '$from' AND '$to'
            AND  argument like '$where%'
          ORDER BY `event_time` DESC ";

            if ($result = mysqli_query($link, $sql)) {
                $count = mysqli_num_rows($result);
                $timestamp = time();
                $filename = 'Export_log_' . $timestamp . '.csv';
                csv_from_mysql_new_recu($filename, $result, $count, $link_to_sncft);
            } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            break;
        case   "UPDATE `recu` SET `id_recu_status` =":
            $sql = "SELECT * FROM general_log WHERE event_time  BETWEEN '$from' AND '$to'
                    AND  argument like '$where%'
                  ORDER BY `event_time` DESC ";

            if ($result = mysqli_query($link, $sql)) {
                $count = mysqli_num_rows($result);
                $timestamp = time();
                $filename = 'Export_log_' . $timestamp . '.csv';
                csv_from_mysql_new_recu_status($filename, $result, $count, $link_to_sncft);
            } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            break;
    }
}
