var Pen = function (context) {
    // Attend en paramètre un context 2d (on se servira de celui de la classe Slate)
    this.context = context;
    this.color = '#000';
    this.size = 1;

    // Initialisation
    this.setColor(this.color);
    this.setSize(this.size);
};

Pen.prototype.setColor = function(color) {
    this.context.strokeStyle = color;
    this.color = color;
};

Pen.prototype.setSize = function(size) {
    this.context.lineWidth = size;
    this.size = size;
};
