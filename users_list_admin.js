window.onload = function() {
  users_list_admin();
};


function users_list_admin()
{	
	var myData = ""; //post variables	
	$.ajax({
		//document.write("hello");
		//type: "POST",
		url: "users_list_admin.php",
		data: myData,
		success:function(data){	
			var htmlList = "<ul><li><b> User email</b> </li>";
			var count;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_users');	
				if (count > 0 ) {
					var email = $(this).attr('user_email');
					var id = $(this).attr('user_id');
					htmlList = htmlList.concat("<li>"+email+"</li>");
				}
				else {
					count = 0;

				}
				
			});
			htmlList = htmlList.concat("</ul>");
			$('#list_users_admin').html(htmlList);
			setTimeout(users_list_admin, 2000);
		}
	});
}

