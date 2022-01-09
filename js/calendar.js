function getManagersCalendar() {
	$.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getManagersCalendar"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
        	$('.calendarArea').html(data.data.html);
        } else {
            console.log(data);
        }
    });
}
$('body').on('click', '.calendarRowItem', function() {
	console.log($(this));
	if ($(this).hasClass('selectedDay')) {
		$(this).removeClass('selectedDay');
	}
	else {
		$(this).addClass('selectedDay');
	}
})
getManagersCalendar();