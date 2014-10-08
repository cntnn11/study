
$(function(){
	$(".table1,.table3").each(function(){
		$(this).find("tr:nth-child(even)").css({background:"rgb(220,220,220)"});
	});
			
	$(".table2").each(function(){
		$(this).find("th:nth-child(odd),td:nth-child(odd)").css({background:"rgb(220,220,220)"});
	});
})