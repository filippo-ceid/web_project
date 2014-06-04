window.onload = function() {
  my_reports_list();
};

$(function() {
    my_reports_list();
});

function my_reports_list()
{	
	$.ajax({
		url: "map_process.php",
		data: "",
		success:function(data){	
			var htmlList = "";
			var count;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_reports');	
				if (count > 0 ) {
					var category = $(this).attr('category');
					htmlList = htmlList.concat("<ul>"+"<li>Κατηγορία: "+category);
					var description = '<p>'+ $(this).attr('description') +'</p>';
					htmlList = htmlList.concat("Περιγραφή: "+description);
					var date = $(this).attr('datetime');
					htmlList = htmlList.concat(" Ημερομηνία: "+date+"</li>"+"</ul>");
				}
			});
			var htmlReportsNum = "Οι συνολικές αναφορές σας στο σύστημα ειναι: "+count;
			$('#num_of_reports').html(htmlReportsNum);
			$('#list_reports').html(htmlList);
			setTimeout(my_reports_list, 2000);
		}
	});
}
