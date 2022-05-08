/*let xDelta = 295;
    let yDelta = 340;
    let top = yDelta * y;
    let left = xDelta * x;
    if (x % 2 == 1) {
        top = top + yDelta / 2;
    }

    let polygon = $(document.createElementNS("http://www.w3.org/2000/svg", 'polygon'))
    .addClass('tilePolygon')
    .addClass('tile' + type)
    .attr({
        'id': "tile_" + id,
        'data-name': "tile_" + id,
        'data-id': id,
        'points': (295.15 + left) + " " + (1 + top) + " " + (99.15 + left) + " " + (1 + top) + " " + (1.15 + left) + " " + (171 + top) + "  " + (99.15 + left) + " " + (341 + top) + " " + (295.15 + left) + " " + (341 + top) + " " + (393.15 + left) + " " + (171 + top) + " " + (295.15 + left) + " " + (1 + top)
    });

    let circle = $(document.createElementNS("http://www.w3.org/2000/svg", 'circle'))
    .addClass('tileUnit')
    .attr({
        'id': "circle_" + id,
        'cx': 197.15 + left,
        'cy': 171 + top,
        'r': 90.54
    });*/

    //$('.map').append(polygon);
    //$('.map').append(circle);
    //$('#tile_' + id).css('top', top + 'px');
    //$('#tile_' + id).css('left', left + 'px');


    //let svg = '<svg class="map" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5998 6971" width="5998" height="6971"><polygon  id="tile_3" data-id="3" data-name="tile_3"  onclick="polygonClick(this)" class="tilePolygon tile3" points="295.15 1 99.15 1 1.15 171 99.15 341 295.15 341 393.15 171 295.15 1"/></svg>';
    //$('.mainArea').html(svg);


    /*var defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
        $('.map').append(defs);
        var pattern = document.createElementNS('http://www.w3.org/2000/svg','pattern');
        pattern.id = "unit" + el.id;
        pattern.setAttributeNS(null,'height','200');
        pattern.setAttributeNS(null,'y', '240');
        pattern.setAttributeNS(null,'x', '-10');
        pattern.setAttributeNS(null,'width','200');
        pattern.setAttributeNS(null,'patternUnits','userSpaceOnUse');
        defs.append(pattern);
        var svgimg = document.createElementNS('http://www.w3.org/2000/svg','image');
        svgimg.setAttributeNS(null,'height','200');
        svgimg.setAttributeNS(null,'width','200');
        svgimg.setAttributeNS(null,'preserveAspectRatio','xMidYMid meet');
        svgimg.setAttributeNS('http://www.w3.org/1999/xlink','href', '../media/players/' + el.player + '.jpg');
        svgimg.setAttributeNS(null, 'visibility', 'visible');
        pattern.append(svgimg);
        $('#circle_' + el.tile).addClass('active');
        $('#circle_' + el.tile).addClass('player_' + el.player);
        $('#circle_' + el.tile).css('fill', "url(#unit" + el.id + ")");
        $('#circle_' + el.tile).attr('data-id', el.id);
        $('#circle_' + el.tile).attr('player-id', el.player);*/


        //$('circle[player-id="' + userId + '"]').click();