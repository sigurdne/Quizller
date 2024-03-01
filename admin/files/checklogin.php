<?php
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		include "../../database/config.php";
		$username	  = $_POST["username"];
		$password	  = $_POST["password"];
		$enc_password = hash('sha256', $password, false);
		$sql		  = "SELECT * FROM teachers WHERE email = ? AND password = ?";
		$stmt		  = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $username, $enc_password);
		mysqli_stmt_execute($stmt);
		$res		  = mysqli_stmt_get_result($stmt);

		if (mysqli_num_rows($res) == 1)
		{
			echo "success";
			// if login successful then initialize the session
			$row				 = mysqli_fetch_assoc($res);
			$_SESSION["user_id"] = $row["id"];
		}
		else
		{
			echo "fail";
		}
	}