<?php
	$title = "Danh mục bài viết | Elextronic";
	include('header.php');
	include('../inc/functions.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
	admin_success();
?>

	<div id="main-content">
		<div class="title-content">
			<p>Bài viết</p>
		</div>

		<?php
			//Truy xuất CSDL để hiển thị categories
    		$q = "SELECT cat_id, cat_name, position ";
    		$q .= " FROM n_categories ";
    		$q .= " ORDER BY position ASC";
    		$r = mysqli_query($dbc, $q);
    			confirm_query($r, $q);
    		while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) :
		?>

		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="<?php echo BASE_URL.'admin/view-news.php?ncid='.$cats['cat_id']?>"><img src="../images/news.png" alt=""></a>
				<h4><a href="<?php echo BASE_URL.'admin/view-news.php?ncid='.$cats['cat_id']?>"><?php echo $cats['cat_name']; ?></a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->

		<?php endwhile; ?>

	</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>