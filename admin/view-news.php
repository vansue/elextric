<?php
	include('header.php');
	include('../inc/functions.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
?>
<!-- VALIDATE BIẾN $_GET -->
<?php
	if (isset($_GET['ncid']) && filter_var($_GET['ncid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$ncid = $_GET['ncid'];
	} else {
		redirect_to('/admin/index.php');
	}
?>

<div id="main-content">
	<div class="title-content">
		<p>Thêm mới bài viết</p>
	</div>

	<div class="product-box">
		<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<a href="add-news.php?ncid=<?php echo $ncid; ?>"><img src="../images/news.png" alt=""></a>
			<h4><a href="add-news.php?ncid=<?php echo $ncid; ?>">Thêm mới bài viết</a></h4>
		</div>
		<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
	</div><!--end .product-box-->

	<div class="title-content">
		<p>Danh sách bài viết</p>
	</div>
	<table>
    	<thead>
    		<tr>
    			<th><a href="add-news.php?sort=page">Tên bài viết</a></th>
    			<th><a href="add-news.php?sort=date">Ngày tạo</th>
    			<th><a href="add-news.php?sort=by">Người tạo</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
		<?php
    		//Sắp xếp theo thứ tự của table head
    		if (isset($_GET['sort'])) {
    			switch ($_GET['sort']) {
    				case 'page':
    					$order_by = 'page_name';
    					break;
    				case 'date':
    					$order_by = 'post_on';
    					break;
    				case 'by':
    					$order_by = 'name';
    					break;
    				default:
    					$order_by = 'post_on';
    					break;
    			}
    		} else {
    			$order_by = 'post_on';
    		}
    		//Truy xuất CSDL để hiển thị pages
    		$q = "SELECT p.page_id, p.page_name, p.post_on, p.cat_id, p.user_id, CONCAT_WS(' ', u.first_name, u.last_name) AS name ";
    		$q .= " FROM pages AS p ";
    		$q .= " JOIN users AS u USING(user_id) ";
    		$q .= " WHERE cat_id = {$ncid}";
    		$q .= " ORDER BY {$order_by} ASC";
    		$r = mysqli_query($dbc, $q);
    			confirm_query($r, $q);
    		while ($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) :
    	?>
            <tr>
                <td><?php echo $pages['page_name']; ?></td>
                <td><?php echo $pages['post_on']; ?></td>
                <td><?php echo $pages['name']; ?></td>
                <td class='edit'><a href="add-news.php?ncid=<?php echo $ncid; ?>&epid=<?php echo $pages['page_id']; ?>"><img src="../images/b_edit.png" alt="edit"></a></td>
                <td class='delete'><a href="add-news.php?ncid=<?php echo $ncid; ?>&dpid=<?php echo $pages['page_id']; ?>"><img src="../images/b_drop.png" alt="drop"></a></td>
            </tr>
        <?php endwhile; ?>
    	</tbody>
    </table>
</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>