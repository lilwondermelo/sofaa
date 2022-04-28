const sleep = ms => new Promise(res => setTimeout(res, ms));
let cameraState = 0;


let minWidth = 10;
let minHeight = 10;
let maxWidth = $( window ).width() - 10;
let maxHeight = $( window ).height() - 10;


$(document).on('mouseenter', '.border', function(e) {
  cameraState = 1;
  cameraMove();
});

$(document).on('mouseleave', '.border', function(e) {
  mx = e.clientX;
  my = e.clientY;
  if (my <= maxHeight) {
    cameraState = 0;
  }
});

async function cameraMove() {
  if (cameraState == 1) {
    console.log('down')
    await sleep(200);
    cameraMove();
  }
}


