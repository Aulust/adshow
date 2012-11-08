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
this.load();
    setInterval(this.load.bind(this), serviceSettings.dbrefresh);
};

module.exports = Engine;

Engine.prototype.reconnect = function() {
    console.log('Something broke. Reconnect.');
    this.connected = false;
    this.connection = mysql.createClient(this.config);

        this.connected = true;
        console.log('Connected.');

};

Engine.prototype.load = function() {
    if(!this.connected) return;

    this.connection.query('START TRANSACTION;', function(err, result) {
        if (err && err.fatal) {
            this.reconnect();
            return;
        }
    }.bind(this));	
	today=new Date();
	nowDate=today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate()
    this.connection.query('UPDATE `unit` SET `status`="delete" WHERE (`clicks`>=`clicks_limit` AND `clicks_limit`>0) OR (`shows`>=`views_limit` AND `views_limit`>0) OR (`time_limit`<"'+nowDate+'" AND `time_limit`<>"0000-00-00");', function(err, result) {
        if (err && err.fatal) {
            this.reconnect();
            return;
        }
    }.bind(this));	

    this.connection.query('SELECT * FROM unit WHERE status="active" AND ((views_limit>0 AND views_limit>shows) OR views_limit=0) AND ((clicks_limit>0 AND clicks_limit>clicks) OR clicks_limit=0);', function(err, result) {
        if (err && err.fatal) {
            this.reconnect();
            return;
        }
		this.units.load(result);
    }.bind(this));	
	
    this.connection.query('SELECT * FROM bindings;', function(err, result) {
        if (err && err.fatal) {
            this.reconnect();
            return;
        }
		this.placements.load(result, this.units);
    }.bind(this));	
	
    this.connection.query('COMMIT;', function(err, result) {
        if (err && err.fatal) {
            this.reconnect();
            return;
        }
    }.bind(this));	
	
};

Engine.prototype.getCode = function(placementId) {
    var unit = this.placements.getUnit(placementId);
    if(unit) {
        return ([unit.getCode().replace('{url}', '/click/' + unit.name + '?'+Math.floor(Math.random()*(10000))),unit.name]);
    }
};

Engine.prototype.getLink = function(unitId) {
    var unit = this.units.getUnit(unitId);
    if(unit) {
        return [unit.link,unit.name];
    }
};
