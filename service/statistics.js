var Statistics = function(settings, engine) {
    this.units_stat = new Object();
    this.engine = engine;
    
    var serviceSettings = settings['Service Settings'];
    
    setInterval(this.uploadStat.bind(this), serviceSettings.statisticsRefresh);
};

module.exports = Statistics;

Statistics.prototype.updateShows = function(name) {
    if(!this.units_stat[name]) {
        this.units_stat[name] = {'shows':0, 'clicks':0};
    }
        this.units_stat[name].shows ++;
};

Statistics.prototype.updateClicks = function(name) {
    if(!this.units_stat[name]) {
        this.units_stat[name] = {'shows':0, 'clicks':0};
    }
        this.units_stat[name].clicks ++;
};

Statistics.prototype.uploadStat = function() {
    today = new Date();
    date = 'yyyy-MM-dd'.replace('yyyy', today.getFullYear()).replace('MM', today.getMonth()+1).replace('dd', today.getDate());
    
    var values = new Array();
    for (name in this.units_stat) {
        values[values.length] = '("' + name + '","' + date + '","' + this.units_stat[name].shows + '","' + this.units_stat[name].clicks + '")';
    }
    
    values = values.join();
    
    if(values != '') {
        query = 'INSERT INTO statistics (unit_name,date,shows,clicks) VALUES ' + values + ' ON DUPLICATE KEY UPDATE shows = shows + VALUES (shows), clicks = clicks + VALUES (clicks);';
        this.engine.connection.query('START TRANSACTION;' +
                                      query +
                                      'COMMIT;', function(err) {
            if (err) {
                return;
            }
        this.units_stat = new Object();
        }.bind(this));
    }
};


