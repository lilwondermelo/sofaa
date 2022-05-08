let selectedUnitId = -1;
let sizeX = 20;
let sizeY = 20;
let page = '';
let checkArray = {
    "players": 0,
    "types": 0,
    "map": 0,
    "units": 0
}
let players = [], units = [], map = [], types = [];
let points = [];
let centers = [];
let id = 0;
let shiftX = 0;
//createNewMap();

function checkDownload() {
    const count = Object.entries(checkArray).length;
    let progress = 0;
    let flag = 1;
    Object.entries(checkArray).forEach(function(item) {
        if (item[1] == 1) {
            progress += 100/Object.entries(checkArray).length;
        }
        else {
            flag = 0;
        }
    });
    if (flag == 0) {
        console.log(progress + '%');
    }
    else {
        if (page == 'tools') {
            drawPalette();
        }
        drawMap();
        refreshUnits();
        refreshUnitsData();
    }
}

function getPlayers() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "getPlayers"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            players = data.data;
            checkArray['players'] = 1;
            checkDownload();
        } else {
            console.log(data);
        }
    });
}

async function refreshUnitsData() {
    await new Promise((resolve, reject) => setTimeout(resolve, 400));
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        async: false,
        data: {classFile: "map.class", class: "Map", method: "getUnits"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            units = data.data;
            console.log(units);
            refreshUnits();
            //refreshUnitsData();
        } else {
            console.log(data);
        }
    });
}


function getUnits() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        async: false,
        data: {classFile: "map.class", class: "Map", method: "getUnits"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            units = data.data;
            checkArray['units'] = 1;
            checkDownload();
        } else {
            console.log(data);
        }
    });
}

function getTypes() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        async: false,
        data: {classFile: "map.class", class: "Map", method: "getTypes"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            types = data.data;
            checkArray['types'] = 1;
            checkDownload();
            
        } else {
            console.log(data);
        }
    });
}

function getMap(table) {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "getTiles", table: table
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            map = data.data;
            checkArray['map'] = 1;
            checkDownload();
        } else {
            console.log(data);
        }
    });
}

function drawMap() {
    $('.mainArea').html('<svg class="map" width="2800" height="1600"></svg>');
    var svg = d3.select(".map"),
    width = +svg.attr("width"),
    height = +svg.attr("height"),
    g = svg.append("g").attr("class", "hexagons");
    console.log(g);
    $('.mainArea').css('width', '1800px');
    $('.mainArea').css('height', '1600px');


    let xDelta = 86.6;
    let yDelta = 75;
    let xInit = 67.5;
    let yInit = 75;

    for (let i = 0; i < map.length; i++) {
        let x = xInit + map[i].x * xDelta;
        let y = yInit + map[i].y * yDelta;
        if (i%2 == 1) {
            x += xDelta / 2;  
        }
        centers[i] = {'x': x,'y': y, 'id': i};
        points[i] = [x, y, {'type': map[i].type, 'id': i}];
    }

    var hexbin = d3.hexbin()
    .radius(50);
    let hex = hexbin(points);
    g.selectAll("path")
      .data(hex)
      .enter().append("path")
        .attr("tile-id", function(d) {return d[0][2]['id']})
        .attr("class", "hexagon")
        .attr("d", hexbin.hexagon())
        .attr("transform", function(d) {return "translate(" + (d.x+25) + "," + (d.y) + ")"; });


    g = svg.append("g").attr("class", "circles");
    g.selectAll("circle")
      .data(centers)
      .enter().append("circle")
        .attr("class", "circle")
        .attr("tile-id", function(d) {return d.id})
        .attr("fill", function(d) { return 'yellow'; })
        .attr("r", 30)
        .attr("transform", function(d) {return "translate(" + (d.x) + "," + (d.y) + ")"; });
    refreshMap();
    refreshUnitsData();
}



function unitSelect() {
    $('.circle').removeClass('unitSelected');
    $('.circle[unit-id="' + selectedUnitId + '"]').addClass('unitSelected');
}

function polygonClick(el) {
    let id = $(el).attr('data-id');
    if ((menuActive == 2) && (sideBarActive > 0)) {
        tileEdit(id, 'type', sideBarActive);
    }
    else if (!$(el).hasClass('tileSelected')) {
        $('.hexagon').removeClass('tileSelected');
        $(el).addClass('tileSelected');
    }
}
function refreshMap() {
    for (let i = 0; i < map.length; i++) {
        $('.hexagon[tile-id="' + i + '"]').attr('class', "hexagon tile" + map[i].type);
    }
    //getUnits();
}

function refreshUnits() {
    $('.circle').removeClass("active");
    for (let i = 0; i < units.length; i++) {
        if (units[i].player == userId) {
            $('.circle[tile-id="' + units[i].tile + '"]').addClass('ownUnit');
        }
        $('.circle[tile-id="' + units[i].tile + '"]').attr("player-id", units[i].player);
        $('.circle[tile-id="' + units[i].tile + '"]').attr("unit-id", units[i].id);
        $('.circle[tile-id="' + units[i].tile + '"]').addClass("active");
    }
    if (selectedUnitId == -1) {
        selectedUnitId = $('.ownUnit').attr('unit-id');
    }
    unitSelect();
}



function createNewMap() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        async: false,
        data: {classFile: "map.class", class: "Map", method: "createNewMap", map: 'map'
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            console.log(1);
            
        } else {
            console.log(data);
        }
    });
}