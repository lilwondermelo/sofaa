let popup = 0;
let companyName = 'Telo';
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

function popupOpen(body, title, company) {
    if (title) {
        $('.popupHeader').html(title);
    }
    $('.popupSave').attr('onclick', 'saveManagersPopup("' + company + '")');
    $('.popupArea').html(body);
    $('.popup').css('display', 'flex');
    popup = 1;
}

function popupClose() {
    $('.popup').css('display', 'none');
    popup = 0;
}

function openManagers(company) {
     $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getManagers",
        company: company
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            console.log(data);
            popupOpen(data.data.html, 'Добавьте менеджеров', company);
        } else {
            console.log(data);
        }
    });
    
}

function saveManagersPopup(company) {
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
        managersList: managersList,
        company: company
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            getActiveManagers(company);
        } 
        else {

        }
    });
}

$( "#company" ).change(function () {
    getActiveManagers($( "#company option:selected" ).val());
    getCalendarStations($( "#company option:selected" ).val());
    companyName = $( "#company option:selected" ).val();
     $("#datepicker").datepicker("setDate", new Date());
  })



function getActiveManagers(company) {
    $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "getActiveManagers",
        company: company
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            $('.managersInner').html(data.data);
        } 
        else {
            console.log(data);
        }
    });
}

function clearManagersPopup() {
    $('.managersAddItem').removeClass('itemActive');
    popupButtonsCheck();
}