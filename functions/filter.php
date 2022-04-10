<?php
    include 'conn.php';
    $conn = $pdo->open();
    $name = $_POST['name'];
    $category = $_POST['category'];
    $min_price = $_POST['min_price'];
    $max_price = $_POST['max_price'];

    $sql_name = '';
    $sql_cat = '';
    $sql_min = '';
    $sql_max = '';

    if($name != ''){
        $sql_name = " AND name LIKE '%".$name."%'";
    }

    if($category != ''){
        $sql_cat = " AND category_id=".$category;
    }

    if($min_price != ''){
        $sql_min = " AND price>=".$min_price;
    }

    if($max_price != ''){
        $sql_max = " AND price<=".$max_price;
    }

    $sql = "SELECT * FROM products WHERE 1 ".$sql_name.$sql_cat.$sql_min.$sql_max;

    try{
        $stmt = $conn->prepare($sql);
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
                    <td class='product-category'>
                        ".$row['category_id']."
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