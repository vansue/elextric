<?php
	ob_start();
	include('inc/header.php');
	require_once('inc/functions.php');
	require_once('inc/mysqli_connect.php');
	include('inc/first-sidebar.php');
?>
<div id="main-content">

<?php
	if (isset($_GET['ncid']) && filter_var($_GET['ncid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
		$ncid = $_GET['ncid'];
		$query = "SELECT cat_name FROM n_categories WHERE cat_id = {$ncid}";
		$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
		if (mysqli_num_rows($result) == 1) {
			list($ncat_name) = mysqli_fetch_array($result, MYSQLI_NUM);
?>
			<div class="title-content">
				<p><?php echo $ncat_name; ?></p>
			</div>
<?php
		} else {
			//Không có danh mục tin, quay về trang chủ
            redirect_to();
		}

		$q = "SELECT p.page_name, p.page_id, LEFT(p.content, 400) AS content, ";
		$q .= " date_format(p.post_on, '%b %d, %y') AS date, ";
		$q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
		$q .= " FROM pages AS p ";
		$q .= " INNER JOIN users AS u ";
		$q .= " USING (user_id) ";
		$q .= " WHERE p.cat_id={$ncid} ";
		$q .= " ORDER BY date ASC LIMIT 0, 10";
		$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
		if(mysqli_num_rows($r) > 0) {
            //Nếu có post thì hiển thị ra trình duyệt
            while($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                    <div class='post'>
                        <h2><a href='single.php?pnid={$pages['page_id']}'>{$pages['page_name']}</a></h2>
                        <p>".the_excerpt($pages['content'])." ... <a href='single.php?pnid={$pages['page_id']}'>Xem tiếp</a></p>
                        <p class='meta'><strong>Posted by:</strong> <a href='author.php?aid={$pages['user_id']}'> {$pages['name']}</a> | <strong>On: </strong> {$pages['date']} </p>
                    </div>
                ";
            } //end while loop
        } else {
            echo "<p class='notice'>Chưa có bài viết nào trong mục này</p>";
        }
	else :
?>
	<div class="title-content">
		<p>Sản phẩm mới</p>
	</div>
	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/laptop.png" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->

	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/p4.gif" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->

	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/p5.gif" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->
	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/laptop.png" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->

	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/p4.gif" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->

	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/p5.gif" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->

	<div class="title-content">
		<p>Sản phẩm khuyến mại</p>
	</div>
	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/laptop.png" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->

	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/p4.gif" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->

	<div class="product-box">
		<img src="images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<h4><a href="#">Motorola 156 MK-VL</a></h4>
			<a href="#"><img src="images/p5.gif" alt=""></a>
			<p class="price"><span>350$</span> 270$</p>
		</div>
		<img src="images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		<div class="prod-detail-tab group">
			<a href="#" data-tooltip="Add to cart" class="tool"><img src="images/cart.gif" alt="" /></a>
			<a href="#" data-tooltip="Specials" class="tool"><img src="images/favs.gif" alt="" /></a>
			<a href="#" data-tooltip="Gift" class="tool"><img src="images/favorites.gif" alt="" /></a>
			<a href="#" class="detail-a">Chi tiết</a>
		</div>
	</div><!--end .product-box-->
<?php endif; ?>
</div><!--end #main-content-->

<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>