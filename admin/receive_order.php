<?php
	include 'includes/session.php';

	if(isset($_POST['cart-id'])){
		
		$conn = $pdo->open();

		try{
            $id = $_POST['cart-id'];
			$stmt = $conn->prepare("UPDATE sales SET order_status='RECEIVED' WHERE id=$id");
			$stmt->execute();
			$_SESSION['success'] = 'Product Received';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select product first.';
	}
	header('location: orders.php');
?>