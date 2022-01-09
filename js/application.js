let popup = 0;

function popupButtonsCheck() {
    if ($('.itemActive').length > 0) {
        $('.popupButtons').css('display', 'flex');
    }
    else {
        $('.popupButtons').css('display', 'none');
    }
}
function popupManagersCheck(item) {
    item.toggleClass('itemActive');
    popupButtonsCheck();
}

function menuClick(item) {
    $('.block').removeClass('blockActive');
    $('.' + item.attr('data-index')).addClass('blockActive');
    $('.menuItem').removeClass('menuItemActive');
    $(item).addClass('menuItemActive');
}
$('body').on('click', '.managersAddItem', function(){
        popupManagersCheck($(this));
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

function saveManagers() {
    let managersList = [];
    $('.managersAddItem.itemActive').each(function() {
        managersList.push({id: $(this).attr('data-index'), name: $(this).html()});
    });
    console.log(managersList);
    popupClose();
    $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "addManagers",
        managersList: managersList
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            getActiveManagers();
        } 
        else {

        }
    });
}


function getActiveManagers() {
    $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getActiveManagers"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            $('.managersInner').html(data.data);
        } 
        else {

        }
    });
}

function clearManagers() {
    $('.managersAddItem').removeClass('itemActive');
    popupButtonsCheck();
}