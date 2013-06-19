<?php
	ob_start();
    $title = "Danh mục bài viết | Elextronic";
    include('header.php');
	include('../inc/functions.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
    admin_success();
?>
<!-- VALIDATE BIẾN $_GET -->
<?php
	if (isset($_GET['ncid']) && filter_var($_GET['ncid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$ncid = $_GET['ncid'];
        $q = "SELECT cat_name FROM n_categories WHERE cat_id={$ncid}";
        $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);
        if(mysqli_num_rows($r) == 1) {
            list($cat_name) = mysqli_fetch_array($r, MYSQLI_NUM);
        } else {
            redirect_to();
        }
	} else {
		redirect_to('admin/index.php');
	}
?>

<div id="main-content">
	<div class="title-content">
		<p>Danh mục bài viết: <?php if(isset($cat_name)) echo $cat_name; ?></p>
	</div>
<?php
    if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        switch ($msg) {
            case '1':
                echo "<p class='notice success'>Xóa bài viết thành công.</p>";
                break;
            case '2':
                echo "<p class='notice'>Bài viết không tồn tại.</p>";
                break;
            case '3':
                echo "<p class='notice success'>Thêm mới bài viết thành công.</p>";
                break;
            case '4':
                echo "<p class='notice success'>Chỉnh sửa bài viết thành công.</p>";
                break;
            default:
                redirect_to('admin/index.php');
                break;
        }
    }
?>
	<div class="product-box">
		<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
		<div class="cen-prod-box">
			<a href="m-news.php?ncid=<?php echo $ncid; ?>"><img src="../images/news.png" alt=""></a>
			<h4><a href="m-news.php?ncid=<?php echo $ncid; ?>">Thêm mới bài viết</a></h4>
		</div>
		<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
	</div><!--end .product-box-->

	<div class="title-content">
		<p>Danh sách bài viết</p>
	</div>
	<table>
    	<thead>
    		<tr>
    			<th><a href="m-news.php?sort=page">Tên bài viết</a></th>
                <th><a href="m-news.php?sort=pos">Vị trí</th>
    			<th><a href="m-news.php?sort=date">Ngày tạo</th>
    			<th><a href="m-news.php?sort=by">Người tạo</th>
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
                    case 'pos':
                        $order_by = 'position';
                        break;
    				case 'date':
    					$order_by = 'post_on';
    					break;
    				case 'by':
    					$order_by = 'name';
    					break;
    				default:
    					$order_by = 'position';
    					break;
    			}
    		} else {
    			$order_by = 'position';
    		}
    		//Truy xuất CSDL để hiển thị pages
    		$q = "SELECT p.page_id, p.page_name, p.position, p.post_on, p.cat_id, p.user_id, CONCAT_WS(' ', u.first_name, u.last_name) AS name ";
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
                <td><?php echo $pages['position']; ?></td>
                <td><?php echo $pages['post_on']; ?></td>
                <td><?php echo $pages['name']; ?></td>
                <td class='edit'><a href="m-news.php?ncid=<?php echo $ncid; ?>&epid=<?php echo $pages['page_id']; ?>"><img src="../images/b_edit.png" alt="edit"></a></td>
                <td class='delete'><a href="m-news.php?ncid=<?php echo $ncid; ?>&dpid=<?php echo $pages['page_id']; ?>"><img src="../images/b_drop.png" alt="drop"></a></td>
            </tr>
        <?php endwhile; ?>
    	</tbody>
    </table>
</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>