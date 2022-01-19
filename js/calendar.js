let activeColor = 'none';
let activeRole = 0;
let changed = {};
let stars = {};
let isStar = 0;
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
	if (isStar) {
		if ($(this).hasClass('selectedStar')) {
			$(this).removeClass('selectedStar');
			$(this).attr('data-star', '0');
		}
		else {
			$(this).addClass('selectedStar');
			calendarClick($(this));
		}
		if ($(this).attr('data-star') != $(this).attr('data-old-star')) {
			stars['' + $(this).parent().attr('data-id') + '-' + $(this).attr('data-day')] = $(this).attr('data-index');
		}
		else {
			delete stars['' + $(this).parent().attr('data-star') + '-' + $(this).attr('data-day')];
		}
		checkCalendar();
	}
	else {
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
			changed['' + $(this).parent().attr('data-id') + '-' + $(this).attr('data-day')] = {role: $(this).attr('data-id'), id: $(this).attr('data-index')};
		}
		else {
			delete changed['' + $(this).parent().attr('data-id') + '-' + $(this).attr('data-day')];
		}
		checkCalendar();
	}
})

$('body').on('click', '.calendarRowItemStations', function() {
	if ($(this).hasClass('calendarRowItemStationsStar')) {
		setStar($(this));
	}
	else if (!$(this).hasClass('selectedStation')) {
		setStation($(this));
	}
})

function setStar(item) {
	$('.calendarRowItemStations').removeClass('selectedStation');
	item.addClass('selectedStation');
	isStar = 1;
}

function setStation(item) {
	$('.calendarRowItemStations').removeClass('selectedStation');
	item.addClass('selectedStation');
	activeColor = item.css('background');
	activeRole = item.attr('data-id');
	isStar = 0;
}

function calendarClick(item) {
	if (!isStar) {
		item.attr('data-id', activeRole);
		item.css('background', activeColor);
	}
	else {
		item.attr('data-star', '1');
	}
}

function checkCalendar() {
	console.log(changed);
	console.log(stars);
	if ((Object.keys(changed).length == 0) && (Object.keys(stars).length == 0)) {
		$('.calendarButtons').css('visibility', 'hidden');
	}
	else {
		$('.calendarButtons').css('visibility', 'visible');
	}
}

function saveCalendar() {
	if (changed == {}) {
		changed = 0;
	}
	if (stars == {}) {
		stars = 0;
	}
	$.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "saveCalendar",
        changed: changed,
        stars: stars
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
        	changed = {};
        	stars = {};
        	checkCalendar();
        } else {
            console.log(data);
        }
    });
}
