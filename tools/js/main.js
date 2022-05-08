let menuActive = 0, sideBarActive = 0;
let userId = 0;
startTools('map');
//createNewMap('map');
$('body').on('click', '.hexagon', function() {
  let id = $(this).attr('data-id');
  polygonClick(this);
})
function startTools(map) {
    page = 'tools';
    getMap(map);
    getTypes();
    getUnits();
    getPlayers();
}

function polygonClick(el) {
    let id = $(el).attr('tile-id');
    if ((menuActive == 2) && (sideBarActive > 0)) {
        tileEdit(id, 'type', sideBarActive);
    }
    else if (!$(el).hasClass('tileSelected')) {
        $('.hexagon').removeClass('tileSelected');
        $(el).addClass('tileSelected');
    }
}

function drawPalette() {
    for (let i = 0; i < types.length; i++) {
        let id = types[i].id;
        let name = types[i].name;
        //let moveCost = Object.entries(el)[1][1].move_cost;
        //let food = Object.entries(el)[1][1].food;
        //let prod = Object.entries(el)[1][1].prod;
        //let gold = Object.entries(el)[1][1].gold;
        $('.sideBarInnerPalette').append('<div class="sideBarItem" data-id="' + id + '">' + name + '</div>');
    }
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



function tileEdit(id, key, value) {
    map[id][key] = value;
    saveTile(id, map[id].x, map[id].y, map[id].type);
}

function saveTile(id, x, y, type) {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "map.class", class: "Map", method: "saveTile", tableName: 'map', id: id, type: type
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            map = data.data;
            refreshMap();
        } else {
            console.log(data);
        }
    });
}


