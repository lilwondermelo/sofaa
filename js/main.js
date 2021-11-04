var company = '';
var current = 1;
var finish = 1;


function sendPost(company, page) {
    $.ajax({
        url : "https://ingeniouslife.space/yc_deals.php?company=" + company + "&page=" + page,
        type : "get",
        success : function(response) {
            console.log(page);
            $('.response').append(response + '<br><br>');
            current++;
            if (current <= finish) {
                sendPost(company, current);
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

function start() {
    company = $('#company').val();
    current = $('#from').val();
    finish = $('#to').val();
    sendPost(company, current);
}

//JSON.parse(response)