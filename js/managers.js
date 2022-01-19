$('body').on('click', '.managersItem', function() {
	managersCheck($(this));
});


function managersCheck(item) {
    item.toggleClass('itemActive');
    managersButtonsCheck();
}


function managersButtonsCheck() {
    if ($('.managersItem.itemActive').length > 0) {
        $('.managersButtons').css('display', 'flex');
    }
    else {
        $('.managersButtons').css('display', 'none');
    }
}


function clearManagers() {
    $('.managersItem').removeClass('itemActive');
}

function saveManagers(company) {
    let managersList = [];
    $('.managersItem.itemActive').each(function() {
        managersList.push({id: $(this).attr('data-index'), name: $(this).html()});
    });
    console.log(managersList);
    $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "application.class", class: "Application", method: "deleteManagers",
        managersList: managersList
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            getActiveManagers(company);
        } 
        else {

        }
    });
}