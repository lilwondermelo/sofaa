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
        	console.log(data.data.from);
        	console.log(data.data.to);
        	$('.managers').html(data.data.html);
        } else {

        }
    });
}