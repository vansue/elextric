<?php
	ob_start();
	include('header.php');
	include('../inc/functions.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
?>

<!--+++++++++++++++++++++++++++++ VALIDATE BIẾN GET ++++++++++++++++++++++++++++-->
<?php
	if (isset($_GET['ecid'])) {
		if(filter_var($_GET['ecid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
			$ecid = $_GET['ecid'];
			//Lấy dữ liệu từ CSDL
				$q = "SELECT cat_name, position FROM n_categories WHERE cat_id = {$ecid}";
				$r = mysqli_query($dbc, $q);
					confirm_query($r, $q);
				if (mysqli_num_rows($r) == 1) {//Nếu category tồn tại trong CSDL, xuất dữ liệu ra ngoài trình duyệt
					list($ecat_name, $eposition) = mysqli_fetch_array($r, MYSQLI_NUM);
				} else {//Nếu ecid không hợp lệ
					$messages = "<p class='notice'>Danh mục không tồn tại.</p>";
				}
		} else {
			redirect_to('admin/index.php');
		}
	} else {
		$ecid = null;
	}
?>

<!--+++++++++++++++++++++++++++++ VALIDATE FORM ++++++++++++++++++++++++++++-->

<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
		//Kiểm tra các trường của form
		$errors = array();//Biến bắt lỗi
		if (empty($_POST['n-category'])) {
			$errors[] = "category";
		} else {
			$n_cat_name = mysqli_real_escape_string($dbc, strip_tags($_POST['n-category']));
		}

		if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
			$position = $_POST['position'];
		} else {
			$errors[] = "position";
		}

/*=================================CHÈN NỘI DUNG FORM VÀO CSDL=======================================*/
		if(empty($errors)) { //Nếu không có lỗi xảy ra thì chèn vào CSDL
			if(isset($ecid)) {
				//Cập nhật
				$q = "UPDATE n_categories ";
				$q .= " SET cat_name = '{$n_cat_name}', position = $position ";
				$q .= " WHERE cat_id = {$ecid}";
				$r = mysqli_query($dbc, $q);
					confirm_query($r, $q);
				if (mysqli_affected_rows($dbc) == 1) {
					$messages = "<p class='notice'>Chỉnh sửa danh mục thành công.</p>";
				} else {
					$messages = "<p class='notice'>Không thể sửa danh mục do lỗi hệ thống.</p>";
				}

			} else {//Thêm mới
				$q = "INSERT INTO n_categories (user_id, cat_name, position) ";
				$q .= " VALUES (1, '{$n_cat_name}', $position)";
				$r = mysqli_query($dbc, $q);
					confirm_query($r, $q);
				if (mysqli_affected_rows($dbc) == 1) {
					$messages = "<p class='notice'>Thêm mới danh mục thành công.</p>";
				} else {
					$messages = "<p class='notice'>Không thể thêm danh mục vào CSDL do lỗi hệ thống.</p>";
				}
			}
		} else {
					$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
				}
	} //end if submit form
?>

<!--+++++++++++++++++++++++++++++ FORM HIỂN THI THÔNG BÁO LỖI ++++++++++++++++++++++++++++-->

<div id="main-content">
	<div class="title-content">
		<p>Thêm mới, chỉnh sửa thông tin danh mục bài viết</p>
	</div>
	<?php
		if (!empty($messages)) echo $messages;
	?>
	<div>
		<form action="" method="POST" id="add-n-cat" class="add-form">
			<fieldset>
				<legend>Thêm mới, chỉnh sửa thông tin danh mục bài viết</legend>
				<label for="n-category">Tên danh mục: <span class="required">*</span>
					<?php
						if(isset($errors) && in_array('category', $errors)) {
							echo "<p class='warning'>Điền tên danh mục.</p>";
						}
					?>
				</label>
				<input type="text" name="n-category" id="n-category" value="<?php if(isset($_POST['n-category'])) {echo strip_tags($_POST['n-category']);} elseif(isset($ecat_name)) {echo $ecat_name;} ?>" size="20" maxlength="100" tabindex="1" />
				<label for="position">Vị trí: <span class="required">*</span>
					<?php
						if(isset($errors) && in_array('position', $errors)) {
							echo "<p class='warning'>Chọn vị trí danh mục.</p>";
						}
					?>
				</label>
				<select name="position" tabindex="2">
					<!--================ Lấy dữ liệu trong CSDL để hiển thị ==================-->
					<?php
						$q = "SELECT count(cat_id) AS count FROM n_categories";
						$r = mysqli_query($dbc, $q);
							confirm_query($r, $q);
						if(mysqli_num_rows($r) == 1) {
							list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
							for ($i=1; $i <= $num+1; $i++) {//Tạo vòng for để tạo ra option, cộng thêm một giá trị cho position
								echo "<option value='{$i}'";
									if(isset($_POST['position']) && $_POST['position'] == $i) {
										echo "selected='selected'";
									} elseif(isset($eposition) && $eposition == $i) {
										echo "selected='selected'";
									}
								echo ">".$i."</option>";
							}
						}
					?>
				</select>
				<p><input type="submit" name="submit" value="Cập nhật" /></p>
			</fieldset>
		</form>
	</div>

<!--+++++++++++++++++++++++++++++ HIỂN THỊ DANH MỤC BÀI VIẾT ++++++++++++++++++++++++++++-->

	<div class="title-content">
		<p>Danh mục bài viết</p>
	</div>
	<table>
    	<thead>
    		<tr>
    			<th><a href="add-n-categories.php?sort=cat">Tên danh mục</a></th>
    			<th><a href="add-n-categories.php?sort=pos">Vị trí</th>
    			<th><a href="add-n-categories.php?sort=by">Người tạo</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php
    		//Sắp xếp theo thứ tự của table head
    		if (isset($_GET['sort'])) {
    			switch ($_GET['sort']) {
    				case 'cat':
    					$order_by = 'cat_name';
    					break;
    				case 'pos':
    					$order_by = 'position';
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
    		//Truy xuất CSDL để hiển thị categories
    		$q = "SELECT c.cat_id, c.cat_name, c.position, c.user_id, CONCAT_WS(' ', first_name, last_name) AS name ";
    		$q .= " FROM n_categories AS c ";
    		$q .= " JOIN users AS u USING(user_id) ";
    		$q .= " ORDER BY {$order_by} ASC";
    		$r = mysqli_query($dbc, $q);
    			confirm_query($r, $q);
    		while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) :
    	?>
            <tr>
                <td><?php echo $cats['cat_name']; ?></td>
                <td><?php echo $cats['position']; ?></td>
                <td><?php echo $cats['name']; ?></td>
                <td class='edit'><a href="add-n-categories.php?ecid=<?php echo $cats['cat_id']; ?>"><img src="../images/b_edit.png" alt="edit"></a></td>
                <td class='delete'><a href="add-n-categories.php?dcid=<?php echo $cats['cat_id']; ?>"><img src="../images/b_drop.png" alt="drop"></a></td>
            </tr>
        <?php endwhile; ?>
    	</tbody>
    </table>
</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>