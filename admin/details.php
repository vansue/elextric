<?php
    $title = "Chi tiết đơn hàng | Elextronic";
    include('inc/header.php');
	require_once('../inc/functions.php');
	require_once('../inc/mysqli_connect.php');
	include('inc/first-sidebar.php');
?>
<!-- VALIDATE BIẾN $_GET -->
<?php
    if(isset($_GET['oid']) && filter_var($_GET['oid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
        $oid = $_GET['oid'];
        $q = "SELECT order_id FROM order_details WHERE order_id = {$oid}";
        $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);
        if (mysqli_num_rows($r) > 0) :
?>
<div id="main-content">
	<div class="title-content">
		<p>Chi tiết đơn hàng <?php echo "#ĐH".$oid; ?></p>
	</div>

	<table>
    	<thead>
    		<tr>
    			<th><a href="order.php?sort=name">Tên sản phẩm</a></th>
                <th><a href="order.php?sort=qty">Số lượng</a></th>
                <th><a href="order.php?sort=price">Đơn giá</a></th>
                <th><a href="order.php?sort=sum">Thành tiền</a></th>
    		</tr>
    	</thead>
    	<tbody>
		<?php
    		//Sắp xếp theo thứ tự của table head
    		if (isset($_GET['sort'])) {
    			switch ($_GET['sort']) {
    				case 'name':
    					$order_by = 'pro_name';
    					break;
                    case 'qty':
                        $order_by = 'qty';
                        break;
    				case 'price':
    					$order_by = 'price';
    					break;
    				case 'sum':
    					$order_by = 'sum';
    					break;
    				default:
    					$order_by = 'pro_name';
    					break;
    			}
    		} else {
    			$order_by = 'pro_name';
    		}
    		//Truy xuất CSDL để hiển thị orders
    		$q = "SELECT od.pro_id, od.qty, od.price, p.pro_name ";
    		$q .= " FROM order_details AS od ";
    		$q .= " JOIN products AS p USING(pro_id) ";
            $q .= " WHERE od.order_id = {$oid}";
    		$q .= " ORDER BY {$order_by} DESC ";
    		$r = mysqli_query($dbc, $q);
    			confirm_query($r, $q);
                $sum = 0;
    		while ($products = mysqli_fetch_array($r, MYSQLI_ASSOC)) :
    	?>
            <tr>
                <td><?php echo $products['pro_name']; ?></td>
                <td><?php echo $products['qty']; ?></td>
                <td><?php echo number_format($products['price'],0,',','.'); ?></td>
                <td><?php echo number_format($products['qty']*$products['price'],0,',','.'); ?></td>
            </tr>
        <?php
            $sum += $products['qty']*$products['price'];
            endwhile;
        ?>
    	</tbody>
    </table>
    <div class='pay'>
        <strong>Tổng tiền: <?php echo number_format($sum,0,',','.')." VNĐ"; ?></strong> | <a href="order.php">Trở về Danh sách đơn hàng</a>
    </div>

    <?php
    else :
?>
<div id="main-content">
    <div class="title-content">
        <p>Chi tiết đơn hàng</p>
    </div>
    <p class="notice">Đơn hàng không tồn tại.</p>

<?php endif; ?>



<?php
    else :
?>
<div id="main-content">
    <div class="title-content">
        <p>Chi tiết đơn hàng</p>
    </div>
    <p class="notice">Chọn một đơn hàng để xem.</p>

<?php endif; ?>
</div><!--end #main-content-->
<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>