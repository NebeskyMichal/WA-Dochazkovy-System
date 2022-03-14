<?php
session_start();
require_once "db.php";
require_once "head.php";

$logName = $_POST["login"];
$logPass = $_POST["password"];

$sql ="SELECT user.id, role.role_name, user.class_id FROM user inner join role on role.id = user.role_id where surname= binary '".$logName."' and password= binary'".$logPass."';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["id"] != 0) {
            $_SESSION["login"] = $_POST["login"];
			$_SESSION["role"] = $row["role_name"];
			$_SESSION["class"] = $row["class_id"];
            header("Location:index.php");
        }
    }
} else {
    header("Location:login.php?err=1");
}
require_once "foot.php";
?>
