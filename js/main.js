function sendPost(company, page) {
    $.get( "https://ingeniouslife.space/yc_deals.php?company=" + company + "&page=" + page, function( data ) { 
        console.log(data);
        //$( "div" ).html( data ); 
    })
}

function start() {
    var company = $('#company').val();
    var current = $('#from').val();
    var finish = $('#to').val();
    for (var i = current; i <= finish; i++) {
        sendPost(company, i);
        $('.response').append(company + '<br><br>');
    }
    
}