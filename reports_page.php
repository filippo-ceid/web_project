<?php
	include 'header.html';
	$tab=2;
	require  "menu.php";
	require "check_permissions.php";
	check_admin_permissions($user_level);
?>   
    <div id="top_panel">
		<div class="under_con_image">
            		<img src="images/under-construction.png"/></img>
        </div>
    </div> <!-- end of top panel -->
<?php
	include 'footer.html';
?>
