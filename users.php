<?php
    // Start output buffering:
	ob_start();
	// Initialize a session:
	session_start();
	include 'header.html';
	require "processupload.php";
	$tab=3;
	require  "menu.php";
?>   
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.form.js"></script>
	<script>
		$(document).ready(function() {
			var progressbox     = $('#progressbox');
			var progressbar     = $('#progressbar');
			var statustxt       = $('#statustxt');
			var submitbutton    = $("#SubmitButton");
			var myform          = $("#UploadForm");
			var output          = $("#output");
			var completed       = '0%';
			 
			$(myform).ajaxForm({
				beforeSend: function() { //brfore sending form
					submitbutton.attr('disabled', ''); // disable upload button
					statustxt.empty();
					progressbox.slideDown(); //show progressbar
					progressbar.width(completed); //initial value 0% of progressbar
					statustxt.html(completed); //set status text
					statustxt.css('color','#000'); //initial color of status text
				},
				uploadProgress: function(event, position, total, percentComplete) { //on progress
					progressbar.width(percentComplete + '%') //update progressbar percent complete
					statustxt.html(percentComplete + '%'); //update status text
					if(percentComplete>50)
					{
					statustxt.css('color','#fff'); //change status text to white after 50%
					}
				},
				complete: function(response) { // on complete
					output.html(response.responseText); //update element with received data
					myform.resetForm();  // reset form
					submitbutton.removeAttr('disabled'); //enable submit button
					progressbox.slideUp(); // hide progressbar
				}
		});
	</script>
	<style>
		#progressbox {
		border: 1px solid #0099CC;
		padding: 1px;
		position:relative;
		width:400px;
		border-radius: 3px;
		margin: 10px;
		display:none;
		text-align:left;
		}
		#progressbar {
		height:20px;
		border-radius: 3px;
		background-color: #003333;
		width:1%;
		}
		#statustxt {
		top:3px;
		left:50%;
		position:absolute;
		display:inline-block;
		color: #000000;
		}
	</style>
    <div id="top_panel">
		<form action="users.php" method="POST" enctype="multipart/form-data" id="UploadForm">
			<table>
			  <tr>
				<td>Εικόνα 1 : </td>
				<td><input name="ImageFile" type="file" /></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><input type="submit"  name="submit" value="Upload" /></td>
			  </tr>
			</table>
		</form>
		<div id="progressbox">
			<div id="progressbar"></div >
			<div id="statustxt">0%</div >
		</div>
		<div id="output"></div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
