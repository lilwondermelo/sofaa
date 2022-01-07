let popup = 0;

function menuClick(item) {
    $('.block').removeClass('blockActive');
    $('.' + item.attr('data-index')).addClass('blockActive');
    $('.menuItem').removeClass('menuItemActive');
    $(item).addClass('menuItemActive');
}

$('body').on('click', '.menuItem', function(){
    if (!$('.' + $(this).attr('data-index')).hasClass('blockActive')) {
        menuClick($(this));
    }
});

function popupToggle() {
    if (popup == 1) {
        $('.popup').css('display', 'none');
        popup = 0;
    }
    else {
        $('.popup').css('display', 'flex');
        popup = 1;
    }
}