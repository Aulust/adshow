var Placements = function(banners) {
    this.banners = banners;
    this.placements = {};
};

module.exports = new Placements();

Placements.prototype.getBanner(placementId) {
    return this.placements[placementId][0];
};

Placements.prototype.load(data) {
    this.placements = {};

    var data = {
        'd': [1, 2, 3],
        '1': [5, 1, 2]
    };

    for(placementId in data) {
        this.placements[placementId] = [];
        data[placementId].forEach(function(bannerId) {
            var banner = this.banners.getBanner(bannerId)
            if(banner) {
                this.placements[placementId].push(banner);
            }
        }, this);
    }
};
