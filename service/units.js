var ImageUnit = require('./units/image.js');
var HtmlUnit = require('./units/html.js');

var Units = function() {
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
