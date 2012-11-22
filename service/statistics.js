var Statistics = function(statisticsRefresh, engine) {
    this.units_stat = {};
    this.engine = engine;
    
    setInterval(this.uploadStat.bind(this), statisticsRefresh);
};

module.exports = Statistics;

Statistics.prototype.increaseShows = function(name) {
    this._update(name, 'shows');
};

Statistics.prototype.increaseClicks = function(name) {
    this._update(name, 'clicks');
};

Statistics.prototype._update = function(name, statistic) {
    if(!this.units_stat[name]) {
        this.units_stat[name] = {'shows':0, 'clicks':0};
    }
    this.units_stat[name][statistic]++;
}

Statistics.prototype.uploadStat = function() {
    var values = [];
    for (name in this.units_stat) {
        values.push('("' + name + '",NOW(),"' + this.units_stat[name].shows + '","' + this.units_stat[name].clicks + '")');
    }
    
    sqlValues = values.join();
    
    if(sqlValues != '') {
        query = 'INSERT INTO statistics (unit_name,date,shows,clicks) VALUES ' + sqlValues + ' ON DUPLICATE KEY UPDATE shows = shows + VALUES (shows), clicks = clicks + VALUES (clicks);';
        this.engine.connection.query(query, function(err) {
            if (err) {
                return;
            }
        this.units_stat = {};
        }.bind(this));
    }
};


