var company = '';
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
//JSON.parse(response)