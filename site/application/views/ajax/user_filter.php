<?php
foreach($users as $user)
{
	$name[] = $user['name'];
}	
echo json_encode($name);
?>