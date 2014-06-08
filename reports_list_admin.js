window.onload = function() {
  reports_opened_list_admin();
  reports_closed_list_admin();
};

$(function() {
    reports_opened_list_admin();
    reports_closed_list_admin();
});

function reports_opened_list_admin()
{	
	var myData = {list : 'unsolved'}; //post variables	
	$.ajax({
		type: "POST",
		url: "map_process_admin.php",
		data: myData,
		success:function(data){	
			var htmlList = "";
			var count;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_reports');	
				if (count > 0 ) {
					var category = $(this).attr('category');
					htmlList = htmlList.concat("<ul>"+"<li><p>Κατηγορία: "+category+'</p>');
					var description = '<p>'+ $(this).attr('description') +'</p>';
					htmlList = htmlList.concat("<p>Περιγραφή: "+description+'</p>');
					var date = $(this).attr('datetime');
					htmlList = htmlList.concat("<p>Ημερομηνία: "+date+"</p></li>"+"</ul>");
				}
				else count = 0;
			});
			var htmlReportsNum = "Οι συνολικές ανοικτές αναφορές στο σύστημα ειναι: "+count;
			$('#num_of_reports_admin').html(htmlReportsNum);
			$('#list_reports_admin').html(htmlList);
			setTimeout(reports_opened_list_admin, 2000);
		}
	});
}

function reports_closed_list_admin()
{	
	var myData = {list : 'solved'}; //post variables	
	$.ajax({
		type: "POST",
		url: "map_process_admin.php",
		data: myData,
		success:function(data){	
			var htmlList = "";
			var count;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_reports');	
				if (count > 0 ) {
					var category = $(this).attr('category');
					htmlList = htmlList.concat("<ul>"+"<li><p>Κατηγορία: "+category+'</p>');
					var description = '<p>'+ $(this).attr('description') +'</p>';
					htmlList = htmlList.concat("<p>Περιγραφή: "+description+'</p>');
					var date = $(this).attr('datetime');
					htmlList = htmlList.concat("<p>Ημερομηνία: "+date+"</p></li>"+"</ul>");
				}
				else count = 0;
			});
			var htmlReportsNum = "Οι συνολικές κλειστές αναφορές στο σύστημα ειναι: "+count;
			$('#num_of_solved_reports_admin').html(htmlReportsNum);
			$('#list_solved_reports_admin').html(htmlList);
			setTimeout(reports_closed_list_admin, 2000);
		}
	});
}
