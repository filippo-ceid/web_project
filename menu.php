<?php 
if (!isset($user_id)){
	exit();
}
?>

<!-- αναλαμβάνει να εμφανίσει το μενού αναλόγως του user level του χρήστη -->

<div id="menu">
	<ul>
		<li>
			<?php 
				if ($tab==1) {
					echo '<a href="index.php" class="current">Αρχική</a>';
				}
				else {
					echo '<a href="index.php">Αρχική</a>';
				}
			?>
		</li>
		<li>
			<?php 
				//μενου διαχειριστή για τη 2η επιλογη 
				if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "admin")) {
					if ($tab==2) {
						echo '<a href="reports_page.php" class="current">Ανοιχτές Αναφορές</a>';
					}
					else {
						echo '<a href="reports_page.php">Ανοιχτές Αναφορές</a>';
					}
				}
				//μενου χρήστη για τη 2η επιλογη 
				else if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "simple")) {
					if ($tab==2) {
						echo '<a href="my_reports_page.php" class="current">Οι Αναφορές Μου</a>';
					}
					else {
						echo '<a href="my_reports_page.php">Οι Αναφορές Μου</a>';
					}
				}
				//μενου επισκέπτη για τη 2η επιλογη 
				else {
					if ($tab==2) {
						echo '<a href="login_page.php" class="current">Είσοδος</a>';
					}
					else {
						echo '<a href="login_page.php">Είσοδος</a>';
					}
				}
			?>
		</li>
		<li>
			<?php
				if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "admin")) {
					if ($tab==3) {
						echo '<a href="accounts_page.php" class="current">Διαχείριση Λογαριασμών</a>';
					}
					else {
						echo '<a href="accounts_page.php">Διαχείριση Λογαριασμών</a>';
					}
				}
				else if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "simple")) {
					if ($tab==3) {
						echo '<a href="my_account_page.php" class="current">Διαχείριση Λογαριασμού</a>';
					}
					else {
						echo '<a href="my_account_page.php">Διαχείριση Λογαριασμού</a>';
					}
				}
				else {
					if ($tab==3) {
						echo '<a href="registration_page.php" class="current">Εγγραφή</a>';
					}
					else {
						echo '<a href="registration_page.php">Εγγραφή</a>';
					}
				}
			?>
		</li>
		<li>
			<?php 
				if (isset($_SESSION['user_level']) && (($_SESSION['user_level'] == "admin")||($_SESSION['user_level'] == "simple"))) {
					if ($tab==4) {
						echo '<a href="logout.php" class="current">Έξοδος</a>';
					}
					else {
						echo '<a href="logout.php">Έξοδος</a>';
					}
				}
				else {
						echo '';
				}
			?>
		</li>
	</ul>  
</div> <!-- end of menu -->
