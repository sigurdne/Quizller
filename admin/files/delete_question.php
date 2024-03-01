<?php

include "../../database/config.php";
$question_id = $_POST['question_id'];
$test_id = $_POST['test_id'];

$sql = "DELETE FROM question_test_mapping WHERE question_id = ? AND test_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $question_id, $test_id);
mysqli_stmt_execute($stmt);
