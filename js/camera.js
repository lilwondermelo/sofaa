//document.oncontextmenu = cmenu; function cmenu() { return false; }
  let isDown = false;
  let startX;
  let startY;
  let scrollLeft;
  let scrollTop;
  let slider;
  var walkX = 0;
  var walkY = 0;
  var momentumID;


let landTiles = [2, 3, 4, 5, 10];


$('body').on('click', '.circle', function() {
    if ($(this).attr('player-id') == userId) {
        selectedUnitId = $(this).attr('unit-id');
        unitSelect();
    }
})
$('body').on('click', '.hexagon', function() {
    polygonClick(this);
})
  function beginMomentumTracking(){
    cancelMomentumTracking();
    momentumID = requestAnimationFrame(momentumLoop);
  }
  function cancelMomentumTracking(){
    cancelAnimationFrame(momentumID);
  }
  function momentumLoop(){
    var newScrollLeft = parseInt(slider.css('left'), 10) + walkX;
    slider.css('left', newScrollLeft + 'px');
    walkX *= 0.4; 
    var newScrollTop = parseInt(slider.css('top'), 10) + walkY;
    slider.css('top', newScrollTop + 'px');
    walkY *= 0.4; 
    if ((Math.abs(walkX) > 0.5) && (Math.abs(walkY) > 0.5)){
      momentumID = requestAnimationFrame(momentumLoop);
    }
  }

window.oncontextmenu = function ()
{
    return false;     // cancel default menu
}

 $('body').on('mouseup', '.hexagon', function(e) {
     if(e.which == 3)
      {

        $('.map').removeClass('move');
        $('.map').removeClass('denied');
        let tileId = $(this).attr('tile-id');
                            $('.texts').removeClass('textsActive');

        if (landTiles.includes(parseInt(map[tileId].type, 10))) {
          move(tileId);
        }
        
      }
    
  });

 $('body').on('mouseenter', '.hexagon', function(e) {
     if(e.which == 3)
      {
         let tileId = $(this).attr('tile-id');
         movePlan(tileId);
      }
    
  });


  $('body').on('mousedown', '.hexagon', function(e) {
     if(e.which == 3)
      {
        let tileId = $(this).attr('tile-id');
         movePlan(tileId);
      }
       else if(e.which == 1)
      {
    slider = $('.map');
    isDown = true;
    slider.addClass('active');
    startX = e.pageX;
    startY = e.pageY;
    scrollLeft = parseInt(slider.css('left'), 10);
    scrollTop = parseInt(slider.css('top'), 10);
    cancelMomentumTracking();
      }
    
  });

$('body').on('mouseup', '.map', function(e) {
      if(e.which == 1)
      {
        slider = $(this);
        isDown = false;
        slider.removeClass('active');
        beginMomentumTracking();
      }
    
  })

  function movePlan(tileId) {

    //Dijkstra(tileId);
    if (landTiles.includes(parseInt(map[tileId].type, 10))) {
      $('.map').addClass('move');
      $('.map').removeClass('denied');
    }
    else {
      $('.map').removeClass('move');
      $('.map').addClass('denied');
    }
  }


  function move(tileId) {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "moveUnitTest", unitId: selectedUnitId, tileId: tileId
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
      
            refreshUnits();
        } else {
            console.log(data);
        }
    });
    
  }


      $('body').on('mouseleave', '.map', function(e) {
     slider = $('.map, .hexagon');
    isDown = false;
    slider.removeClass('active');
  })


     $('body').on('mousemove', '.map', function(e) {
     slider = $('.map');
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX;
    walkX = (x - startX); //scroll-fast
    var prevScrollLeft = parseInt(slider.css('left'), 10);
    var newScrollLeft = prevScrollLeft + walkX;
    slider.css('left', newScrollLeft + 'px');
    const y = e.pageY;
    walkY = (y - startY); //scroll-fast
    var prevScrollTop = parseInt(slider.css('top'), 10);
    var newScrollTop = prevScrollTop + walkY;
    slider.css('top', newScrollTop + 'px');


  })


     //???????????????????? ?????????????????????????????? ?????? ???????????? ?????????????????? ?????????????????? ????????

//????????????????????
var delta; // ?????????????????????? ???????????????? ????????
//???????????????????? ???????????????????? ???????????????? ????????
var isCall = false;
    if(!isCall){
    var zoom = 1;
    isCall = true;//?????????? ?????????????????? ???????????????? ???????? ?????????????????? 1 ??????
    }

//?????????????? ?????? ???????????????????? ?????????????????????? ??????????????
function addHandler(object, event, handler){
    if(object.addEventListener){
    object.addEventListener(event, handler, false);
    }else if(object.attachEvent){
    object.attachEvent('on' + event, handler);
    }else alert("???????????????????? ???? ????????????????????????????");
    }

// ?????????????????? ?????????????????????? ?????? ???????????? ??????????????????
addHandler(window, 'DOMMouseScroll', wheel);
addHandler(window, 'mousewheel', wheel);
addHandler(document, 'mousewheel', wheel);

// ??????????????, ???????????????????????????? ??????????????
function wheel(event){
event = event || window.event;
// Opera ?? IE ???????????????? ???? ?????????????????? wheelDelta
    if (event.wheelDelta){ // ?? Opera ?? IE
    delta = event.wheelDelta / 120;
// ?? ?????????? ???????????????? wheelDelta ?????????? ????, ???? ?? ?????????????????????????????? ????????????
        if (window.opera){
        delta = -delta;// ?????????????????????????? ?????? Opera
        }
    }else if(event.detail){ // ?????? Gecko
    delta = -event.detail / 3;
    }
//?????????????????? ??????
    if(delta > 0){
    zoom += 0.02;//??????
    }else{
    zoom -= 0.02;//??????
    }
    if (zoom > 1.25) {
      zoom = 1.25;
    }
    if (zoom < 0.25) {
      zoom = 0.25;
    }
    $('.map').css('-moz-transform', 'scale('+ zoom + ')');
    $('.map').css('MozTransform', zoom);
    $('.map').css('OTransform', zoom);
    $('.map').css('zoom', zoom);
    
    }

