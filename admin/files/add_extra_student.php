<?php
	$id;
	include "../../database/config.php";

	$stmt = mysqli_prepare($conn, "SELECT id FROM classes where name = ?");
	mysqli_stmt_bind_param($stmt, "s", $_POST['class_name']);
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	if (mysqli_num_rows($result) > 0)
	{
		// output data of each row
		while ($row = mysqli_fetch_assoc($result))
		{
			$id = $row['id'];
		}

		$stmt = mysqli_prepare($conn, "INSERT INTO student_data (rollno, class_id) VALUES (?, ?)");
		mysqli_stmt_bind_param($stmt, "ii", $_POST['extra_roll_number'], $id);
		if (mysqli_stmt_execute($stmt))
		{
			echo "New record created successfully";
		}
		else
		{
			echo "Error: " . mysqli_stmt_error($stmt);
		}
	}
	else
	{
		echo "0 results";
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
