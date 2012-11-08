var http = require('http');
var fs = require('fs');
var imageServer='http://adshow.local';
var Engine = require('./engine.js');
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
var engine = new Engine(settings);

var notFound = function(res) {
    res.writeHead(404, {'Content-Type': 'text/html'});
    res.end(iframeTemplate.replace('{data}', ''));
};

var showDefaultImage = function(res) {
	var defaultImage='<img src="'+imageServer+'/img/defaultimage.jpg" alt="sc2tv.ru"/>';
	res.writeHead(200, {
	'Content-Type': 'text/html'
	});
	res.end(iframeTemplate.replace('{data}', defaultImage));
};

var routers = [
    {'pattern': /\/show\/([a-zA-Z0-9.]+)/, 'controller': function(res, placementId) {
        var result = engine.getCode(placementId);
        if(result) {
            res.writeHead(200, {
                'Content-Type': 'text/html'
            });
            res.end(iframeTemplate.replace('{data}', result[0]));
			engine.connection.query("UPDATE `unit` SET `shows`=`shows`+1 WHERE `unit_name`='"+result[1]+"'");
        } else {
            showDefaultImage(res);
        }
    }},
    {'pattern': /\/click\/([a-zA-Z0-9.]+)/, 'controller': function(res, unitId) {
        var result = engine.getLink(unitId);
        if(result) {
            res.writeHead(301, {'Location': result[0]});
            res.end();
			engine.connection.query("UPDATE `unit` SET `clicks`=`clicks`+1 WHERE `unit_name`='"+result[1]+"'");
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
