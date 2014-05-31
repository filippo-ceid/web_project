<?php
    // Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	include 'header.html';
	$tab=2;
	require  "menu.php";
?>   
    <div id="top_panel">
		<?php require "processupload.php";?>
		<form action="uploadphotos.php" method="POST" enctype="multipart/form-data" id="UploadForm">
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
				<td>&nbsp;</td>
				<td><input type="submit"  name="submit" value="Upload" /></td>
			  </tr>
			</table>
		</form>
		
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
