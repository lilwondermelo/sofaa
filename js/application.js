function menuClick() {

}



$('body').on('click', '.menuItem', function(){
    console.log($(this).attr('data-index'));
});