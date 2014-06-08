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
			var htmlList = "<ul>";
			var count;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_reports');	
				if (count > 0 ) {
					var category = $(this).attr('category');
					htmlList = htmlList.concat("<li><p>Κατηγορία: "+category+'</p>');
					var description = '<p>'+ $(this).attr('description') +'</p>';
					htmlList = htmlList.concat("<p>Περιγραφή: "+description+'</p>');
					var status = $(this).attr('report_status');
					htmlList = htmlList.concat("<p>Κατάσταση: "+status+'</p>');
					var comment = $(this).attr('report_comment');
					if (comment != "" ) {
						htmlList = htmlList.concat("<p>Σχόλιο Διαχειριστή: "+comment+'</p>');
					}
					var date = $(this).attr('datetime');
					htmlList = htmlList.concat("<p>Ημερομηνία Καταχώρησης: "+date+"</p>");
					htmlList = htmlList.concat("<p>___________________</p><br></li>"); //fix it
				}
				else count = 0;
			});
			htmlList = htmlList.concat("</ul>");
			var htmlReportsNum = "Οι συνολικές αναφορές σας στο σύστημα ειναι: "+count;
			$('#num_of_reports').html(htmlReportsNum);
			$('#my_reports_list').html(htmlList);
			setTimeout(my_reports_list, 2000);
		}
	});
}
