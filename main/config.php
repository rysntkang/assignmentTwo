<?php

function redirect($url=''){
	if(!empty($url))
	echo '<script>location.href="http://localhost/assignmentTwo/main' .$url. '"</script>';
}

?>