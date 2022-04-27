$(document).on("mousemove",function(e){
  mx = e.clientX;
  my = e.clientY;
});

function checkCameraMove() {
  let minWidth = 5;
  let minHeight = 5;
  let maxWidth = $( window ).width() - 5;
  let maxHeight = $( window ).height() - 5;
  if (x > maxWidth) {
    //$('.mainArea')
  }
}