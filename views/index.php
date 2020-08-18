<?php
require_once '../core/main.php';
require_once '../config/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>SQL Slow Query Monitor </title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/icons/SLQ-icon.ico" />
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body style="color: rgb(255, 255, 255);">
    <section class="d-xl-flex justify-content-xl-center align-items-xl-center header">
        <div class="container">
            <div class="row" id="form">
                <div class="col">
                    <form method="post">
                        <div class="form-row">
                            <div class="col-xl-2 offset-xl-3">
                                <label>De</label><input class="form-control" type="date" name="Fromdate" />
                            </div>
                            <div class="col-xl-2">
                                <label>à</label><input class="form-control" type="date" name="todate" />
                            </div>
                            <div class="col-xl-2">
                                <label>Where</label><select class="custom-select" name="Where_Argument">
                                    <option value="" selected="">Non condition</option>
                                    <option value="SELECT * FROM user">Historique des connexions</option>
                                    <option value="INSERT INTO `user`">Nouveaux utilisateurs</option>
                                    <option value="INSERT INTO `recu`">Nouveaux reçu</option>
                                    <option value="UPDATE `recu` SET `id_recu_status` =">Mise à jour de l'état du reçu</option>
                                </select>
                            </div>
                        </div>
                        <div id="btn-form" class="form-row">

                            <div class="col-xl-2 offset-xl-5 text-center">

                                <button class="btn btn-primary" type="submit" name="Search">
                                    Rechercher
                                </button>

                            </div>

                        </div>


                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive table-borderless" style="border-radius: 5px;
                    height: 450px;">
                        <table class="table table-bordered table-hover table-dark">
                            <thead>
                                <tr>
                                    <th>heure de l'évènement</th>
                                    <th>IP</th>
                                    <th>Base de données</th>
                                    <th>argument</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['Search'])) {
                                    $_SESSION['Argument'] = $_POST['Where_Argument'];
                                    switch ($_SESSION['Argument']) {
                                        case "SELECT * FROM user":
                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_array($result)) {

                                                    echo "<tr>";
                                                    echo "<td>" . substr($row['start_time'], 0, 19) . "</td>";
                                                    echo "<td>" . substr($row['user_host'], 22, 50) . "</td>";
                                                    echo "<td>" . $row['db'] . "</td>";
                                                    echo utf8_encode("<td> Quelqu'un s'est connecté avec ces informations : " . substr($row['sql_text'], 25) . "</td>");
                                                    echo "</tr>";
                                                }
                                            }
                                            break;

                                        case "INSERT INTO `user`":
                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_array($result)) {

                                                    echo "<tr>";
                                                    echo "<td>" . substr($row['start_time'], 0, 19) . "</td>";
                                                    echo "<td>" . substr($row['user_host'], 22, 50) . "</td>";
                                                    echo "<td>" . $row['db'] . "</td>";
                                                    $str = $row['sql_text'];
                                                    $substring = string_between_two_string($str, 'VALUES', ',');
                                                    $substring = preg_replace("/[^a-zA-Z0-9]/", "", $substring);
                                                    $Fresult = Search_For_User($substring, $link_to_sncft);
                                                    $User_data = mysqli_fetch_array($Fresult);
                                                    echo  utf8_encode("<td> Nouvel utilisateur  Nom : " . $User_data['first_name'] . " | Prenom : " . $User_data['last_name'] . " | Matricule: " . $User_data['matricule'] . "</td>");
                                                    echo "</tr>";
                                                }
                                            }
                                            break;

                                        case "INSERT INTO `recu`":
                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_array($result)) {

                                                    echo "<tr>";
                                                    echo "<td>" . substr($row['start_time'], 0, 19) . "</td>";
                                                    echo "<td>" . substr($row['user_host'], 22, 50) . "</td>";
                                                    echo "<td>" . $row['db'] . "</td>";
                                                    $str = $row['sql_text'];
                                                    $substring = string_between_two_string($str, 'VALUES', ',');
                                                    $substring = preg_replace("/[^a-zA-Z0-9]/", "", $substring);
                                                    $Fresult = Search_For_Recu($substring, $link_to_sncft);
                                                    $recu_data = mysqli_fetch_array($Fresult);
                                                    echo utf8_encode("<td> reference :  " . $recu_data['reference'] . " | sum : " . $recu_data['sum'] . " | Matricule : " . $recu_data['matricule'] . " | Nom : " . $recu_data['first_name'] . " | Prenom : " . $recu_data['last_name'] . " | CIN : " . $recu_data['cin'] . " | motif : " . $recu_data['motif'] . " | date_signature : " . $recu_data['date_signature'] . "</td>");
                                                    echo "</tr>";
                                                }
                                            }
                                            break;
                                        case "UPDATE `recu` SET `id_recu_status` =":
                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . substr($row['start_time'], 0, 19) . "</td>";
                                                    echo "<td>" . substr($row['user_host'], 22, 50) . "</td>";
                                                    echo "<td>" . $row['db'] . "</td>";
                                                    $str = $row['sql_text'];
                                                    $substring = substr($str, 61);
                                                    $Fresult = Search_For_Recu($substring, $link_to_sncft);
                                                    $recu_data = mysqli_fetch_array($Fresult);
                                                    $recu_status_id = $recu_data['id_recu_status'];
                                                    $recu_status_result = Search_For_Recu_status($recu_status_id, $link_to_sncft);
                                                    $recu_status_data = mysqli_fetch_array($recu_status_result);
                                                    echo utf8_encode("<td> Reference :  " . $recu_data['reference'] . " | motif : " . $recu_data['motif'] . " | Status : " . $recu_status_data['description'] . "</td>");
                                                    echo "</tr>";
                                                }
                                            }
                                            break;
                                        case "":
                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_array($result)) {

                                                    echo "<tr>";
                                                    echo "<td>" . substr($row['start_time'], 0, 19) . "</td>";
                                                    echo "<td>" . substr($row['user_host'], 22, 50) . "</td>";
                                                    echo "<td>" . $row['db'] . "</td>";
                                                    echo "<td>" . $row['sql_text'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            break;
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div id="btn-form1" class="form-row">

                        <button class="btn btn-primary" type="submit" name="save">
                            Enregistrer
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>

    <!-- DATA TABES SCRIPT -->
    <script src="js/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="js/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>