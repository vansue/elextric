<?php
    $title = "Quản lý đơn hàng | Elextronic";
    include('inc/header.php');
	require_once('../inc/functions.php');
	require_once('../inc/mysqli_connect.php');
	include('inc/first-sidebar.php');
?>
<!-- VALIDATE BIẾN $_GET -->
<?php

    //Phân trang danh sách đơn hàng
    //Đặt số trang muốn hiển thị ra trình duyệt
    $display = 5;
    //Xác định vị trí bắt đầu
    $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

?>

<div id="main-content">
	<div class="title-content">
		<p>Danh sách đơn hàng</p>
	</div>
	<table>
    	<thead>
    		<tr>
    			<th><a href="order.php?sort=order">Đơn hàng</a></th>
                <th><a href="order.php?sort=name">Người mua</a></th>
    			<th>Địa chỉ</th>
    			<th>Điện thoại</th>
                <th><a href="order.php?sort=date">Ngày mua</a></th>
                <th><a href="order.php?sort=status">Trạng thái</a></th>
                <th>Ghi chú</th>
    		</tr>
    	</thead>
    	<tbody>
		<?php
    		//Sắp xếp theo thứ tự của table head
    		if (isset($_GET['sort'])) {
    			switch ($_GET['sort']) {
    				case 'order':
    					$order_by = 'order_id';
    					break;
                    case 'name':
                        $order_by = 'name';
                        break;
    				case 'date':
    					$order_by = 'buy_date';
    					break;
    				case 'status':
    					$order_by = 'status';
    					break;
    				default:
    					$order_by = 'order_id';
    					break;
    			}
    		} else {
    			$order_by = 'order_id';
    		}
    		//Truy xuất CSDL để hiển thị pages
    		$q = "SELECT o.order_id, p.page_name, p.position, p.post_on, p.cat_id, p.user_id, CONCAT_WS(' ', u.first_name, u.last_name) AS name ";
    		$q .= " FROM pages AS p ";
    		$q .= " JOIN users AS u USING(user_id) ";
    		$q .= " WHERE cat_id = {$ncid} ";
    		$q .= " ORDER BY {$order_by} ASC ";
            $q .= " LIMIT {$start}, {$display}";
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
    <?php pagination($ncid, $display, 'view-news.php'); ?>
</div><!--end #main-content-->
<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>