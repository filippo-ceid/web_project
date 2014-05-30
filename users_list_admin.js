window.onload = function() {
  users_list_admin();
};

$(function() {
    users_list_admin();
});


function users_list_admin()
{	
	$.ajax({
		url: "users_list_admin.php",
		data: "",
		success:function(data){	
			var htmlList = "<ul>User email<br> ";
			var count;
			$(data).find("account").each(function () {
				count= $(this).attr('num_of_users');	
				if (count > 0 ) {
					var email = $(this).attr('user_email');
					var id = $(this).attr('user_id');
					htmlList = htmlList.concat(email+'<br>');
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

