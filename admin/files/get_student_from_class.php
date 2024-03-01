<?php
	$id;
	$roll_numbers;
	$counter = 0;
	include "../../database/config.php";

	$classesQuery = "SELECT id FROM classes WHERE name = ? LIMIT 1";
	$classesStmt  = mysqli_prepare($conn, $classesQuery);
	mysqli_stmt_bind_param($classesStmt, "s", $_POST['class_name']);
	mysqli_stmt_execute($classesStmt);
	mysqli_stmt_store_result($classesStmt);

	if (mysqli_stmt_num_rows($classesStmt) > 0)
	{
		mysqli_stmt_bind_result($classesStmt, $id);
		mysqli_stmt_fetch($classesStmt);

		$rollQuery = "SELECT rollno FROM student_data WHERE class_id = ?";
		$rollStmt  = mysqli_prepare($conn, $rollQuery);
		mysqli_stmt_bind_param($rollStmt, "i", $id);
		mysqli_stmt_execute($rollStmt);
		mysqli_stmt_store_result($rollStmt);

		$arr  = array();
		$arr1 = array();
		if (mysqli_stmt_num_rows($rollStmt) > 0)
		{
			mysqli_stmt_bind_result($rollStmt, $rollno);
			$i = 1;
			while (mysqli_stmt_fetch($rollStmt))
			{
				$arr["id"]	   = $i;
				$arr["rollno"] = $rollno;
				$arr1[]		   = $arr;
				$i++;
			}

			echo json_encode($arr1);
		}
		else
		{
			echo "0 results";
		}

		mysqli_stmt_close($rollStmt);
	}
	else
	{
		echo "0 results";
	}

	mysqli_stmt_close($classesStmt);
	mysqli_close($conn);
