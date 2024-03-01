<?php
	include "../../database/config.php";
	$starting_roll_number = $_POST['starting_roll_number'];
	$ending_roll_number	  = $_POST['ending_roll_number'];
	$class_id;
	$sql				  = "INSERT INTO classes (name) VALUES (?)";

	if ($stmt = mysqli_prepare($conn, $sql))
	{
		mysqli_stmt_bind_param($stmt, "s", $class_name);
		$class_name = $_POST['class_name'];

		if (mysqli_stmt_execute($stmt))
		{
			$id	  = "SELECT id FROM classes WHERE name = ? LIMIT 1";
			if ($stmt = mysqli_prepare($conn, $id))
			{
				mysqli_stmt_bind_param($stmt, "s", $class_name);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);

				if (mysqli_num_rows($result) > 0)
				{
					while ($row = mysqli_fetch_assoc($result))
					{
						$class_id = $row['id'];
					}

					$insert_roll_numbers = "INSERT INTO student_data (rollno, class_id) VALUES (?, ?)";
					if ($stmt = mysqli_prepare($conn, $insert_roll_numbers))
					{
						mysqli_stmt_bind_param($stmt, "si", $roll_number, $class_id);

						for ($x = $starting_roll_number; $x <= $ending_roll_number; $x++)
						{
							$roll_number = $x;
							mysqli_stmt_execute($stmt);
						}
						echo "Success";
					}
					else
					{
						echo "Error: " . mysqli_error($conn);
					}
				}
				else
				{
					echo "Failure";
				}
			}
			else
			{
				echo "Error: " . mysqli_error($conn);
			}
		}
		else
		{
			echo "Error: " . mysqli_error($conn);
		}
	}
	else
	{
		echo "Error: " . mysqli_error($conn);
	}

	mysqli_close($conn);
	