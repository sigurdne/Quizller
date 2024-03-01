<?php
	session_start();

	include '../database/config.php';
	$selected_option = $_POST['selected_option'];
	$question_id	 = $_POST['question_id'];
	$score_earned	 = $_POST['score'];
	$student_details = json_decode($_SESSION['student_details']);
	$student_id;

	foreach ($student_details as $obj)
	{
		$student_id = $obj->id;
		$test_id    = $obj->test_id;
	}

	if (!$conn)
	{
		die("Connection failed: " . mysqli_connect_error());
	}
	else
	{
		$stmt = mysqli_prepare($conn, "SELECT id FROM Questions WHERE id = ? AND correctAns = ? LIMIT 1");
		mysqli_stmt_bind_param($stmt, "ss", $question_id, $selected_option);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($result) > 0)
		{
			// Increase question correct count
			$sql = "UPDATE score SET correct_count = correct_count + 1 WHERE question_id = ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "s", $question_id);
			mysqli_stmt_execute($stmt);

			$sql = "UPDATE students SET score = score + ? WHERE id = ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "ss", $score_earned, $student_id);
			if (mysqli_stmt_execute($stmt))
			{
				echo "SCORE_UPDATED_SUCCESSFULLY";
			}
			else
			{
				echo "SCORE_UPDATE_FAILURE";
			}
		}
		else
		{
			// Increase question wrong count
			$sql = "UPDATE score SET wrong_count = wrong_count + 1 WHERE question_id = ?";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "s", $question_id);
			mysqli_stmt_execute($stmt);

			echo "WRONG_ANSWER";
		}
	}

	mysqli_close($conn);