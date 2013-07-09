	<div id="second-sidebar">
		<?php
			if(isset($_SESSION['last_name'])) :
				if(isset($_SESSION['cart'])) {
					$max = count($_SESSION['cart']);
					$sum_qty = 0;
					$sum_price = 0;
					for ($i=0; $i < $max; $i++) {
						$sum_qty += $_SESSION['cart'][$i]['qty'];
						$sum_price += $_SESSION['cart'][$i]['price']*$_SESSION['cart'][$i]['qty'];
					}
				}
		?>
				<div id="shopping-cart" class="group">
					<h2><a href="cart.php">Xin chào <?php echo $_SESSION['last_name']; ?> </a></h2>
					<div id="cart-details">
						<p>
						<?php echo isset($sum_qty) ? $sum_qty : 0; ?> sản phẩm</p>
						<div id="border-cart"></div>
						<p>Tổng: <span><?php echo isset($sum_price) ? number_format($sum_price,0,',','.') : 0; ?></span> đ</p>
					</div>
					<a href="cart.php" data-tooltip="Giỏ hàng của bạn" class="tool"><img src="images/shoppingcart.png" alt="Checkout" /></a>
				</div>

		<?php endif; ?>

		<div class='typical'>
			<h3>Electronix's News</h3>
			<div class="box" id="boxnews">

			<?php
				$q = "SELECT page_id, page_name, content, date_format(post_on, '%b %d, %y') AS date FROM pages ORDER BY post_on DESC LIMIT 3";
				$r = mysqli_query($dbc, $q);
					confirm_query($r, $q);
					if (mysqli_num_rows($r) > 0) {
						while ($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
							echo "
								<div>
									<p class='date'>{$pages['date']}</p>
									<h4><a href='single.php?pnid={$pages['page_id']}' class='newstitle'>{$pages['page_name']}</a></h4>
									<p>".the_excerpt($pages['content'], 150)."</p>
								</div>
							";
						}
					}
			?>
				<!--<div>
					<p class='date'>August 20, 2012</p>
					<h4><a href='#' class="newstitle">Lorem ipsum dolor sit amet</a></h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Virtutes timidiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				</div>

				<div class="news">
					<p class='date'>August 20, 2012</p>
					<h4><a href='#' class="newstitle">Lorem ipsum dolor sit amet</a></h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Virtutes timidiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				</div>

				<div class="news">
					<p class='date'>August 20, 2012</p>
					<h4><a href='#' class="newstitle">Lorem ipsum dolor sit amet</a></h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Virtutes timidiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				</div>-->
			</div>
		</div>

		<div class="banner-adds">
			<a href="#"><img src="images/bann2.jpg" alt=""></a>
		</div>
	</div><!--end #second-sidebar-->
</div><!--end #content-->