let date1 = $('#datepicker_value').val(), date2 = $('#datepicker1_value').val();
$.datepicker.regional['ru'] = {
		closeText: 'Закрыть',
		prevText: 'Предыдущий',
		nextText: 'Следующий',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресеёнье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		weekHeader: 'Не',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
$(function(){
	$("#datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		onSelect: function(date){
			$('#datepicker_value').val(date);
			date1 = date;
			getDashboardData(companyName);
		}
	});
	$("#datepicker").datepicker("setDate", $('#datepicker_value').val());
});

$(function(){
	$("#datepicker1").datepicker({
		dateFormat: "yy-mm-dd",
		onSelect: function(date){
			$('#datepicker1_value').val(date);
			date2 = date;
			getDashboardData(date1, date2, companyName);
		}
	});
	$("#datepicker1").datepicker("setDate", $('#datepicker1_value').val());
});

function getDashboardData(company) {
	console.log(date1);
console.log(date2);
    $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getDashboardData",
            date1: date1,
            date2: date2,
            company: company
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
        	console.log(data.data.data);
        	$('.managersTable').html(data.data.html);
        } else {
        	console.log(data);
        }
    });
}