var tileStrokeColor = "#b7b3b3";
var tileStrokeSize = 1.2;
var tileNumOfSides = 6;
var tileRadius = stage.options.mapData.user_map_tile_radius;

var user_map_width = stage.options.mapData.user_map_width;
var user_map_height = stage.options.mapData.user_map_height;
var user_tiles = stage.options.mapData.tiles;

var y_offset = tileRadius;

var dist = tileRadius * (Math.sqrt(3) / 2);

var isLeft = true;
var index = 0;

BuildingStatusEnum = {
    BUILDING_IN_PROGRESS: 1,
    OPERATIONAL: 2,
    NON_OPERATIONAL: 3,
    UPGRADE_IN_PROGRESS: 4,
    DEMOLITION_IN_PROGRESS: 5
}

for (var y = 0; y < user_map_height; y++) {
    for (var x = 0; x < user_map_width; x++) {
        x_offset = tileRadius + (y * 2 * dist);
        if (!isLeft) {
            x_offset = tileRadius + dist + (y * 2 * dist);
        }
        var myShape = new Polygon(0 + x_offset, 0 + y_offset, tileRadius, tileNumOfSides);
        myShape.stroke(tileStrokeColor, tileStrokeSize);
        myShape.addTo(stage);
        myShape.attr('fillImage', new Bitmap(getTileByType(user_tiles[index].tile_type_id)));
        myShape.tile_id = user_tiles[index].id;
        if (user_tiles[index].building_level_id) {
            var building = new Rect(-15 + x_offset, -20 + y_offset, 30, 30)
            building.attr('fillImage', new Bitmap(getBuildingByLevel(user_tiles[index].building_level_id)));
            building.tile_id = user_tiles[index].id;
            building.on("click", function () {
                stage.sendMessage('tile_click', {
                    id: this.tile_id
                });
            });
            building.addTo(stage);


            var uc = new Rect(-15 + x_offset, 15 + y_offset, 30, 30)
            switch (user_tiles[index].building_status_id) {
                case BuildingStatusEnum.BUILDING_IN_PROGRESS:
                    uc.attr('fillImage', new Bitmap('/images/buildings/under_construction.png'));
                    break;
                case BuildingStatusEnum.OPERATIONAL:
                    uc.attr('fillImage', new Bitmap('/images/buildings/operational.png'));
                    break;
                case BuildingStatusEnum.NON_OPERATIONAL:
                    uc.attr('fillImage', new Bitmap('/images/buildings/non_operational.png'));
                    break;
                case BuildingStatusEnum.UPGRADE_IN_PROGRESS:
                    uc.attr('fillImage', new Bitmap('/images/buildings/upgrade_in_progress.png'));
                    break;
                case BuildingStatusEnum.UPGRADE_IN_PROGRESS:
                    uc.attr('fillImage', new Bitmap('/images/buildings/upgrade_in_progress.png'));
                    break;
            }

            uc.tile_id = user_tiles[index].id;
            uc.on("click", function () {
                stage.sendMessage('tile_click', {
                    id: this.tile_id
                });
            });
            uc.addTo(stage);
        }




        myShape.on("click", function () {
            stage.sendMessage('tile_click', {
                id: this.tile_id
            });
        });

        myShape.on("mouseover mouseout", function (e) {
            this.attr({
                cursor: e.type == "mouseover" ? "pointer" : "inherit"
            });
        });


        y_offset += (1.5 * tileRadius);
        isLeft = !isLeft;
        index++;
    }
    y_offset = tileRadius;
}

function onClickListener(e) {
    alert(e);
}

function getTileByType(type_id) {
    switch (type_id) {
        case 1:
            return '/images/plain.png';
            break;
        case 2:
            return '/images/forest.png';
            break;
        case 3:
            return '/images/mountains.png';
            break;
        case 4:
            return '/images/hills.png';
            break;
        case 5:
            return '/images/water.png';
            break;
    }
}

function getBuildingByLevel(level) {
    return '/images/buildings/level_' + level + '.png';
}

