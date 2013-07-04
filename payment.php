<?php
	ob_start();
	$title = "Thanh toán | Elextronic";
	require_once('inc/functions.php');
	require_once('inc/mysqli_connect.php');
	include('inc/header.php');
	include('inc/first-sidebar.php');
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
		$errors = array();
		//Mặc định cho các trường nhập liệu là FALSE
		$add = $phone = FALSE;

		// Check for address
		if (!empty($_POST['address'])) {
			$add = mysqli_real_escape_string($dbc, strip_tags($_POST['address']));
		} else {
			$errors[] = "address";
		}

        // Check for phone
        if (isset($_POST['phone']) && preg_match('/^[\d]{8,12}$/', $_POST['phone'])) {
			$phone = mysqli_real_escape_string($dbc, strip_tags($_POST['phone']));
		} else {
			$errors[] = "phone";
		}

		if ($add && $phone) {
			if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
				//Chèn giá trị vào CSDL
				$q = "INSERT INTO orders(user_id, address, phone, buy_date, status) ";
				$q .= " VALUES ({$_SESSION['uid']}, '{$add}', '{$phone}',  NOW(),  1)";
				$r = mysqli_query($dbc, $q);
				$order_id = mysqli_insert_id($dbc);
					confirm_query($r, $q);
				if (mysqli_affected_rows($dbc) == 1) {

					$flag = FALSE;
					$umax = count($_SESSION['cart']);//Số sản phẩm khác nhau trong giỏ hàng
					for ($i=0; $i < $umax; $i++) {
						$pro_id = $_SESSION['cart'][$i]['productid'];
						$qty = $_SESSION['cart'][$i]['qty'];
						$price = $_SESSION['cart'][$i]['price'];
						$q = "INSERT INTO order_details(order_id, pro_id, qty, price) ";
						$q .= " VALUES ($order_id, $pro_id, $qty,  $price)";
						$r = mysqli_query($dbc, $q);
							confirm_query($r, $q);
						if (mysqli_affected_rows($dbc) == 1) {
							$flag = TRUE;
						}
					}

					if ($flag) {
						$message = "<p class='notice success'>Mua hàng thành công. Hàng sẽ được gửi đến địa chỉ của bạn trong vòng 1 tuần trước ngày ".date('d-m-Y', time()+(7 * 24 * 60 * 60)).".</p>";
						unset($_SESSION['cart']);
					} else {
						$message = "<p class='notice'>Mua hàng thất bại do lỗi hệ thống.</p>";
					}
				} else {
					$message = "<p class='notice'>Mua hàng thất bại do lỗi hệ thống.</p>";
				}
			} else {
				$message = "<p class='notice'>Không có sản phẩm nào trong giỏ hàng.</p>";
			}

		} else {
			$message = "<p class='notice'>Điền đầy đủ các trường.</p>";
		}
	}
?>
	<div id="main-content">
		<div class='title-content'>
		<p>Thanh toán</p>
	</div>
	<?php if(!empty($message)) echo $message; ?>
	<form action="" method="POST" id="add-n-cat" class="add-form">
		<fieldset>
			<legend>Thanh toán giỏ hàng</legend>
			<p><strong>Khách hàng:</strong> <?php echo $_SESSION['first_name']." ".$_SESSION['last_name'];?></p>

			<label for="address">Địa chỉ: <span class="required">*</span>
				<?php
					if(isset($errors) && in_array('address', $errors)) {
						echo "<p class='notice'>Điền địa chỉ giao hàng.</p>";
					}
				?>
			</label>
	        <input type="text" name="address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>" size="20" maxlength="80" tabindex='1' />

	        <label for="phone">Điện thoại: <span class="required">*</span>
				<?php
					if(isset($errors) && in_array('phone', $errors)) {
						echo "<p class='notice'>Điền số điện thoại hợp lệ của bạn.</p>";
					}
				?>
	        </label>
	        <input type="text" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" size="20" maxlength="40" tabindex='8' />

	        <p><input type="submit" name="submit" value="Mua hàng" /></p>
		</fieldset>
	</form>
	<?php
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
				<p>Giỏ hàng của bạn</p>
			</div>
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
		if(isset($_SESSION['cart'])) {
			$smax = count($_SESSION['cart']);//Số sản phẩm khác nhau trong giỏ hàng
			for ($i=0; $i < $smax; $i++) :
?>
			<tr>
				<td><?php echo $i+1; ?></td>
                <td><?php echo $_SESSION['cart'][$i]['name']; ?></td>
                <td><?php echo number_format($_SESSION['cart'][$i]['price'],0,',','.'); ?></td>
                <td><?php echo $_SESSION['cart'][$i]['qty']; ?></td>
                <td><?php echo number_format($_SESSION['cart'][$i]['price']*$_SESSION['cart'][$i]['qty'],0,',','.'); ?></td>
                <td class='delete'><a href="payment.php?did=<?php echo $_SESSION['cart'][$i]['productid']; ?>"><img src="images/b_drop.png" alt="drop"></a></td>
            </tr>
<?php
			endfor;
		}
?>
				</tbody>
			</table>
</div><!--end #main-content-->
<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>