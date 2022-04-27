let map = {}, types = {}, typesArray = [], mapArray = [], menuActive = 0, sideBarActive = 0;
getAllTypesFromDb();
getAllTilesFromDb('map');
//createNewMap('map');


function drawPalette() {
    typesArray = Object.entries(types);
    typesArray.forEach(function(el){
        let id = Object.entries(el)[0][1];
        let name = Object.entries(el)[1][1].name;
        let moveCost = Object.entries(el)[1][1].move_cost;
        let food = Object.entries(el)[1][1].food;
        let prod = Object.entries(el)[1][1].prod;
        let gold = Object.entries(el)[1][1].gold;
        $('.sideBarInnerPalette').append('<div class="sideBarItem" data-id="' + id + '">' + name + '</div>');
    });
}


$('body').on('click', '.menuBarItem', function() {
    let id = $(this).attr('data-id');
    if (id != menuActive) {
        menuActive = id;
        menuClick(id);
    }
})

$('body').on('click', '.sideBarItem', function() {
    let id = $(this).attr('data-id');
    if (id != sideBarActive) {
        sideBarActive = id;
        sideBarClick(id);
    }
})

function sideBarClick(id) {
    $('.sideBarItem').removeClass('sideBarItemActive');
    $('.sideBarItem[data-id="' + id + '"]').addClass('sideBarItemActive');
    if ((menuActive == 2) && (sideBarActive > 0)) {
        $('.mainArea').addClass('fill');
    }
    else {
        $('.mainArea').removeClass('fill');
    }
}

function menuClick(id) {
    $('.menuBarItem').removeClass('menuBarItemActive');
    $('.menuBarItem[data-id="' + id + '"]').addClass('menuBarItemActive');
    $('.sideBarRight > *').hide();
    $('.sideBarRight > [data-id="' + id + '"]').show();
    if ((menuActive == 2) && (sideBarActive > 0)) {
        $('.mainArea').addClass('fill');
    }
    else {
        $('.mainArea').removeClass('fill');
    }
}

function getAllFeaturesFromDb() {
    $.ajax({
        type: "POST",
        url: "core/_ajaxListener.class.php",
        async: false,
        data: {classFile: "map.class", class: "Map", method: "getAllFeaturesFromDb"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            console.log(data);
        } else {
            console.log(data);
        }
    });
}



function getAllTypesFromDb() {
    $.ajax({
        type: "POST",
        url: "core/_ajaxListener.class.php",
        async: false,
        data: {classFile: "map.class", class: "Map", method: "getAllTypesFromDb"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            types = data.data;
            drawPalette();
            menuClick(1);
            
        } else {
            console.log(data);
        }
    });
}

function getAllTilesFromDb(table) {
    $.ajax({
        type: "POST",
        url: "core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "getAllTilesFromDb", table: table
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            map = data.data;
            drawMap();
        } else {
            console.log(data);
        }
    });
}

function createNewMap(table) {
    $.ajax({
        type: "POST",
        url: "core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "createNewMap", table: table
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            console.log(data);
        } else {
            console.log(data);
        }
    });
}

function deleteTile(id) {
    let svg = $('#tile_' + id);
    svg.remove();
}

function drawTile(id, x, y, type) {
    let svg = '<svg class="tile" id="tile_' + id + '" data-id="' + id + '" data-name="tile_' + id + '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 396 344" width="200" height="170">' +
    '<polygon onclick="polygonClick(this)" class="tilePolygon tile' + type + '" points="295.15 1 99.15 1 1.15 171 99.15 341 295.15 341 393.15 171 295.15 1"/></svg>';
    $('.mainArea').append(svg);
    document.querySelector('polygon').addEventListener('click', () => console.log('clicked'));
    let topDelta = Math.sqrt(3) * 97;
    let leftDelta = Math.sqrt(3) * 84.5;
    let top = topDelta * y;
    let left = leftDelta * x;
    if (x % 2 == 1) {
        top = top + topDelta / 2;
    }
    $('#tile_' + id).css('top', top + 'px');
    $('#tile_' + id).css('left', left + 'px');
}

function drawMap() {
    mapArray = Object.entries(map);
    mapArray.forEach(function(el){
        let id = Object.entries(el)[0][1];
        let x = Object.entries(el)[1][1].x;
        let y = Object.entries(el)[1][1].y;
        let type = Object.entries(el)[1][1].type;
        drawTile(id, x, y, type);
    });
}

function tileEdit(id, key, value) {
    map[id][key] = value;
    deleteTile(id);
    saveTile(id, map[id].x, map[id].y, map[id].type);
}

function saveTile(id, x, y, type) {
    $.ajax({
        type: "POST",
        url: "core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "saveTile", tableName: 'map', id: id, type: type
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            drawTile(id, x, y, type);
        } else {
            console.log(data);
        }
    });
}


function polygonClick(el) {
    let id = $(el).parent().attr('data-id');
    if ((menuActive == 2) && (sideBarActive > 0)) {
        tileEdit(id, 'type', sideBarActive);
    }
    else if (!$(el).hasClass('tileSelected')) {
        $('.tilePolygon').removeClass('tileSelected');
        $(el).addClass('tileSelected');
        $('.tile').css('z-index', '1');
        $(el).parent().css('z-index', '2');
    }
}



//Реализация масштабирования при помощи скролинга колёсиком мыши

//Переменные
var delta; // Направление колёсика мыши
//Объявление переменной значения зума
var isCall = false;
    if(!isCall){
    var zoom = 1;
    isCall = true;//Чтобы начальное значение было присвоено 1 раз
    }

//Функция для добавления обработчика событий
function addHandler(object, event, handler){
    if(object.addEventListener){
    object.addEventListener(event, handler, false);
    }else if(object.attachEvent){
    object.attachEvent('on' + event, handler);
    }else alert("Обработчик не поддерживается");
    }

// Добавляем обработчики для разных браузеров
addHandler(window, 'DOMMouseScroll', wheel);
addHandler(window, 'mousewheel', wheel);
addHandler(document, 'mousewheel', wheel);

// Функция, обрабатывающая событие
function wheel(event){
event = event || window.event;
// Opera и IE работают со свойством wheelDelta
    if (event.wheelDelta){ // В Opera и IE
    delta = event.wheelDelta / 120;
// В Опере значение wheelDelta такое же, но с противоположным знаком
        if (window.opera){
        delta = -delta;// Дополнительно для Opera
        }
    }else if(event.detail){ // Для Gecko
    delta = -event.detail / 3;
    }
   

//Выполняем зум
    if(delta > 0){
    zoom += 0.1;//Шаг
    $('.mainArea').css('MozTransform', zoom);
    $('.mainArea').css('OTransform', zoom);
    $('.mainArea').css('zoom', zoom);
    }else{
    zoom -= 0.1;//Шаг
    $('.mainArea').css('MozTransform', zoom);
    $('.mainArea').css('OTransform', zoom);
    $('.mainArea').css('zoom', zoom);
    }
    }