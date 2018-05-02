<?php
	$conn = mysqli_connect('localhost', 'root', 'raspberry', 'todo');
	$result = $conn->query("SELECT task FROM tasks");
	if ($result->num_rows >0){
			while($row = $result->fetch_assoc()){
					echo '- ' . $row['task'] . '<br>';
				}
		}else{
			echo "Per oggi nulla :)";
			}
?>

