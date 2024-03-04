<?php
	session_start();
	include '../database/config.php';
	$testName = "";

	if (isset($_SESSION['student_details']))
	{
		$data		  = $_SESSION['student_details'];
		$student_data = json_decode($data);

		foreach ($student_data as $obj)
		{
			$stmt = mysqli_prepare($conn, "SELECT * FROM tests WHERE id = ? AND status_id IN (2)");
			mysqli_stmt_bind_param($stmt, "i", $obj->test_id);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			if (mysqli_num_rows($result) > 0)
			{
				while ($row = mysqli_fetch_assoc($result))
				{
					$_SESSION['test_id'] = $row['id'];
					$testName = $row['name'];
				}
			}
			else
			{
				$testName = 'Ingen aktive';
			}
			mysqli_stmt_close($stmt);
		}
		echo $testName;
	}
	else
	{
		echo "Not Found";
	}

	mysqli_close($conn);
