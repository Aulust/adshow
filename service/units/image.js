var CODE = '<a href="{url}" type="%s"><img src="%s" alt="%s"/></a>';

var util = require('util');

var Image = function(data) {
    this.name = data.unit_name;
    this.title = data.title;
    this.weight = data.weight;
    this.link = data.link;
    this.imageUrl = data.image_url;
};

module.exports = Image;

Image.prototype.getCode = function() {
    return util.format(CODE, this.name, this.imageUrl, this.name);
};
