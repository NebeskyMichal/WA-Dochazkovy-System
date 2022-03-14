
<?php
session_start();
require_once('db.php');
require_once('head.php');
$login_name = $_SESSION["login"];
$login_class = $_SESSION["class"];
if($_SESSION["role"] == "teacher"){
	echo "Vítejte ".$_SESSION["login"]." zde vidíte tabulku studentu<br>";
	$sql = "SELECT user.surname, class.class_name, student_checkin.date from student_checkin inner join user on user.id = student_checkin.student_id inner join class on class.id = student_checkin.class_id where class.id=$login_class";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table><tr>
           <td>Prijmeni</td>
           <td>Třída</td>
           <td>Čas příchodu</td></tr>';
  while($row = $result->fetch_assoc()) {
		echo '<tr>
           <td>'.$row['surname'].'</td>
           <td>'.$row['class_name'].'</td>
           <td>'.$row['date'].'</td>
		</tr>';
  }
	echo '</table>';
} else {
  echo "0 results";
}
}else{
	echo "Vítejte ".$_SESSION["login"]." jste zapsán dne ". date("Y.m.d")." v ".date("h:i:sa"). " hodin";
	$sql ="select * from student_checkin";
	$result = $conn->query($sql);
	$count = $result->num_rows;

	$sql = "select user.id, user.surname, user.class_id from user where user.surname = '$login_name'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row["id"];
		$user_classID = $row["class_id"];
    }
	$sql = "insert into student_checkin values($count+1,$user_id,$user_classID,NOW())";
	$result = $conn->query($sql);
}
}
?>
<main>
<form action="logout.php">
<input type="submit" value="logout" class="lf--submit">
</form>
</main>
<?php
require_once('foot.php');
?>
