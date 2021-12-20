var company = '';
let amoHost = ''; //Пока передаем хост из поля "Название филиала"
let status = 0;
var current = 1;
var finish = 1;


function sendPostClients(company, page) {
    console.log('START');
    $.ajax({
        url : "https://ingeniouslife.space/yc_deals.php?company=" + company + "&page=" + page,
        type : "get",
        success : function(response) {
            console.log(page);
            $('.response').append(response + '<br><br>');
            current++;
            if (current <= finish) {
                sendPostClients(company, current);
            }
            else {
                console.log('FINISH');
            }
        },
        error: function() {
           console.log('error');
        }
     });
}
function sendPostManagers(company, page) {
    console.log('START');
    $.ajax({
        url : "https://ingeniouslife.space/dashboardscript.php?company=" + company + "&page=" + page,
        type : "get",
        success : function(response) {
            console.log(page);
            $('.response').append(response + '<br><br>');
            current++;
            if (current <= finish) {
                sendPostManagers(company, current);
            }
            else {
                console.log('FINISH');
            }
        },
        error: function() {
           console.log('error');
        }
     });
}
function sendPostLast(company, page) {
    console.log('START');
    $.ajax({
        url : "https://ingeniouslife.space/checkLastRecords.php?company=" + company + "&page=" + page,
        type : "get",
        success : function(response) {
            console.log(page);
            $('.response').append(response + '<br><br>');
            current++;
            if (current <= finish) {
                sendPostLast(company, current);
            }
            else {
                console.log('FINISH');
            }
        },
        error: function() {
           console.log('error');
        }
     });
}

function sendPostRecords(company, page) {
    console.log('START');
    $.ajax({
        url : "https://ingeniouslife.space/yc_records.php?company=" + company + "&page=" + page,
        type : "get",
        success : function(response) {
            console.log(page);
            $('.response').append(response + '<br><br>');
            current++;
            if (current <= finish) {
                sendPostRecords(company, current);
            }
            else {
                console.log('FINISH');
            }
        },
        error: function() {
           console.log('error');
        }
     });
}
function startLast() {
    company = $('#company').val();
    current = $('#from').val();
    finish = $('#to').val();
    sendPostLast(company, current);
}

function startClients() {
    company = $('#company').val();
    current = $('#from').val();
    finish = $('#to').val();
    sendPostClients(company, current);
}
function startRecords() {
    company = $('#company').val();
    current = $('#from').val();
    finish = $('#to').val();
    sendPostRecords(company, current);
}
function startManagers() {
    company = $('#company').val();
    current = $('#from').val();
    finish = $('#to').val();
    sendPostManagers(company, current);
}

function getLeads() {
    amoHost = $('#company').val();
    current = $('#from').val();
    finish = $('#to').val();
    status = $('#status').val();
    getLeadsData(company, current);
}


function getLeadsData(company, page) {
    console.log('START' + page);
    $.ajax({
        type: "POST",
        url: "_ajaxListener.class.php",
        data: {classFile: "amocrm.class", class: "Amocrm", method: "getLeadsFromAmo",
            amoHost: amoHost,
            page: page,
            status: status
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            current++;
            if (current <= finish) {
                
                console.log(data.data);
                console.log('FINISH' + page);
                getLeadsData(company, current);
            }
            else {
                console.log('FINISH' + page);
            }
        } else {
            console.log('error');
        }
    });
}

//JSON.parse(response)