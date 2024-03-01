<?php
	include '../database/config.php';
	session_start();

	$student_roll_number = $_POST['rollNumber'];
	$student_password	 = $_POST['password'];

	$sql1		= "select id from student_data where rollno = '$student_roll_number'";
	$result1	= mysqli_query($conn, $sql1);
	$row1		= mysqli_fetch_assoc($result1);
	$student_id = !empty($row1["id"]) ? (int)$row1["id"] : 0;

	$result = mysqli_query($conn, "Select id, test_id, rollno, score, status from students where rollno = '" . $student_id . "' and password = '" . $student_password . "'");// . and status = 0 ");

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
