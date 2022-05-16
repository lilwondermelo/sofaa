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
createNewMap();
let d = [];
let mark = [];

let matrix = [];
let matrixIds = {};

/**
 * Алгоритм Дейкстры: кратчайший путь из одного источника
   * Идеи:
   * 1. Разделите вершины на две части: множество вершин Q, которое уже знает текущий кратчайший путь, и множество недостижимых вершин R.
   * 2. Определите массив расстояний (distance) для записи расстояния от исходной точки до каждой вершины, нижний индекс представляет вершину, а значение элемента - расстояние. Расстояние от исходной точки (начала) до самого себя равно 0, а расстояние между вершиной, которой исходная точка не может достичь, является большим числом (например, бесконечность).
   * 3. Возьмем вершину V с не-бесконечностью в массиве расстояний в качестве точки перехода. Если предположить, что расстояние от V до вершины W плюс расстояние от вершины V до исходной точки меньше, чем расстояние от вершины W до исходной точки, тогда вы можете Обновите расстояние от вершины W до исходной точки. То есть расстояние [V] + матрица [V] [W] <расстояние [W], тогда расстояние [W] = расстояние [V] + матрица [V] [W].
   * 4. Повторите предыдущий шаг, который заключается в прохождении массива расстояний, но при невозможности достичь вершины множество R пусто.
 *
   * матрица смежности @param
   * @парам старт
 *
 *
 *
   * Если в качестве исходной точки найти кратчайший путь каждой вершины полного графа, алгоритм Дейкстры можно использовать для обхода, но сложность по времени становится равной O (n ^ 3)
 * */
function Dijkstra(tileId) {


    let start = matrixIds[$('.circle[unit-id="' + selectedUnitId + '"]').attr('tile-id')].routeId;
    let target = matrixIds[tileId].routeId;
        const rows = matrix.length, // rows совпадает с cols, но на самом деле это число вершин
        cols = matrix[0].length;
         //if (row !== cols || start >= row) возвращает новую ошибку («Ошибка матрицы смежности или ошибка исходной точки»);
            let tempMatrix = matrix[start];
            let tempMatrixId = matrixIds[Object.keys(matrixIds)[start]];
            matrix[start] = matrix[0];
            matrix[0] = tempMatrix;
            matrixIds[Object.keys(matrixIds)[start]] = matrixIds[Object.keys(matrixIds)[0]];
            matrixIds[0] = tempMatrixId;

    for (let j = 0 ; j < rows; j++) {
                let tempMatrixValue = matrix[j][start];
                matrix[j][start] = matrix[j][0];
                matrix[j][0] = tempMatrixValue;
            }

 //console.log(matrix[0]);

         // инициализируем расстояние
    let distance = [];
    for (let i = 0 ; i < rows; i++) {
        distance[i] = Infinity;
    }
    distance[0] = 0;



    
    
 for(let i = 0; i < rows; i++) {
     for(let i = 0; i < rows; i++) {
                 // Недоступные вершины не могут быть использованы в качестве транзитных точек перехода
        if(distance[i] < Infinity) {
            for(let j = 0; j < cols; j++) {
                                 // Например, сравнивая размер расстояния [i] + матрица [i] [j] и расстояние [j], чтобы определить, обновлять ли расстояние [j].
                if(matrix[i][j] + distance[i] < distance[j]) {
                    distance[j] = matrix[i][j] + distance[i];
                    if (distance[j] < Infinity) {
                        
                    }
                    
                    //console.log([Object.keys(matrixIds)[j], distance[j]]);
                }
            }
        }
    }
 }

let neighbours;
if (Object.keys(matrixIds)[target] % 2 == 1) {
    neighbours = [21, -20, 19, -1, 1, 20];
}
else {
    neighbours = [-21, -20, -19, -1, 1, 20];
}

$('.text' + target).html(distance[target]);
 let temp = [];
for (let i = 0; i < neighbours.length; i++) {
    if (matrixIds[+Object.keys(matrixIds)[target] + neighbours[i]]) {
        console.log(matrixIds[+Object.keys(matrixIds)[target] + neighbours[i]].routeId);
        temp.push(distance[matrixIds[+Object.keys(matrixIds)[target] + neighbours[i]].routeId]);

    }
}
let min = temp[0];
let ind = 0;
for (let i = 0; i < temp.length; i++) {
    if (temp[i] < min) {
        min = temp[i];
        ind = i;
    }
}
$('.text' + ind).html(min);

console.log(target, distance[target]);


//console.log(distance);
   
    $('.texts').addClass('textsActive');
}



function newDijkstra(tileId) {


}
 




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

        
        let counter = 0;
        for (let i = 0; i < map.length; i++) {
            if ((types[map[i].type-1]['move_cost'] > -1) && (types[map[i].type-1]['is_water'] == 0)) {
                matrix.push([]);
                matrixIds[i] = {'x': map[i].x, 'y': map[i].y, "routeId": counter};
                counter++;
            }
        }
        for (let i = 0; i < matrix.length; i++) {
            for (let j = 0; j < matrix.length; j++) {
                let neighbours;
                if (Object.keys(matrixIds)[i] % 2 == 1) {
                    neighbours = [21, -20, 19, -1, 1, 20];
                }
                else {
                    neighbours = [-21, -20, -19, -1, 1, 20];
                }
                if (i == j) {
                    matrix[i][j] = 0;
                }
                else if (neighbours.includes(Object.keys(matrixIds)[j] - Object.keys(matrixIds)[i])) {
                    matrix[i][j] = 1;
                }
                else {
                    matrix[i][j] = Infinity;
                }
            }
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
    await new Promise((resolve, reject) => setTimeout(resolve, 2000));
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "getUnits"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            units = data.data;
            //console.log(units);
            console.log(2);
            refreshUnits();
            refreshUnitsData();
        } else {
            console.log(data);
        }
    });
}

function getAvatars() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "getAvatars"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            avatars = data.data;
            checkArray['avatars'] = 1;
            checkDownload();
        } else {
            console.log(data);
        }
    });
}

function getUnits() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
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
     $(".map").append('<defs><style>.cls-1{fill:#cdb19e;}.cls-2{fill:#c9a796;}.cls-3{fill:#e4c7ab;}.cls-4{fill:#efdccb;}.cls-5{fill:#f08d81;}.cls-6{fill:#a17d5f;}.cls-7{fill:#f4e8df;}.cls-8{fill:#d34b45;opacity:0.87;}.cls-14,.cls-8,.cls-9{isolation:isolate;}.cls-9{fill:#b61b18;opacity:0.75;}.cls-10{fill:#a78878;}.cls-11{fill:#e28875;}.cls-12{fill:#826965;}.cls-13{fill:#d48f6b;}.cls-14{fill:#6d0605;opacity:0.44;}.cls-15{fill:#eda078;}.cls-16{fill:#f25a4d;}.cls-17{fill:#f0b08f;}.cls-18{fill:#f3bea3;}.cls-19{fill:#bf9b82;}.cls-20{fill:#bea38f;}.cls-21{fill:#c28362;}.cls-22{fill:#ae7658;}.cls-23{fill:#a16c51;}.cls-24{fill:#404a57;}.cls-25{fill:#dfd5d5;}.cls-26{fill:#81585c;}.cls-27{fill:#e0d3d3;}.cls-28{fill:#f1b89a;}.cls-29{fill:#e34332;}.cls-30{fill:#aa7356;}.cls-31{fill:#1d202f;}.cls-32{fill:#7b524d;}.cls-33{fill:#d9d3d0;}.cls-34{fill:#bb6d65;}.cls-35{fill:#9c694f;}.cls-36{fill:#8e6048;}.cls-37{fill:#e6aaac;}.cls-38{fill:#fa1812;}.cls-39{fill:#afa19f;}.cls-40{fill:#6b011a;}.cls-41{fill:#c50042;}.cls-42{fill:#800025;}.cls-43{fill:#e5e2e3;}</style></defs>');
    $(".map").append('<defs><style>.cls-1a{fill:#FFFFFF;}.cls-2a{fill:#010101;}.cls-3a{fill:#C79C6F;}.cls-4a{fill:#E80F13;}.avatar {pointer-events: auto;}</style></defs>');
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
        .attr("fill", function(d) { return 'transparent'; })
        .attr("r", 30)
        .attr("transform", function(d) {return "translate(" + (d.x) + "," + (d.y) + ")"; });



        for (let i = 0; i < players.length; i++) {
            g = svg.append("g").attr("class", "avatar avatar" + players[i].id);
            //$('.avatar').css('pointer-events', 'auto');
            //$('.avatar').css('pointer-events', 'auto');
            g.html(players[i].avatar);
            let unit = $('.avatar' + players[i].id);
            unit.attr("transform", "translate(" + -200 + "," + -200 + ") scale(0.1)");
        }
        texts = svg.append("g").attr("class", "texts");
   
        xInit -= 10;
        for (let i = 0; i < Object.keys(matrixIds).length; i++) {
            let x = xInit + map[Object.keys(matrixIds)[i]].x * xDelta;
        let y = yInit + map[Object.keys(matrixIds)[i]].y * yDelta;
        if (Object.keys(matrixIds)[i]%2 == 1) {
            x += xDelta / 2;  
        }
            texts.append("text")
                .attr("class", "text text" + i)
                .attr("transform", function(d) {return "translate(" + x + ", " + y + ")"; });
        }

        console.log(texts);
        //'<text x="20" y="35" class="small">My</text>';


    refreshMap();
}



function unitSelect() {
    $('.circle').removeClass('unitSelected');
    $('.circle[unit-id="' + selectedUnitId + '"]').addClass('unitSelected');
}


function refreshMap() {
    for (let i = 0; i < map.length; i++) {
        $('.hexagon[tile-id="' + i + '"]').attr('class', "hexagon tile" + map[i].type);
    }
    //getUnits();
}

function refreshUnits() {
    let xDelta = 86.6;
    let yDelta = 75;
    let yInit = 55;
    let xInit = 41;
    $('.circle').removeClass("active");
    for (let i = 0; i < units.length; i++) {
        let x = xInit + map[units[i].tile].x * xDelta;
        let y = yInit + map[units[i].tile].y * yDelta;
        if (units[i].tile%2 == 1) {
            x += xDelta / 2;
        }
        $('.avatar' + units[i].player).attr('transform', 'translate(' + x + ', ' + y + ') scale(0.1)')
        if (units[i].player == userId) {
            $('.circle[tile-id="' + units[i].tile + '"]').addClass('ownUnit');
        }
        $('.circle[tile-id="' + units[i].tile + '"]').attr("player-id", units[i].player);
        $('.circle[tile-id="' + units[i].tile + '"]').attr("unit-id", units[i].id);
        $('.circle[tile-id="' + units[i].tile + '"]').addClass("active");
    }
        selectedUnitId = $('.ownUnit').attr('unit-id');
    

    unitSelect();
}



function createNewMap() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
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
