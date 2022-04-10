<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<link rel="stylesheet" href="css/filter.css">
<div class="wrapper h-100">

	<?php include 'includes/navbar.php'; ?>
	
	  <div class="content-wrapper h-100">
	    <div class="container h-100">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-12">
	        		<?php
	        			if(isset($_SESSION['error'])){
	        				echo "
	        					<div class='alert alert-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}
	        		?>
                    <div class='col-sm-12'>
                        <div class='box box-solid' style='padding:20px 0px 20px 10px;'>
                            <h2 style='margin:0px 0px 10px 0px;'>Search Products</h2>
                            <div class="search-inputs">
                                <div class='search-row'>
                                    <div>
                                        <input type="text" placeholder="Product name.." style='height:26px; width:250px' id='search-product-name'> 
                                    </div>
                                    <select style='height:26px; width:200px;' id='search-product-category'>
                                        <option value=''>All Product Types</option>
                                        <?php
                                            try{
                                                $stmt = $conn->prepare("SELECT * FROM category");
                                                $stmt->execute();
                                                foreach ($stmt as $row) {
                                                    echo "
                                                        <option value='".$row['id']."'>".$row['name']."</option>
                                                    ";
                                                }
                                            }
                                            catch(PDOException $e){
                                                echo "There is some problem in connection: " . $e->getMessage();
                                            }
                                        ?>
                                    </select>
                                        </div>
                                <div class='search-row' style='margin-top:10px;'>
                                    <div><input type="number" placeholder="Min. Price.." style='height:26px; width:120px;' id='search-min-price'></div>
                                    <div><input type="number" placeholder="Max. Price.." style='height:26px; width:120px;' id='search-max-price'></div>
                                    <button class='btn btn-primary search' style='height:26px; width:120px; padding:0px 5px 0px 5px;'>Search</button>
                                </div>
                                <div style='margin-bottom:10px;'></div>
                                <div style='width:100%; overflow:auto; max-height:80vh;'>
                                    <table class='filter-table js-sort-table'>
                                        <thead style=''>
                                            <tr>
                                                <td class='product-info'>
                                                    Product Name
                                                </td>
                                                <td class='product-price'>
                                                    Price
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody id='filter-results'>
                                        <?php
		       			
                                            $conn = $pdo->open();

                                            try{
                                                $stmt = $conn->prepare("SELECT * FROM products");
                                                $stmt->execute();
                                                foreach ($stmt as $row) {
                                                    $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                                    echo "
                                                        <tr>
                                                            <td class='product-info' style='display:flex; width:100%;'>
                                                                <img style='display:inline;' src='".$image."' class='thumbnail'>
                                                                <div style='flex:100%;'><a href='product.php?product=".$row['slug']."' style='font-size:23px;'>".$row['name']."</a></div>
                                                            </td>
                                                            <td class='product-price'>
                                                                <b>PHP ".number_format($row['price'], 2)."</b>
                                                            </td>
                                                        </tr>
                                                    ";
                                                }
                                            }
                                            catch(PDOException $e){
                                                echo "There is some problem in connection: " . $e->getMessage();
                                            }

                                            $pdo->close();

                                        ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
    $(document).ready(function(){
        $(document).on('click', '.search', function() {
            var product_name = document.getElementById("search-product-name").value;
            var product_category = document.getElementById("search-product-category").value;
            var min_price = document.getElementById("search-min-price").value;
            var max_price = document.getElementById("search-max-price").value;
            $.ajax({
                url:"functions/filter.php",
                method:"POST",
                data:{name:product_name,category:product_category,min_price:min_price,max_price:max_price},
                dataType:"html",
                success:function(data) {
                    $("#filter-results").html(data);
                },
                error:function(){
                    alert("Something went wrong");
                }
            });
        });
    });
</script>
<script src="dist/js/sort-table.min.js"></script>
</body>
</html>