var mysql = require('mysql');
var Placements = require('./placements.js');
var Units = require('./units.js');

var Engine = function(settings) {
    this.units = new Units();
    this.placements = new Placements();

    var dbSettings = settings['Database settings'];
    var serviceSettings = settings['Service Settings'];

    this.connection = mysql.createConnection({
        host : dbSettings.dbhost,
        user : dbSettings.dbuser,
        password : dbSettings.dbpass,
        database: dbSettings.dbname,
        multipleStatements: true
    });

    this.connection.connect();

    this.load();

    var self = this;
    setInterval(function() { self.load(); }, serviceSettings.dbrefresh, this);
};

module.exports = Engine;

Engine.prototype.load = function() {
    var self = this;

    this.connection.query('START TRANSACTION;' +
                          'SELECT * FROM unit WHERE status="active";' +
                          'SELECT * FROM bindings;' +
                          'COMMIT;', function(err, result) {
        if (err) throw err;

        self.units.load(result[1]);
        self.placements.load(result[2], self.units);
    });
};

Engine.prototype.getCode = function(placementId) {
    var unit = this.placements.getUnit(placementId);

    if(unit) {
        return unit.getCode().replace('{url}', '/click/' + unit.name);
    }
};

Engine.prototype.getLink = function(unitId) {
    var unit = this.units.getUnit(unitId);

    if(unit) {
        return unit.link;
    }
};
