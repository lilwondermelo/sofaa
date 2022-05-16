let menuActive = 0, sideBarActive = 0;
let userName = '';
let userId = 0;
//getPage();

function getPage() {
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "client.class", class: "Client", method: "getPage"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            if (data.data != 'login') {
                userName = data.data.userName;
                userId = data.data.userId;
                drawMainMenu('menu');
            }
            else {
                drawMainMenu('login');
            }
        } else {
            console.log(data);
        }
    });
}
function polygonClick(el) {
    if (!$(el).hasClass('tileSelected')) {
        $('.hexagon').removeClass('tileSelected');
        $(el).addClass('tileSelected');
    }
}
function drawLoginWindow() {
    
    let loginForm = '<div class="logigWindow">'+
            '<input placeholder="Логин" class="loginWindowLogin" type="text">'+
            '<input placeholder="Пароль" class="loginWindowPassword" type="password">'+
            '<div class="button" onclick="login();">Войти</div>'+
          '</div>';
    let mainContainer = $('.mainMenuInnerMain');
    mainContainer.html(loginForm);
}

function drawMainMenu(type) {
    let text = '';
    let functionText = '';
    if (type == 'login') {
        text = 'Войдите';
        functionText = 'drawLoginWindow();';
    }
    else {
        text = 'Список серверов';
        functionText = 'getRoomList();';
    }
    let menuBlock = '<div class="mainMenuItem" onclick="' + functionText + '">' + text + '</div>';
    let menuContainer = $('.mainMenuInnerAside');
    menuContainer.html(menuBlock);
}

function login() {
    let login = $('.loginWindowLogin').val();
    let password = $('.loginWindowPassword').val();
    $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "client.class", class: "Client", method: "login", login: login, password: password
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            userName = data.data.userName;
            userId = data.data.userId;
            let menuContainer = $('.mainMenuInnerMain');
            menuContainer.html('');
            drawMainMenu();
        } else {
            console.log(data);
        }
    });
}

function getRoomList() {
     $.ajax({
        type: "POST",
        url: "../core/_ajaxListener.class.php",
        data: {classFile: "client.class", class: "Client", method: "getRoomList"
        }}).done(function (result) {
        var data = JSON.parse(result);
        if (data.result === "Ok") {
            drawRoomList(data.data);
        } else {
            console.log(data);
        }
    });
}

function drawRoomList(rooms) {
    let mainContainer = $('.mainMenuInnerMain');
    mainContainer.html('');
    Object.entries(rooms).forEach(function(el){
        drawRoom(el);
    });
}

function drawRoom(room) {
    let roomBlock = '<div class="room mainMenuItem" onclick="startGame(\'map\');">' + room[1].map + ' - ' + room[1].name + '</div>';
    let mainContainer = $('.mainMenuInnerMain');
    mainContainer.append(roomBlock);
}

function startGame(map) {
    page = 'game';
    getMap(map);
    getTypes();
    getUnits();
    getPlayers();
    closeMainMenu();
}

function closeMainMenu() {
    $('.mainMenu, .mainMenuBgr').hide();
}