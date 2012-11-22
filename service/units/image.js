var CODE = '<a href="{url}" target="_blank" type="%s" style="display: block; text-align: center;"><img src="%s" alt="%s"/></a>';

var util = require('util');

var Image = function(data) {
    this.name = data.unit_name;
    this.title = data.title;
    this.weight = data.weight;
    this.link = data.link;
    this.imageUrl = data.image_url;
    this.image_type = data.image_type;
};

module.exports = Image;
Image.prototype.getCode = function(imageServer) {
    return util.format(CODE, this.name, (this.image_type == 'local' ? imageServer : '') + this.imageUrl, this.name);
};
