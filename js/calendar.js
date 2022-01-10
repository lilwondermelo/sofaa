let activeColor = 'none';
let activeRole = 0;
let changed = [];
getCalendarStations();
function getManagersCalendar() {
	$.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getManagersCalendar"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
        	$('.calendarArea').html(data.data.html);
        	$('.calendarRowItemStations[data-id="1"]').click();
        } else {
            console.log(data);
        }
    });
}
function getCalendarStations() {
	$.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getCalendarStations"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
        	$('.calendarStations').html(data.data);
        	getManagersCalendar();
        } else {
            console.log(data);
        }
    });
}
$('body').on('click', '.calendarRowItem:not(.calendarRowItemStations)', function() {
	if ($(this).hasClass('selectedDay')) {
		$(this).removeClass('selectedDay');
		$(this).attr('data-id', '0');
		$(this).css('background', 'none');
	}
	else {
		$(this).addClass('selectedDay');
		calendarClick($(this));
		
	}
	console.log($(this).attr('data-id') + ' - ' + $(this).attr('data-old_id'));
	if ($(this).attr('data-id') != $(this).attr('data-old_id')) {
		changed['' + $(this).parent().attr('data-id') + ',' + $(this).attr('data-day')] = $(this).attr('data-id');
	}
	else {
		delete changed['' + $(this).parent().attr('data-id') + ',' + $(this).attr('data-day')];
	}
	
	checkCalendar();
})




$('body').on('click', '.calendarRowItemStations', function() {
	if (!$(this).hasClass('selectedStation')) {
		setStation($(this));
	}
})



function setStation(item) {
	$('.calendarRowItemStations').removeClass('selectedStation');
	item.addClass('selectedStation');
	activeColor = item.css('background');
	activeRole = item.attr('data-id');
}


function calendarClick(item) {
	item.attr('data-id', activeRole);
	item.css('background', activeColor);
}

function checkCalendar() {
	console.log(changed);
	if (Object.keys(changed).length == 0) {
		$('.calendarButtons').css('visibility', 'hidden');
	}
	else {
		$('.calendarButtons').css('visibility', 'visible');
	}
}






