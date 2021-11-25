<?php 
					require_once 'account.php';
					$account = new Account('jkamogolovaorg', 'amoContact');
					require_once 'controller.php';
					$controller = new Controller($account);
					
					echo json_encode($controller->testAmo(), JSON_UNESCAPED_UNICODE);
?>