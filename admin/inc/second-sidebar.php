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
			<?php
			$q = "SELECT p.page_name, c.page_id, c.author, c.comment, c.comment_date FROM comments AS c JOIN pages AS p USING(page_id) ORDER BY comment_date DESC LIMIT 4";
			$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);
				date_default_timezone_set('Asia/Ho_Chi_Minh');
				if (mysqli_num_rows($r) > 0) {
					while ($coms = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						if (strlen(strip_tags($coms['comment'])) > 400) {
							$comment = the_excerpt($coms['comment'], 150)." ...";
						} else {
							$comment = strip_tags($coms['comment']);
						}
						echo "
							<div>
								<h4 class='newstitle'><strong>{$coms['author']}</strong></h4>
								<p>".$comment."</p>
								<p class='date'><a href='../single.php?pnid={$coms['page_id']}'>{$coms['page_name']}</a>   ".show_time($coms['comment_date'])."</p>
							</div>
						";
					}
				}
			?>
			</div>
		</div>
	</div><!--end #second-sidebar-->
</div><!--end #content-->