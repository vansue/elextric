<?Php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = array();
		//Validate name
		if (!empty($_POST['name'])) {
			$name = mysqli_real_escape_string($dbc, strip_tags($_POST['name']));
		} else {
			$errors[] = "name";
		}

		//Validate email
		if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$e = mysqli_real_escape_string($dbc, strip_tags($_POST['email']));
		} else {
			$errors[] = "email";
		}

		//Validate comment
		if (!empty($_POST['comment'])) {
			$comment = mysqli_real_escape_string($dbc, $_POST['comment']);
		} else {
			$errors[] = "comment";
		}

		//Validate captcha question
		if (isset($_POST['captcha']) && trim($_POST['captcha']) != $_SESSION['q']['answer']) {
			$errors[] = "wrong";
		}

		if (empty($errors)) {
			$q = "INSERT INTO comments (page_id, author, email, comment, comment_date) VALUES ({$pnid}, '{$name}', '{$e}', '{$comment}', NOW())";
			$r = mysqli_query($dbc, $q); confirm_query($r, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				//thành công
				$messages = "<p class='notice success'>Cảm ơn bạn đã bình luận.</p>";
				$_POST = array();
			} else {
				$messages = "<p class='notice'>Bình luận của bạn không thể đăng do lỗi hệ thống.</p>";
			}
		} else {
			$messages = "<p class='notice'>Điền đầy đủ các trường.</p>";
		}
	}
?>
<?php
	//Hiển thị comment từ CSDL
	$q = "SELECT comment_id, author, comment, DATE_FORMAT(comment_date, '%b %d, %y') AS date FROM comments WHERE page_id = {$pnid}";
	$r = mysqli_query($dbc, $q); confirm_query($r, $q);
	if (mysqli_num_rows($r)>0) {
		//Nếu có comment hiển thi ra trình duyệt
		echo "<ol id='disscuss'>";
		while(list($comment_id, $author, $comment, $date) = mysqli_fetch_array($r, MYSQLI_NUM)) {
			echo "<li class='comment-wrap'>
				<p class='author'>{$author}</p>
				<p class='comment-sec'>{$comment}</p>";
				if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == 2)) {
					echo "<a id='{$comment_id}' class='remove'>Delete</a>";
				}
				echo "<p class='date'>{$date}</p></li>";
		}
		echo "</ol>";
	} else {
		//Nếu không có comment, thì sẽ báo ra trình duyệt
		$notice = "<p class='notice success'>Hãy là người đầu tiên bình luận cho bài viết này</p>";
	}
?>

<div>
<form id="comment-form" action="" method="post" class="add-form">
	<fieldset>
		<legend>Bình luận</legend>
			<?php if(!empty($notice)) echo $notice; ?>
			<?php if(!empty($messages)) echo $messages; ?>
		<div>
			<label for="name">Tên: <span class="required">*</span>
			<?php if(isset($errors) && in_array('name', $errors)) echo "<p class='notice'>Điền tên của bạn.</p>"; ?>
			</label>
			<input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8'); ?>" size="20" maxlength="80" tabindex="1" />
		</div>
		<div>
			<label for="email">Email: <span class="required">*</span>
			<?php if(isset($errors) && in_array('email', $errors)) echo "<p class='notice'>Điền email của bạn.</p>"; ?>
			</label>
			<input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" size="20" maxlength="80" tabindex="2" />
		</div>
		<div>
			<label for="comment">Bình luận: <span class="required">*</span>
			<?php if(isset($errors) && in_array('comment', $errors)) echo "<p class='notice'> Viết bình luận của bạn.</p>"; ?>
			</label>
			<div id="comment"><textarea name="comment" rows="20" cols="50" tabindex="3"><?php if(isset($_POST['comment'])) echo htmlentities($_POST['comment']); ?></textarea></div>
		</div>
		<div>
			<label>Trả lời câu hỏi: <?php echo captcha(); ?> <span class="required">*</span>
			<?php if(isset($errors) && in_array('wrong', $errors)) echo "<p class='notice'>Trả lời câu hỏi.</p>"; ?>
			</label>
			<input type="text" name="captcha" id="captcha" value="" size="20" maxlength="5" tabindex="4" />
		</div>
		<div><input type="submit" name="submit" value="Đăng bình luận" /></div>
	</fieldset>

</form>
</div>