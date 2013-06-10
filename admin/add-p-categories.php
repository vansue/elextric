<?php
	include('header.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
		//Kiểm tra các trường của form
		$errors = array();//Biến bắt lỗi
		if (empty($_POST['category'])) {
			$errors[] = "category";
		} else {
			$n_cat_name = mysqli_real_escape_string($dbc, strip_tags($_POST['p-category']));
		}

		if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
			$position = $_POST['position'];
		} else {
			$errors[] = "position";
		}

		if(empty($errors)) { //Nếu không có lỗi xảy ra thì chèn vào CSDL
			$q = "INSERT INTO n_categories (user_id, cat_name, position) ";
			$q .= " VALUES (1, '{$n_cat_name}', $position)";
			$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
			if (mysqli_affected_rows($dbc) == 1) {
				$messages = "<p class='notice'>Thêm mới danh mục thành công.</p>";
			} else {
				$messages = "<p class='notice'>Không thể thêm danh mục vào CSDL do lỗi hệ thống.</p>";
			}
		} else {
			$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
		}
	} //end if submit form
?>
<div id="main-content">
	<div class="title-content">
		<p>Thêm mới danh mục sản phẩm</p>
	</div>
	<?php
		if (!empty($messages)) echo $messages;
	?>
	<div class="add-form">
		<form action="" method="post" id="add-n-cat">
			<fieldset>
				<legend>Thêm mới danh mục sản phẩm</legend>
				<label for="p-category">Tên danh mục: <span class="required">*</span>
					<?php
						if(isset($errors) && in_array('category', $errors)) {
							echo "<p class='warning'>Điền tên danh mục.</p>";
						}
					?>
				</label>
				<input type="text" name="p-category" id="p-category" value="<?php if(isset($_POST['category'])) echo strip_tags($_POST['category']) ?>" size="20" maxlength="100" tabindex="1" />
				<label for="position">Vị trí: <span class="required">*</span>
					<?php
						if(isset($errors) && in_array('position', $errors)) {
							echo "<p class='warning'>Chọn vị trí danh mục.</p>";
						}
					?>
				</label>
				<select name="position" tabindex="2">
					<?php
						$q = "SELECT count(cat_id) AS count FROM n_categories";
						$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
						if(mysqli_num_rows($r) == 1) {
							list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
							for ($i=1; $i <= $num+1; $i++) {//Tạo vòng for để tạo ra option, cộng thêm một giá trị cho position
								echo "<option value='{$i}'";
									if(isset($_POST['position']) && $_POST['position'] == $i) echo "selected='selected'";
								echo ">".$i."</option>";
							}
						}
					?>
				</select>
				<p><input type="submit" name="submit" value="Thêm danh mục" /></p>
			</fieldset>
		</form>
	</div>

	<div class="title-content">
		<p>Danh mục sản phẩm</p>
	</div>
	<table>
    	<thead>
    		<tr>
    			<th><a href="">Tên danh mục</a></th>
    			<th><a href="">Vị trí</th>
    			<th><a href="">Người đăng</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class='edit'><a href=''><img src="../images/b_edit.png" alt="edit"></a></td>
                <td class='delete'><a href=''><img src="../images/b_drop.png" alt="drop"></a></td>
            </tr>
    	</tbody>
    </table>
</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>