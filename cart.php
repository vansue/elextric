<?php
	ob_start();
	$title = "Giỏ hàng | Elextronic";
	include('inc/header.php');
	include('inc/first-sidebar.php');
?>
<div id="main-content">
<?php
	if (!isset($_SESSION['uid'])) {
		redirect_to('login.php?msg=1');
	}

	if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$pid = $_GET['pid'];
		//Kiểm tra xem sản phẩm có tồn tại trong CSDL không
		$q = "SELECT * FROM products WHERE pro_id = {$pid}";
		$r = mysqli_query($dbc, $q);
		confirm_query($r, $q);
		if (mysqli_num_rows($r) == 1) {
			//Lấy thông tin sản phẩm
			$products = mysqli_fetch_array($r);

			//ADD TO CART================================================
			//Kiểm tra xem trong giỏ hàng đã có sản phẩm chưa
			if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
				//Nếu có rồi
				$max = count($_SESSION['cart']);//Số sản phẩm khác nhau trong giỏ hàng
				$flag = TRUE;
				//Kiểm tra xem sản phẩm hiện tại có trong giỏ hàng chưa
				for ($i=0; $i < $max; $i++) {
					if($_SESSION['cart'][$i]['productid'] == $pid) {
						$_SESSION['cart'][$i]['qty']++;
						$flag = FALSE;
						break;
					}
				}

				if ($flag) {//Sản phẩm hiện tại không có trong giỏ hàng
					$_SESSION['cart'][$max]['productid'] = $pid;
					$_SESSION['cart'][$max]['qty'] = 1;
					$_SESSION['cart'][$max]['name'] = $products['pro_name'];
					$_SESSION['cart'][$max]['price'] = $products['price'];
				}
			} else {
				//Nếu chưa có
				$_SESSION['cart'] = array();
				$_SESSION['cart'][0]['productid'] = $pid;
				$_SESSION['cart'][0]['qty'] = 1;
				$_SESSION['cart'][0]['name'] = $products['pro_name'];
				$_SESSION['cart'][0]['price'] = $products['price'];
			}

		} else {
			echo "<p class='notice'>Sản phẩm không tồn tại.</p>";
		}
	}

	//DELETE CART============================================================
	if (isset($_GET['did']) && filter_var($_GET['did'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$did = $_GET['did'];
		$dmax = count($_SESSION['cart']);//Số sản phẩm khác nhau trong giỏ hàng
		for ($i=0; $i < $dmax; $i++) {
			if ($_SESSION['cart'][$i]['productid'] == $did) {
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart'] = array_values($_SESSION['cart']);
	}
?>
			<!--VIEW CART-->
			<div class='title-content'>
				<p>Giỏ hàng của <?php echo $_SESSION['last_name']; ?></p>
			</div>
<?php
			if(isset($_SESSION['cart'])) :
?>	
				<table>
					<thead>
						<tr>
							<th>Số thứ tự</th>
							<th>Sản phẩm</th>
							<th>Giá</th>
							<th>Số lượng</th>
							<th>Thành tiền</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody>
<?php
				$smax = count($_SESSION['cart']);//Số sản phẩm khác nhau trong giỏ hàng
				for ($i=0; $i < $smax; $i++) :
?>
				<tr>
					<td><?php echo $i+1; ?></td>
	                <td><?php echo $_SESSION['cart'][$i]['name']; ?></td>
	                <td><?php echo number_format($_SESSION['cart'][$i]['price'],0,',','.'); ?></td>
	                <td><?php echo $_SESSION['cart'][$i]['qty']; ?></td>
	                <td><?php echo number_format($_SESSION['cart'][$i]['price']*$_SESSION['cart'][$i]['qty'],0,',','.'); ?></td>
	                <td class='delete'><a href="cart.php?did=<?php echo $_SESSION['cart'][$i]['productid']; ?>"><img src="images/b_drop.png" alt="drop"></a></td>
	            </tr>
<?php
				endfor;

?>
				</tbody>
			</table>
			<div class='pay'>
				<a href="payment.php">Thanh toán</a> | 
				<a href="index.php">Tiếp tục mua sắm</a>
			</div>
<?php
			else :
				echo "<p class='notice'>Giỏ hàng chưa có sản phẩm.</p>";
			endif;
?>

</div><!--end #main-content-->
<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>