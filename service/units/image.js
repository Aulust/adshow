var CODE = '<a href="{url}" target="_blank" type="%s" style="display: block; text-align: center;"><img src="%s" alt="%s"/></a>';

var util = require('util');

var Image = function(data) {
    this.name = data.unit_name;
    this.title = data.title;
    this.weight = data.weight;
    this.link = data.link;
    this.imageUrl = data.image_url;
};

module.exports = Image;
Image.prototype.getCode = function(imageServer) {
	if(this.imageUrl[0]=='/')
		return util.format(CODE, this.name, imageServer + this.imageUrl, this.name);
	else 
		return util.format(CODE, this.name, this.imageUrl, this.name);
};
