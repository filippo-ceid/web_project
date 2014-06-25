<?php
	include 'header.html';
	$tab=2;
	require  "menu.php";
	check_simple_permissions($user_id);
	require "processupload.php";
?>  
	<script type="text/javascript" src="camera.js"></script>
    <div id="top_panel">
		<div class="reg_report"><?php echo $report; ?></div><br>
		<div id="upload">
			<table>
				<form action="uploadphotos.php" method="POST" enctype="multipart/form-data" id="UploadForm">
					<tr>
						<td>Εικόνα 1 : </td>
						<td><input id="uploadImage1" name="ImageFile1" type="file" onchange="PreviewImage(1);"/></td>
						<td><img id="uploadPreview1" style="height: 150px;" /></td>
					</tr>
					<tr>
						<td>Εικόνα 2 : </td>
						<td><input id="uploadImage2" name="ImageFile2" type="file" onchange="PreviewImage(2);"/></td>
						<td><img id="uploadPreview2" style="height: 150px;" /></td>
					</tr>
					<tr>
						<td>Εικόνα 3 : </td>
						<td><input id="uploadImage3" name="ImageFile3" type="file" onchange="PreviewImage(3);"/></td>
						<td><img id="uploadPreview3" style="height: 150px;" /></td>
					</tr>
					<tr>
						<td>Εικόνα 4 : </td>
						<td><input id="uploadImage4" name="ImageFile4" type="file" onchange="PreviewImage(4);"/></td>
						<td><img id="uploadPreview4" style="height: 150px;" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit"  name="submit" value="Upload" /><input type="submit"  name="cancel" value="No,thanks" /></td>
					</tr>
				</form>
			</table>
		</div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
