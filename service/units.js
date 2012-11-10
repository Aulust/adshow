var ImageUnit = require('./units/image.js');
var HtmlUnit = require('./units/html.js');

var Units = function() {
    this.units = {};
};

module.exports = Units;

Units.prototype.getUnit = function(unitId) {
    if(this.units[unitId]) {
        return this.units[unitId];
    }
    return null;
};

Units.prototype.load = function(data) {
    this.units = {};

    console.log('Reload units:');
    console.log(data);

    var types = {
        'image': ImageUnit,
        'html': HtmlUnit
    };

    data.forEach(function(unit) {
        var type = unit.type;
        if(types[type]) {
            this.units[unit.unit_name] = new types[type](unit);
        }
    }, this);
};

Units.prototype.updateShows = function(name, engine) {
	engine.connection.query("UPDATE `unit` SET `shows`=`shows`+1 WHERE `unit_name`='"+name+"'");
};

Units.prototype.updateClicks = function(name, engine) {
	engine.connection.query("UPDATE `unit` SET `clicks`=`clicks`+1 WHERE `unit_name`='"+name+"'");
};

Units.prototype.deleteOverLimit = function(engine) {
	today=new Date();
	nowDate=today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()
    engine.connection.query('UPDATE `unit` SET `status`="delete" WHERE (`clicks`>=`clicks_limit` AND `clicks_limit`>0) OR (`shows`>=`views_limit` AND `views_limit`>0) OR (`time_limit`<"'+nowDate+'" AND `time_limit`<>"0000-00-00");', function(err, result) {
        if (err) {
			console.log(err.message)
            return false;
        }
    }.bind(engine));
	return true;
};
