<?php
	include('header.php');
	include('first-sidebar.php');
?>
<div id="main-content">
	<div class="title-content">
		<p>Them moi danh muc bai viet</p>
	</div>

	<div class="add-form">
		<form action="" method="post" accept-charset="utf-8" id="add-n-cat">
			<fieldset>
				<legend>Them moi danh muc bai viet</legend>
				<label for="category">Ten danh muc: <span class="required">*</span></label>
				<input type="text" name="n-category" id="n-category" value="" size="20" maxlength="100" tabindex="1" />
				<label for="position">Vi tri: <span class="required">*</span></label>
				<select name="n-cat-pos" tabindex="2">
					<option>Chon vi tri</option>
				</select>
			</fieldset>
		</form>
	</div>

	<div class="title-content">
		<p>Danh muc bai viet</p>
	</div>
	<table>
    	<thead>
    		<tr>
    			<th><a href="">Categories</a></th>
    			<th><a href="">Position</th>
    			<th><a href="">Posted by</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><a class='edit' href=''>Edit</a></td>
                <td><a class='delete' href=''>Delete</a></td>
            </tr>
    	</tbody>
    </table>
</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>