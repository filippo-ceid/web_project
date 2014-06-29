<?php
	include 'header.html';
	$tab=2;
	require  "menu.php";
	check_simple_permissions($user_id);
	require "processupload.php";
?>  
	<script type="text/javascript">
		function PreviewImage(i) {
			var oFReader = new FileReader();
			imgId = 'uploadImage';
			imgId = imgId.concat(i);
			prevId = 'uploadPreview';
			prevId = prevId.concat(i);
			oFReader.readAsDataURL(document.getElementById(imgId).files[0]);
			oFReader.onload = function (oFREvent) {document.getElementById(prevId).src = oFREvent.target.result;};
		};
	</script>
    <div id="top_panel">
		<div class="reg_report"><?php echo $report; ?></div><br>
		<div id="upload_field">
			<form action="uploadphotos.php" method="POST" enctype="multipart/form-data" id="UploadForm">
				<table>
					<tr>
						<td>Εικόνα 1 : </td>
						<td><input id="uploadImage1" name="ImageFile1" type="file" onchange="PreviewImage(1);"/></td>
						<td><img id="uploadPreview1" class="photo_thump"/></td>
					</tr>
					<tr>
						<td>Εικόνα 2 : </td>
						<td><input id="uploadImage2" name="ImageFile2" type="file" onchange="PreviewImage(2);"/></td>
						<td><img id="uploadPreview2" class="photo_thump"/></td>
					</tr>
					<tr>
						<td>Εικόνα 3 : </td>
						<td><input id="uploadImage3" name="ImageFile3" type="file" onchange="PreviewImage(3);"/></td>
						<td><img id="uploadPreview3" class="photo_thump"/></td>
					</tr>
					<tr>
						<td>Εικόνα 4 : </td>
						<td><input id="uploadImage4" name="ImageFile4" type="file" onchange="PreviewImage(4);"/></td>
						<td><img id="uploadPreview4" class="photo_thump"/></td>
					</tr>
				</table>
				<input type="submit"  name="submit" value="Upload" /><input type="submit"  name="cancel" value="No,thanks" />
			</form>
		</div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
