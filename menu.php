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
				if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "admin")) {
					if ($tab==2) {
						echo '<a href="reports.php" class="current">Αναφορές</a>';
					}
					else {
						echo '<a href="reports.php">Αναφορές</a>';
					}
				}
				else if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "simple")) {
					if ($tab==2) {
						echo '<a href="my_reports.php" class="current">Οι Αναφορές Μου</a>';
					}
					else {
						echo '<a href="my_reports.php">Οι Αναφορές Μου</a>';
					}
				}
				else {
					if ($tab==2) {
						echo '<a href="login.php" class="current">Είσοδος</a>';
					}
					else {
						echo '<a href="login.php">Είσοδος</a>';
					}
				}
			?>
		</li>
		<li>
			<?php 
				if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "admin")) {
					if ($tab==3) {
						echo '<a href="users.php" class="current">Λογαριασμοί Χρηστών</a>';
					}
					else {
						echo '<a href="users.php">Λογαριασμοί Χρηστών</a>';
					}
				}
				else if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "simple")) {
					if ($tab==3) {
						echo '<a href="account.php" class="current">Διαχείριση Λογαριασμού</a>';
					}
					else {
						echo '<a href="account.php">Διαχείριση Λογαριασμού</a>';
					}
				}
				else {
					if ($tab==3) {
						echo '<a href="registration.php" class="current">Εγγραφή</a>';
					}
					else {
						echo '<a href="registration.php">Εγγραφή</a>';
					}
				}
			?>
		</li>
		<li>
			<?php
				if (isset($_SESSION['user_level']) && ($_SESSION['user_level'] == "admin")) {
					if ($tab==4) {
						echo '<a href="db_manage.php" class="current">Διαχείριση Βάσης</a>';
					}
					else {
						echo '<a href="db_manage.php">Διαχείριση Βάσης</a>';
					}
				}
				else {
					if ($tab==4) {
						echo '<a href="contact.php" class="current">Επικοινωνία</a>';
					}
					else {
						echo '<a href="contact.php">Επικοινωνία</a>';
					}
				}
			?>
		</li>
		<li>
			<?php 
				if (isset($_SESSION['email'])) {
					if ($tab==5) {
						echo '<a href="logout.php" class="current">Έξοδος</a>';
					}
					else {
						echo '<a href="logout.php">Έξοδος</a>';
					}
				}
			?>
		</li>
	</ul>  
</div> <!-- end of menu -->
