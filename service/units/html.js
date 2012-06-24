var Html = function(data) {
    this.name = data.unit_name;
    this.title = data.title;
    this.weight = data.weight;
    this.link = data.link;
    this.html = data.html;
};

module.exports = Html;

Html.prototype.getCode = function() {
    return this.html;
};
