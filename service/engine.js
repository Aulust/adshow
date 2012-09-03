var mysql = require('mysql');
var Placements = require('./placements.js');
var Units = require('./units.js');

var Engine = function(settings) {
    this.units = new Units();
    this.placements = new Placements();

    var dbSettings = settings['Database settings'];
    var serviceSettings = settings['Service Settings'];

    this.config = {
        host : dbSettings.dbhost,
        user : dbSettings.dbuser,
        password : dbSettings.dbpass,
        database: dbSettings.dbname,
        multipleStatements: true
    };
    this.connected = false;

    this.reconnect();

    setInterval(this.load.bind(this), serviceSettings.dbrefresh);
};

module.exports = Engine;

Engine.prototype.reconnect = function() {
    console.log('Something broke. Reconnect.');
    this.connected = false;
    this.connection = mysql.createConnection(this.config);
    this.connection.connect(function(err) {
        if(err) {
            setTimeout(this.reconnect.bind(this), 10000);
            return;
        }

        this.connected = true;
        console.log('Connected.');
        this.load();
    }.bind(this));
};

Engine.prototype.load = function() {
    if(!this.connected) return;

    this.connection.query('START TRANSACTION;' +
                          'SELECT * FROM unit WHERE status="active";' +
                          'SELECT * FROM bindings;' +
                          'COMMIT;', function(err, result) {
        if (err && err.fatal) {
            this.reconnect();
            return;
        }

        this.units.load(result[1]);
        this.placements.load(result[2], this.units);
    }.bind(this));
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
