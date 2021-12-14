$(function(){
	$("#datepicker").datepicker({
		onSelect: function(date){
			$('#datepicker_value').val(date);
			console.log(date);
		}
	});
	$("#datepicker").datepicker("setDate", $('#datepicker_value').val());
});


console.log(Date.parse($('#datepicker_value').val()));