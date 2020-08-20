<?php
function Search_For_User($User_id, $link_to_sncft)
{

    $sql = "SELECT * FROM `user` WHERE id ='$User_id'";
    if ($result = mysqli_query($link_to_sncft, $sql)) {
        return $result;
    } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link_to_sncft);
}
function Search_For_new_User($User_id, $link_to_sncft)
{

    $sql = "SELECT creation_date ,first_name , last_name , matricule , email FROM `user` WHERE id ='$User_id'";
    if ($result = mysqli_query($link_to_sncft, $sql)) {
        return $result;
    } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link_to_sncft);
}
function Search_For_Recu_new_status($Recu_id, $link_to_sncft)
{
    $sql = "SELECT reference,motif FROM `recu` WHERE id ='$Recu_id'";
    if ($result = mysqli_query($link_to_sncft, $sql)) {
        return $result;
    } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link_to_sncft);
}
function Search_For_Recu_status($Recu_id, $link_to_sncft)
{
    $sql = "SELECT description FROM `recu_status` WHERE id ='$Recu_id'";
    if ($result = mysqli_query($link_to_sncft, $sql)) {
        return $result;
    } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link_to_sncft);
}
function Search_For_new_Recu($Recu_id, $link_to_sncft)
{

    $sql = "SELECT creation_date, reference , sum ,motif, matricule ,first_name ,last_name FROM `recu` WHERE id ='$Recu_id'";
    if ($result = mysqli_query($link_to_sncft, $sql)) {
        return $result;
    } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link_to_sncft);
}
function Search_For_Recu($Recu_id, $link_to_sncft)
{

    $sql = "SELECT * FROM `recu` WHERE id ='$Recu_id'";
    if ($result = mysqli_query($link_to_sncft, $sql)) {
        return $result;
    } else echo "ERROR: Could not able to execute $sql. " . mysqli_error($link_to_sncft);
}
?>