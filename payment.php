<?php
	session_start();
	ob_start();
	$title = "Thanh toán | Elextronic";
	require_once('inc/functions.php');
	require_once('inc/mysqli_connect.php');
	include('inc/header.php');
	include('inc/first-sidebar.php');
?>
	<div id="main-content">
		<div class='title-content'>
		<p>Thanh toán</p>
	</div>

	<form action="" method="POST" id="add-n-cat" class="add-form">
		<fieldset>
			<legend>Thanh toán giỏ hàng</legend>
			<p><strong>Khách hàng:</strong> <?php echo $_SESSION['first_name']." ".$_SESSION['last_name'];?></p>

			<label for="address">Địa chỉ:</label>
	        <input type="text" name="address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>" size="20" maxlength="80" tabindex='1' />

	        <label for="phone">Điện thoại:</label>
	        <input type="text" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>" size="20" maxlength="40" tabindex='8' />

	        <p><input type="submit" name="submit" value="Mua hàng" /></p>
		</fieldset>
	</form>

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
</div><!--end #main-content-->
<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>