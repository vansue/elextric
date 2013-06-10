<?php
	include('header.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
		//Kiểm tra các trường của form
		$errors = array();//Biến bắt lỗi
		if(empty($_POST['page-name'])) {
			$errors[] = "page-name";
		} else {
			$page_name = mysqli_real_escape_string($dbc, strip_tags($_POST['page-name']));
		}

		if(isset($_POST['n-category']) && filter_var($_POST['n-category'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
			$cat_id = $_POST['n-category'];
		} else {
			$errors[] = "category";
		}


		if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
			$position = $_POST['position'];
		} else {
			$errors[] = "position";
		}

		if(empty($_POST['content'])) {
			$errors[] = "content";
		} else {
			$content = mysqli_real_escape_string($dbc, $_POST['content']);
		}

		if(empty($errors)) { //Nếu không có lỗi xảy ra thì chèn vào CSDL
			$q = "INSERT INTO pages (user_id, cat_id, page_name, content, position, post_on) ";
			$q .= " VALUES (1, $cat_id, '{$page_name}', '{$content}', $position, now())";
			$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
			if (mysqli_affected_rows($dbc) == 1) {
				$messages = "<p class='notice'>Thêm mới bai viet thành công.</p>";
			} else {
				$messages = "<p class='notice'>Không thể thêm bai viet vào CSDL do lỗi hệ thống.</p>";
			}
		} else {
			$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
		}
	} //end if submit form
?>
<div id="main-content">
	<div class="title-content">
		<p>Thêm mới danh mục bài viết</p>
	</div>
	<?php
		if (!empty($messages)) echo $messages;
	?>
	<div>
		<form id="add-news" action="" method="post" class="add-form">
			<fieldset>
				<legend>Add a Page</legend>
				<div>
					<label for="page">Page name: <span class="required">*</span>
						<?php
						if(isset($errors) && in_array('page-name', $errors)) {
							echo "<p class='warning'>Điền tên bai viet.</p>";
						}
					?>
					</label>
					<input type="text" name="page-name" id="page-name" value="<?php if (isset($_POST['page-name'])) {
						echo strip_tags($_POST['page-name']);
					} ?>" size="20" maxlength="100" tabindex="1" />
				</div>

				<div>
					<label for="n-category">All categories: <span class="required">*</span>
						<?php
						if(isset($errors) && in_array('category', $errors)) {
							echo "<p class='warning'>Chon danh mục.</p>";
						}
					?>
					</label>
					<select name="n-category">
						<option>Chon danh muc</option>
						<?php
							$q = "SELECT cat_id, cat_name FROM n_categories ORDER BY position ASC";
							$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
							if(mysqli_num_rows($r) >= 1) {
								while ($cats = mysqli_fetch_array($r, MYSQLI_NUM)) {
									echo "<option value='{$cats[0]}' ";
									if (isset($_POST['n-category']) && ($_POST['n-category'] == $cats[0])) {
										echo "selected = 'selected'";
									}
									echo ">".$cats[1]."</option>";
								}
							}
						?>
					</select>
				</div>

				<div>
					<label for="position">Position: <span class="required">*</span>
						<?php
						if(isset($errors) && in_array('position', $errors)) {
							echo "<p class='warning'>Chon vi tri bai viet.</p>";
						}
					?>
					</label>
					<select name="position">
						<?php
						$q = "SELECT count(page_id) AS count FROM pages";
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
				</div>

				<div>
					<label for="page-content">Page Content: <span class="required">*</span>
						<?php
						if(isset($errors) && in_array('content', $errors)) {
							echo "<p class='warning'>Nhap noi dung bai viet.</p>";
						}
					?>
					</label>
					<textarea name="content" cols="50" rows="20"></textarea>
				</div>

				<p><input type="submit" name="submit" value="Thêm mới bài viết" /></p>
			</fieldset>
		</form>
	</div>

	<div class="title-content">
		<p>Danh mục bài viết</p>
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