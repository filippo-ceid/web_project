var page;
var num_of_pages;

window.onload = function() {
  page = 1
  reports_opened_list_admin(page);
  reports_closed_list_admin(page);
};

function nextPage(status){
	if (status == 'unsolved'){
		num_of_opened_reports(function (num_of_pages){
			if (page < num_of_pages){
				page++;
				reports_opened_list_admin(page);
			}
		});
	}
	else if (status == 'solved'){
		num_of_closed_reports(function (num_of_pages){
			if (page < num_of_pages){
				page++;
				reports_closed_list_admin(page);
			}
		});
	}
}

function prevPage(status){
	if (page > 1){
		page--;
		if (status == 'unsolved')
			reports_opened_list_admin(page);
		else if (status == 'solved')
			reports_closed_list_admin(page);
	}
}

function reports_opened_list_admin(page_num)
{	
	var myData = {list : 'Ανοιχτή', page: page_num}; //post variables	
	$.ajax({
		type: "POST",
		url: "map_process_admin.php",
		data: myData,
		success:function(data){	
			var htmlList = "<ul>";
			var count;
			var i=0;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_reports');	
				if (count > 0 ) {
					var category = $(this).attr('category');
					htmlList = htmlList.concat('<li><a href="javascript:myclick('+page_num+','+i+')"><p>Κατηγορία: '+category+'</p>');
					var description = '<p>'+ $(this).attr('description') +'</p>';
					htmlList = htmlList.concat('<p>Περιγραφή: '+description+'</p>');
					var date = '<p>'+$(this).attr('datetime')+'</p>';
					htmlList = htmlList.concat("<p>Ημερομηνία: "+date+"</p>");
					var user_email = $(this).attr('user_email');
					htmlList = htmlList.concat("<p>Χρήστης: "+user_email+"</p></a>");
					htmlList = htmlList.concat("<p>__________________________</p><br></li>"); //fix it
					i++;
				}
				else count = 0;
			});
			htmlList = htmlList.concat("</ul>");
			var htmlReportsNum = "Οι συνολικές ανοιχτές αναφορές στο σύστημα ειναι: "+count;
			$('#num_of_reports_admin').html(htmlReportsNum);
			$('#list_unsolved_reports').html(htmlList);
		}
	});
}

function reports_closed_list_admin(page_num)
{	
	var myData = {list : 'Κλειστή', page: page_num}; //post variables	
	$.ajax({
		type: "POST",
		url: "map_process_admin.php",
		data: myData,
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
					var date = $(this).attr('datetime');
					htmlList = htmlList.concat("<p>Ημερομηνία : "+date+'</p>');
					var admin_email = $(this).attr('admin_email');
					htmlList = htmlList.concat("<p>Διαχειριστής: "+admin_email+"</p>");
					htmlList = htmlList.concat("<p>__________________________</p><br></li>"); //fix it
				}
				else count = 0;
			});
			htmlList = htmlList.concat("</ul>");
			var htmlReportsNum = "Οι συνολικές κλειστές αναφορές στο σύστημα ειναι: "+count;
			$('#num_of_solved_reports_admin').html(htmlReportsNum);
			$('#list_solved_reports').html(htmlList);
		}
	});
}

function num_of_closed_reports(callback)
{
	var num_of_pages;
	var myData = {list : 'Κλειστή', page: 0}; //post variables	
	$.ajax({
		type: "POST",
		url: "map_process_admin.php",
		data: myData,
		success:function(data){	
			var count;
			var page_num;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_reports');
			});
			page_num = count/20;
			num_of_pages=Math.ceil(page_num);
			callback(num_of_pages);
		}
	});
}

function num_of_opened_reports(callback)
{
	var num_of_pages;
	var myData = {list : 'Ανοιχτή', page: 0}; //post variables	
	$.ajax({
		type: "POST",
		url: "map_process_admin.php",
		data: myData,
		success:function(data){	
			var count;
			var page_num;
			$(data).find("report").each(function () {
				count= $(this).attr('num_of_reports');
			});
			page_num = count/20;
			num_of_pages=Math.ceil(page_num);
			callback(num_of_pages);
		}
	});
}
