let activeColor = 'none';
let activeRole = 0;
let calen = [];
let oldCalen = [];
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
        	calen = getCalendarMap();
        	oldCalen = calen;
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
		$(this).attr('data-id', 0);
		$(this).css('background', 'none');
	}
	else {
		$(this).addClass('selectedDay');
		calendarClick(item);
	}
	console.log(oldCalen);
	console.log(calen);
	calen = getCalendarMap();
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
	if (cal == oldCalen) {
		console.log('check');
	}
	else {
		console.log('not check');
	}
}

function getCalendarMap() {
	let cal = [];
	$('.calendarRow').each(function() {
		if (!$(this).hasClass('calendarRowStations')) {
			let managerId = $(this).attr('data-id');
			cal[managerId] = [];
			$(this).find('.calendarRowItem').each(function() {
				if (!($(this).hasClass('calendarRowItemStations')) || ($(this).hasClass('calendarRowItemName'))) {
					cal[managerId][$(this).attr('data-day')] = $(this).attr('data-id');
				}
			})
		}
	})
	return cal;
}






