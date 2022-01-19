let date1 = '2022-01-20', date2 = '2022-01-20';
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
			getDashboardData(companyName);
		}
	});
	$("#datepicker1").datepicker("setDate", $('#datepicker1_value').val());
});

$('#today').click(function() {
	date1 = new Date().toJSON().slice(0, 10);
	date2 = new Date().toJSON().slice(0, 10);
	getDashboardData(companyName);
	$("#datepicker1").datepicker("setDate", new Date());
	$("#datepicker").datepicker("setDate", new Date());
})

$('#week').click(function() {
	date2 = new Date().toJSON().slice(0, 10);
	date1 = new Date().toJSON().slice(0, 10);
	console.log(new Date().getDate());
	console.log(new Date().getDay());
	getDashboardData(companyName);
	$("#datepicker1").datepicker("setDate", new Date());
	$("#datepicker").datepicker("setDate", new Date());
})



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