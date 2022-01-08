let popup = 0;


function popupManagerCheck(item) {
    item.toggleClass('itemActive');
    if ($('.itemActive').length > 0) {
        $('.popupButtons').css('display', 'flex');
    }
    else {
        $('.popupButtons').css('display', 'none');
    }
}

function menuClick(item) {
    $('.block').removeClass('blockActive');
    $('.' + item.attr('data-index')).addClass('blockActive');
    $('.menuItem').removeClass('menuItemActive');
    $(item).addClass('menuItemActive');
}
$('body').on('click', '.managersAddItem', function(){
        popupManagerCheck($(this));
});
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
        data: {classFile: "application.class", class: "Application", method: "getManagers"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            console.log(data);
            popupOpen(data.data.html, 'Добавьте менеджеров');
        } else {
            console.log(data);
        }
    });
    
}