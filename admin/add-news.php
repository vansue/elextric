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
			$category = $_POST['n-category'];
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
					<label for="page">Page name: <span class="required">*</span></label>
					<input type="text" name="page-name" id="page-name" value="" size="20" maxlength="100" tabindex="1" />
				</div>

				<div>
					<label for="n-category">All categories: <span class="required">*</span></label>
					<select name="n-category">
						<option>Select Category</option>
					</select>
				</div>

				<div>
					<label for="position">Position: <span class="required">*</span></label>
					<select name="position">
						<option>Select position</option>
					</select>
				</div>

				<div>
					<label for="page-content">Page Content: <span class="required">*</span></label>
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