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
		<div class="under_con_image">
            		<img src="images/under-construction.png"/></img>
        </div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
