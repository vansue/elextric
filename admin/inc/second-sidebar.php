	<?php
		$q = "SELECT COUNT(order_id) FROM orders WHERE status = 1";
		$r = mysqli_query($dbc,$q); confirm_query($r, $q);
		if (mysqli_num_rows($r) > 0) {
			list($record) = mysqli_fetch_array($r, MYSQLI_NUM);
			$msg = $record." đơn hàng chờ";
		} else {
			$msg = "0 đơn hàng chờ";
		}

	?>
	<div id="second-sidebar">
		<div id="shopping-cart" class="group">
			<h2><a href="../edit-profile.php">Xin chào <?php echo $_SESSION['last_name'];?>!</a></h2>
			<div id="cart-details">
				<a href="order.php" id="red"><?php echo $msg;?></a>
				<a href='logout.php'>Đăng xuất</a>
			</div>
			<a href="../edit-profile.php" data-tooltip="<?php echo $_SESSION['last_name'];?>" class="tool"><img src="../images/a_avatar.png" alt="Admin" /></a>
		</div>

		<div class='typical'>
			<h3>Bình luận mới</h3>
			<div class="box" id="boxnews">
				<div>
					<p class='date'>August 20, 2012</p>
					<h4><a href='#' class="newstitle">Lorem ipsum dolor sit amet</a></h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Virtutes timidiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				</div>

				<div class="news">
					<p class='date'>August 20, 2012</p>
					<h4><a href='#' class="newstitle">Lorem ipsum dolor sit amet</a></h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Virtutes timidiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				</div>
			</div>
		</div>
	</div><!--end #second-sidebar-->
</div><!--end #content-->