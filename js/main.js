var company = '';
var current = 1;
var finish = 1;


function sendPost(company, page) {
    $.ajax({
        url : "https://ingeniouslife.space/yc_deals.php?company=" + company + "&page=" + page,
        type : "get",
        async: false,
        success : function(response) {
            console.log(response);
            $('.response').append(company + '<br><br>');
            current++;
            if (current <= finish) {
                sendPost(company, current);
            }
        },
        error: function() {
           console.log('error');
        }
     });
}

function start() {
    company = $('#company').val();
    current = $('#from').val();
    finish = $('#to').val();
    sendPost(company, current);
}