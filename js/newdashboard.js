$(function(){
	$("#datepicker").datepicker({
		onSelect: function(date){
			$('#datepicker_value').val(date);
			console.log(Date.parse(date));
		}
	});
	$("#datepicker").datepicker("setDate", $('#datepicker_value').val());
});


console.log($('#datepicker_value').val());