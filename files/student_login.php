<?php
	include '../database/config.php';
	session_start();

	$class_id = (int)$_POST['class_id'];
	$student_roll_number = (int)$_POST['rollNumber'];
	$student_password	 = $_POST['password'];

	$sql1		= "select id from student_data where rollno = '$student_roll_number' AND class_id = $class_id";
	$result1	= mysqli_query($conn, $sql1);
	$row1		= mysqli_fetch_assoc($result1);
	$student_id = !empty($row1["id"]) ? (int)$row1["id"] : 0;

	$stmt = mysqli_prepare($conn, "SELECT id, test_id, rollno, score, status FROM students WHERE rollno = ? AND password = ?");
	mysqli_stmt_bind_param($stmt, "is", $student_id, $student_password);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_num_rows($result) > 0)
	{
		$ret = 'CREDS_OK';
		while ($row	= mysqli_fetch_assoc($result))
		{
			$info[] = $row;
			if($row['status'] == 1)
			{
				$ret = 'TEST_IS_ALREADY_DONE';
			}
		}

		echo $ret;
		$_SESSION['student_details'] = json_encode($info);
	}
	else
	{
		echo "STUDENT_RECORD_NOT_FOUND";
	}

	mysqli_close($conn);
