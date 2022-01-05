function menuClick(item) {
    $('.block').removeClass('blockActive');
    $('.' + index.attr('data-index')).addClass('blockActive');
    $('.menuItem').removeClass('menuItemActive');
    $(item).addClass('menuItemActive');
}

$('body').on('click', '.menuItem', function(){
    if (!$('.' + $(this).attr('data-index')).hasClass('blockActive')) {
        menuClick($(this));
    }
});