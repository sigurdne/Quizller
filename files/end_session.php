<?php
	session_start();
	include '../database/config.php';
	$temp		  = $_SESSION['student_details'];
	$student_data = json_decode($temp);

	$stmt = $conn->prepare("UPDATE students SET status = 1 WHERE id = ?");
	foreach ($student_data as $obj) {
		$student_id = $obj->id;
		$stmt->bind_param("i", $student_id);
		$stmt->execute();
	}
	$stmt->close();

	if ($_POST['message'] == 1)
	{
		echo "Aborted";
	}
	else
	{
		echo "Completed";
	}

	session_destroy();
