let activeColor = 'none';
let activeRole = 0;
let changed = {};
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
        	console.log(data.data.data);
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
	if ($(this).attr('data-id') != $(this).attr('data-old-id')) {
		changed['' + $(this).attr('data-day') + '-' + $(this).parent().attr('data-id') + $(this).attr('data-day')] = {role: $(this).attr('data-id'), id: $(this).attr('data-index')};
	}
	else {
		delete changed['' + $(this).attr('data-day') + '-' + $(this).parent().attr('data-id') + $(this).attr('data-day')];
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


function saveCalendar() {
	data = {};
	console.log(JSON.stringify(changed));
	changed.forEach(function(item, index){
	  console.log(index);
	})
	$.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "saveCalendar",
        changed: JSON.stringify(changed)
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
        	console.log(data);
        } else {
            console.log(data);
        }
    });
}




