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

function popupOpen(body, title) {
    if (title) {
        $('.popupHeader').html(title);
    }
    $('.popupArea').html(body);
    $('.popup').css('display', 'flex');
    popup = 1;
}
function popupClose() {
    $('.popup').css('display', 'none');
    popup = 0;
}

function openManagers() {
     $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getManagers",
            date: date
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            console.log(data);
        } else {
            console.log(data);
        }
    });
    popupOpen(data, 'Добавьте менеджеров');
}