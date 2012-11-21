var http = require('http');
var fs = require('fs');
var Engine = require('./engine.js');
var Units = require('./units.js');
var Statistics = require('./statistics.js');
var iframeTemplate = require('./iframe.js');

var regex = {
    section: /^\s*\[\s*([^\]]*)\s*\]\s*$/,
    param: /^\s*([\w\.\-\_]+)\s*=\s*(.*?)\s*$/,
    comment: /^\s*;.*$/
};

var parseConfig = function(data) {
    var value = {};
    var lines = data.split(/\r\n|\r|\n/);
    var section = null;

    lines.forEach(function(line) {
        if(regex.comment.test(line)) {
            return;
        } else if(regex.param.test(line)) {
            var match = line.match(regex.param);
            if(section){
                value[section][match[1]] = match[2];
            }else{
                value[match[1]] = match[2];
            }
        } else if(regex.section.test(line)) {
            var match = line.match(regex.section);
            value[match[1]] = {};
            section = match[1];
        } else if(line.length == 0 && section) {
            section = null;
        }
    });

    return value;
};

var settings = parseConfig(fs.readFileSync('../config/config', 'utf8'));
var serviceSettings = settings['Service Settings'];
var imageServerSettings = settings['Image Server'];
var engine = new Engine(settings);
var units = new Units(settings);
var statistics = new Statistics(settings, engine);

var notFound = function(res) {
    res.writeHead(404, {'Content-Type': 'text/html'});
    res.end(iframeTemplate.replace('{data}', ''));
};

var routers = [
    {'pattern': /\/show\/([a-zA-Z0-9.]+)/, 'controller': function(res, placementId) {
        var result = engine.getCodeAndName(placementId, imageServerSettings.imageServer);
        if(result) {
            res.writeHead(200, {
                'Content-Type': 'text/html',
                'Expires': 'Thu, 19 Nov 1981 08:52:00 GMT',
                'Cache-Control': 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Pragma': 'no-cache'
            });
            res.end(iframeTemplate.replace('{data}', result.code));
			statistics.updateShows(result.name);
        } else {
			res.writeHead(200, {
                'Content-Type': 'text/html',
                'Expires': 'Thu, 19 Nov 1981 08:52:00 GMT',
                'Cache-Control': 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Pragma': 'no-cache'
            });
            res.end();
        }
    }},
    {'pattern': /\/click\/([a-zA-Z0-9.]+)/, 'controller': function(res, unitId) {
        var result = engine.getLinkAndName(unitId);
        if(result) {
            res.writeHead(301, {'Location': result.link});
            res.end();
			statistics.updateClicks(result.name);
        } else {
            notFound(res);
        }
    }},
    {'pattern': /\/*/, 'controller': notFound}
];

http.createServer(function (req, res) {
    for(var i = 0, length = routers.length; i < length; i++ ) {
        var router = routers[i];
        var match = router.pattern.exec(req.url);
        if(match) {
            router.controller(res, match[1]);
            break;
        }
    }
}).listen(serviceSettings.port, serviceSettings.host);

console.log('Server running at ' + serviceSettings.host + ':' + serviceSettings.port);
