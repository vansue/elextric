<?php $title = "Liên hệ"; include('inc/header.php'); ?>
<?php include('inc/first-sidebar.php'); ?>
<div id="main-content">
	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = array();

		if (empty($_POST['name'])) {
			$errors[] = 'name';
		}

		if (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) {
			$errors[] = 'email';
		}

		if (empty($_POST['comment'])) {
			$errors[] = 'comment';
		}

		//Validate captcha question
		if (isset($_POST['captcha']) && trim($_POST['captcha']) != $_SESSION['q']['answer']) {
			$errors[] = "wrong";
		}

		if (empty($errors)) {
			// Khai báo thư viện phpmailer
			require "lib/class.phpmailer.php";

			// Khai báo tạo PHPMailer
			$mail = new PHPMailer();
			//Khai báo gửi mail bằng SMTP
			$mail->IsSMTP();
			//Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
			// 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
			// 1 = Thông báo lỗi ở client
			// 2 = Thông báo lỗi cả client và lỗi ở server
			$mail->SMTPDebug  = 0;

			$mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
			$mail->Host       = "smtp.gmail.com"; //host smtp để gửi mail
			$mail->Port       = 587; // cổng để gửi mail
			$mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
			$mail->SMTPAuth   = true; //Xác thực SMTP
			$mail->Username   = "trongnghiahp85@gmail.com"; // Tên đăng nhập tài khoản Gmail
			$mail->Password   = "huong@83279"; //Mật khẩu của gmail
			$mail->SetFrom("localhost@localhost", $_POST['name']); // Thông tin người gửi
			$mail->AddReplyTo($_POST['email'],"Trả lời");// Ấn định email sẽ nhận khi người dùng reply lại.
			$mail->AddAddress("trongnghiahp85@gmail.com", "Trọng Nghĩa");//Email của người nhận
			$mail->Subject = "Lời nhắn của ".$_POST['name']; //Tiêu đề của thư
			$mail->CharSet = "utf-8";
			$mail->MsgHTML(wordwrap(strip_tags($_POST['comment']))); //Nội dung của bức thư.
			// $mail->MsgHTML(file_get_contents("email-template.html"), dirname(__FILE__));
			// Gửi thư với tập tin html
			$mail->AltBody = "This is a plain-text message body";//Nội dung rút gọn hiển thị bên ngoài thư mục thư.
			//$mail->AddAttachment("images/attact-tui.gif");//Tập tin cần attach

			//Tiến hành gửi email và kiểm tra lỗi
			if(!$mail->Send()) {
			  	$mesage = "<p class='notice'>Có lỗi khi gửi mail: " . $mail->ErrorInfo."</p>";
			} else {
			  	$mesage = "<p class='notice success'>Lời nhắn của bạn đã được gửi thành công.</p>";
			  	$_POST = array();
			}
		} else {
			$mesage = "<p class='notice'>Điền đầy đủ các trường.</p>";
		}
	}

	?>
	<div class="title-content">
		<p>Liên hệ</p>
	</div>

	<div>
		<?php if(!empty($mesage)) echo $mesage; ?>
		<form action="" method="POST" id="add-n-cat" class="add-form">
			<fieldset>
				<legend>Liên hệ</legend>
				<label for="name">Tên: <span class="required">*</span>
					<?php
						if(isset($errors) && in_array('name', $errors)) {
							echo "<p class='notice'>Điền tên của bạn.</p>";
						}
					?>
				</label>
				<input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8'); ?>" size="20" maxlength="40" tabindex="1" />

				<label for="email">Email: <span class="required">*</span>
					<?php
						if(isset($errors) && in_array('email', $errors)) {
							echo "<p class='notice'>Điền email hợp lệ.</p>";
						}
					?>
				</label>
				<input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8'); ?>" size="60" maxlength="40" tabindex="3" />

				<label for='comment'>Lời nhắn của bạn: <span class="required">*</span>
					<?php
					if (isset($errors) && in_array('comment', $errors)) {
						echo "<p class='notice'>Viết lời nhắn của bạn.</p>";
					}
					?>
				</label>
				<textarea cols="50" rows="20" name="comment"><?php if(isset($_POST['comment'])) echo htmlentities($_POST['comment'], ENT_COMPAT, 'UTF-8'); ?></textarea>

				<div>
					<label>Trả lời câu hỏi: <?php echo captcha(); ?> <span class="required">*</span>
					<?php if(isset($errors) && in_array('wrong', $errors)) echo "<p class='notice'>Trả lời câu hỏi.</p>"; ?>
					</label>
					<input type="text" name="captcha" id="captcha" value="" size="20" maxlength="5" tabindex="4" />
				</div>

				<p><input type="submit" name="submit" value="Gửi lời nhắn" /></p>
			</fieldset>
		</form>
	</div>
</div><!--end #main-content-->
<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>