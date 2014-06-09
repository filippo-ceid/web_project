<?php
	include 'header.html';
	$tab=2;
	require  "menu.php";
	check_simple_permissions($user_id);
	require "processupload.php";
?>   
    <div id="top_panel">
		
		<form action="uploadphotos.php" method="POST" enctype="multipart/form-data" id="UploadForm">
			<div id="upload">
			<table>
			  <tr>
				<td>Εικόνα 1 : </td>
				<td><input name="ImageFile1" type="file" /></td>
			  </tr>
			  <tr>
				<td>Εικόνα 2 : </td>
				<td><input name="ImageFile2" type="file" /></td>
			  </tr>
			  <tr>
				<td>Εικόνα 3 : </td>
				<td><input name="ImageFile3" type="file" /></td>
			  </tr>
			  <tr>
				<td>Εικόνα 4 : </td>
				<td><input name="ImageFile4" type="file" /></td>
			  </tr>
			  <tr>
				<td></td>
				<td><input type="submit"  name="submit" value="Upload" /><input type="submit"  name="cancel" value="No,thanks" /></td>
			  </tr>
			</table>
		</form>
		</div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
