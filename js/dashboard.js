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
			console.log(companyName);
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
			console.log(companyName);
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


$('#yesterday').click(function() {
	let date = new Date();
	date.setDate(date.getDate() - 1);
	date1 = date.toJSON().slice(0, 10);
	date2 = date.toJSON().slice(0, 10);
	getDashboardData(companyName);
	$("#datepicker1").datepicker("setDate", date);
	$("#datepicker").datepicker("setDate", date);
})


$('#week').click(function() {
	date2 = new Date().toJSON().slice(0, 10);
	let date11 = new Date();
	date11.setDate(date11.getDate() - date11.getDay() + 1);
	date1 = date11.toJSON().slice(0, 10);
	getDashboardData(companyName);
	$("#datepicker1").datepicker("setDate", new Date());
	$("#datepicker").datepicker("setDate", date11);
})

$('#month').click(function() {
	date2 = new Date().toJSON().slice(0, 10);
	let date11 = new Date();
	date11.setDate(1);
	date1 = date11.toJSON().slice(0, 10);
	getDashboardData(companyName);
	$("#datepicker1").datepicker("setDate", new Date());
	$("#datepicker").datepicker("setDate", date11);
})

$('#lastweek').click(function() {

	let date22 = new Date();
	date22.setDate(date22.getDate() - date22.getDay());
	date2 = date22.toJSON().slice(0, 10);

	let date11 = new Date();
	date11.setDate(date11.getDate() - date11.getDay() - 6);
	date1 = date11.toJSON().slice(0, 10);
	getDashboardData(companyName);
	$("#datepicker1").datepicker("setDate", date22);
	$("#datepicker").datepicker("setDate", date11);
})

$('#year').click(function() {
	date2 = new Date().toJSON().slice(0, 10);
	let date11 = new Date();
	date11.setDate(1);
	date1 = date11.toJSON().slice(0, 10);
	getDashboardData(companyName);
	$("#datepicker1").datepicker("setDate", new Date());
	$("#datepicker").datepicker("setDate", date11);
	//set month
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
        	try {
   var data = JSON.parse(result);
        if (data.result === "Ok") {
        	console.log(data.data.data);
        	$('.managersTable').html(data.data.html);
			getLeader();
        } else {
        	console.log(data);
        }
}
catch (e) {
   // инструкции для обработки ошибок
   console.log(e); // передать объект исключения обработчику ошибок
}
        
    });
}

function getLeader() {
	let max = 0;
        	let maxName = 'Нет';
        	$('.managersRowItemRecords').each(function() {
        		if (!($(this).parent().attr('id') == 'managerHead')) {
        			if (parseInt($(this).html()) > max) {
        				max = parseInt($(this).html());
        				maxName = $(this).parent().find('.managersRowItemName').html();
        			}
        		}
        	})
        	$('.leader').html('Лидер по записям: ' + maxName + ' (' + max + ')');
}
$('#today').click();