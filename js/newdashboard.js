$(function(){
	$("#datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		onSelect: function(date){

			$('#datepicker_value').val(date);
			getDashboardData(date);
			console.log(date);
		}
	});
	$("#datepicker").datepicker("setDate", $('#datepicker_value').val());
});


function getDashboardData(date) {
    $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getDashboardData",
            date: date
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
        	console.log(result);
        	$('.managers').html(data);
        } else {
        }
    });
}