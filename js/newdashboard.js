$(function(){
	$("#datepicker").datepicker({
		onSelect: function(date){
			$('#datepicker_value').val(date);
			console.log(date);
		}
	});
	$("#datepicker").datepicker("setDate", $('#datepicker_value').val());
});


console.log($('#datepicker_value').val());