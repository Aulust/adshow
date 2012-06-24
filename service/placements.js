var Placements = function() {
};

module.exports = Placements;

Placements.prototype.getUnit = function(placementId) {
    var placement = this.placements[placementId];
    var result = null;

    if(placement) {
        var sum = Math.floor(Math.random() * placement.sum) + 1;

        for(var i=0; i < placement.units.length; i++) {
            sum -= placement.units[i].weight;
            if(sum <= 0) {
                result = placement.units[i];
                break;
            }
        }
    }

    return result;
};

Placements.prototype.load = function(data, units) {
    this.placements = {};

    data.forEach(function(binding) {
        var unit = units.getUnit(binding.unit_name);
        if(unit) {
            var placement = this.placements[binding.placement_name];
            if(!placement) {
                placement = { units: [], sum: 0 };
                this.placements[binding.placement_name] = placement;
            }
            placement.units.push(unit);
            placement.sum += unit.weight;
        }
    }, this);
};
