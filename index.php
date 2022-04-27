<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/model/tile.class';
  $tile = new Tile($x, $y);
?>
<!DOCTYPE html>
<html>
  <head>
    
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <div class="mainArea">
      
    </div>

    <div class="sideBar sideBarLeft menuBar">
      <div data-id="1" class="menuBarItem">Выбор объектов</div>
      <div data-id="2" class="menuBarItem">Заливка клетки</div>
      <div data-id="3" class="menuBarItem">Особенности местности</div>
      <div data-id="4" class="menuBarItem">Размещение юнитов</div>
    </div>

    <div class="sideBar sideBarRight">
      <div data-id="1" class="sideBarInner sideBarInnerSelect">
        <div class="sideBarSelectType">
          <div class="sideBarSelectTypeImage">
            <img src="" alt="">
          </div>
          <div class="sideBarSelectTypeName"></div>
        </div>
      </div>
      <div data-id="2" class="sideBarInner sideBarInnerPalette"></div>
      <div data-id="3" class="sideBarInner sideBarInnerFeatures"></div>
      <div data-id="4" class="sideBarInner sideBarInnerUnits"></div>
    </div>
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/parallax.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>