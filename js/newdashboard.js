$(function(){
	$("#datepicker").datepicker({
		onSelect: function(date){
			$('#datepicker_value').val(date)
		}
	});
	$("#datepicker").datepicker("setDate", $('#datepicker_value').val());
});