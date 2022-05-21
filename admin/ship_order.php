<?php
	include 'includes/session.php';

	if(isset($_POST['cart-id'])){
		
		$conn = $pdo->open();

		try{
            $id = $_POST['cart-id'];
			$stmt = $conn->prepare("UPDATE sales SET order_status='SHIPPED' WHERE id=$id");
			$stmt->execute();
			$_SESSION['success'] = 'Product Shipped';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select product to ship first.';
	}

	header('location: orders.php');
?>