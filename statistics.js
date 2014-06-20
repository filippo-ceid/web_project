window.onload = function() {
  statistics();
};

$(function() {
    statistics();
});

function statistics()
{	
	stats = new Array();
	$.ajax({
		url: "statistics.php",
		data: "",
		success:function(data){
				stats = data.split('|');
				$('#statistics').html("<ul>"+
						"<li>Συνολικός αριθμός αναφορών: "+stats[0]+"</li>"+
						"<li>Συνολικός αριθμός ανοιχτών αναφορών: "+stats[1]+"</li>"+
						"<li>Συνολικός αριθμός επιλυμένων αναφορών: "+stats[2]+"</li>"+
						"<li>Μέσος χρόνος επίλυσης αναφορών:<br>"+stats[3]+"</li>"+
					"</ul>");
				setTimeout(statistics, 60000);
		}
	});
}
