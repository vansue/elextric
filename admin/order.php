<?php
    $title = "Quản lý đơn hàng | Elextronic";
    include('inc/header.php');
	require_once('../inc/functions.php');
	require_once('../inc/mysqli_connect.php');
	include('inc/first-sidebar.php');
?>
<!-- VALIDATE BIẾN $_GET -->
<?php

    if(isset($_GET['oid']) && filter_var($_GET['oid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
        $oid = $_GET['oid'];
        $status = FALSE;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['status']) && filter_var($_POST['status'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
                $status = $_POST['status'];
            }

            $q = "UPDATE orders SET status = {$status} WHERE order_id = {$oid}";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
            if (mysqli_affected_rows($dbc) == 1) {
                $messages = "<p class='notice success'>Cập nhật trạng thái thành công.</p>";
            } else {
                $messages = "<p class='notice'>Cập nhật trạng thái thất bại do lỗi hệ thống.</p>";
            }
        }
    }

    if (isset($_GET['doid']) && filter_var($_GET['doid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
        $doid = $_GET['doid'];
        $q = "DELETE FROM orders WHERE order_id = {$doid}";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        if (mysqli_affected_rows($dbc) == 1) {
            $query = "DELETE FROM order_details WHERE order_id = {$doid}";
            $result = mysqli_query($dbc, $query); confirm_query($result, $query);
            if (mysqli_affected_rows($dbc) > 0) {
                $messages = "<p class='notice success'>Xóa đơn hàng thành công.</p>";
            } else {
                $messages = "<p class='notice'>Xóa đơn hàng thất bại do lỗi hệ thống1.</p>";
            }
        } else {
            $messages = "<p class='notice'>Xóa đơn hàng thất bại do lỗi hệ thống.</p>";
        }
    }

?>

<div id="main-content">
	<div class="title-content">
		<p>Danh sách đơn hàng</p>
	</div>
    <?php
        if (!empty($messages)) echo $messages;
    ?>
	<table>
    	<thead>
    		<tr>
    			<th><a href="order.php?sort=order">Đơn hàng</a></th>
                <th><a href="order.php?sort=name">Người mua</a></th>
    			<th>Địa chỉ</th>
    			<th>Điện thoại</th>
                <th><a href="order.php?sort=date">Ngày mua</a></th>
                <th><a href="order.php?sort=status">Trạng thái</a></th>
                <th>Xóa</th>
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
    		//Truy xuất CSDL để hiển thị orders
    		$q = "SELECT o.order_id, o.address, o.phone, o.buy_date, o.status, CONCAT_WS(' ', u.first_name, u.last_name) AS name ";
    		$q .= " FROM orders AS o ";
    		$q .= " JOIN users AS u USING(user_id) ";
    		$q .= " ORDER BY {$order_by} DESC ";
    		$r = mysqli_query($dbc, $q);
    			confirm_query($r, $q);
    		while ($orders = mysqli_fetch_array($r, MYSQLI_ASSOC)) :
    	?>
            <tr>
                <td><a href="details.php?oid=<?php echo $orders['order_id']; ?>" data-tooltip="Chi tiết đơn hàng <?php echo "#ĐH".$orders['order_id']; ?>" class="tool"><?php echo "#ĐH".$orders['order_id']; ?></a></td>
                <td><?php echo $orders['name']; ?></td>
                <td><?php echo $orders['address']; ?></td>
                <td><?php echo $orders['phone']; ?></td>
                <td><?php echo $orders['buy_date']; ?></td>
                <td>
                    <form action="order.php?oid=<?php echo $orders['order_id']; ?>" method="post">
                        <select name="status">
                        <?php
                            // Set up array for roles
                            $roles = array(1 => 'Chờ', 2 => 'Xong');
                            foreach ($roles as $key => $role) {
                                echo "<option value='{$key}'";
                                    if($key == $orders['status']) {echo "selected='selected'";}
                                echo ">".$role."</option>";
                            }
                            //echo $orders['status'];
                        ?>
                        </select>
                        <p><input type="submit" name="submit" value="Cập nhật" id="cn" /></p>
                    </form>
                </td>
                <td class='delete'><a href="order.php?doid=<?php echo $orders['order_id']; ?>"><img src="../images/b_drop.png" alt="drop"></a></td>
            </tr>
        <?php endwhile; ?>
    	</tbody>
    </table>
</div><!--end #main-content-->
<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>