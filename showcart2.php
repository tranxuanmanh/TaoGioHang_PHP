<?php 
session_start();
if(isset($_POST['add'])){
    $quantity=(int)$_POST["quantity"];
    $price=(double)$_POST["price"];
    $name=$_POST["name"];
    $id=(int)$_POST['id'];
}
//Ham them san pham
function addsp($id,$ten,$gia,$soluong){
if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=array();
}
if(isset($_SESSION['cart'][$id])){
    if(is_array($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]['quantity']+=$soluong;
    }else{
        $_SESSION['cart'][$id]=array(
            'name'=>$ten,
            'price'=>$gia,
            'quantity'=>$soluong
        );
    }
}else{
    $_SESSION['cart'][$id]=array(
        'name'=>$ten,
        'price'=>$gia,
        'quantity'=>$soluong
    );
}

}
//Goi ham them san pham
if (isset($quantity) && isset($id) && isset($name) && isset($price)) {
    addsp($id, $name, $price, $quantity);
    header("Location: ".$_SERVER['PHP_SELF']);  // Chuyển hướng về trang hiện tại nhưng không có query string
    exit();  
}
//Xoa san pham theo id
function remove($id){
    if(isset($_SESSION['cart'][$id])){
        unset($_SESSION['cart'][$id]);
        return true;
    }
    return false;
}
//Goi ham xoa
if(isset($_GET['remove'])){
    $id=$_GET['remove'];
    $bool= remove($id);
    if($bool){
        echo "<script type='text/javascript'> confirm('Xoa thanh cong');</script>";
    }
}
//Ham xoa tat ca
if(isset($_GET['clear'])){
    $_SESSION['cart']=null;
    unset($_SESSION['cart']);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Show</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
<div class="row mt-2">
    <div class="col-10 mx-auto">
         <?php 
            if(isset($_SESSION['cart'])&&!empty($_SESSION['cart'])){      
        echo "        
        <table class='table table-bordered'>
            <tr>
                <th>STT</th>
                <th>Id</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Thanh tien</th>
                <th>Action</th>
            </tr>
            ";
                       
            $tongtien=0;
            $thanhtien=0;
            $count=0;
            foreach($_SESSION['cart'] as $key=>$value){
                if(is_array($value)){
                    $thanhtien=(double)$value['price']*(int)$value['quantity'];
                    $name=$value['name'];
                    $price=(double)$value['price'];
                    $quantity=(int)$value['quantity'];
                    $tongtien+=$thanhtien;
                    $count++;

                    echo 
                         "<tr>".                   
                         "<td>$count</td>".
                         "<td>$key</td>". 
                         "<td>$name</td>".
                         "<td>
                         <input type='number' min=1 max=100 value='$quantity' >
                         
                         </td>".
                         "<td>$price</td>".
                         "<td>$thanhtien</td>".
                         "<td>
                         <a href='?remove=$key' class='btn btn-success'>Xoa</a>
                         </td>".
                        "</tr>";

                }else{
                    echo "<p>$key khong phai la mang</p>";
                }
            }
            echo 
                 "<tr>". 
                    "<td colspan='6' style='text-align:right'>Tong tien: $tongtien</td>".            
                 "</tr>";
           
        }else{
            echo "<h2>Gio hang trong</h2>";
        }
            ?>
                  
            
        </table>
        <a href="./addsp.php" class="btn btn-danger">Quay lai mua</a>
        <a href="?clear" onclick="return confirm('Xac nhan xoa tat ca')">Xoa het</a>
    </div>
</div>






        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
