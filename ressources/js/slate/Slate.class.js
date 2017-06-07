var Slate = function (selector) {
    this.canvas = document.querySelector(selector);
    this.isDrawing = false;
    this.pen = new Pen(this.canvas.getContext('2d'));
    this.tools = new Tools(this);
    this.marginLeft = this.canvas.getBoundingClientRect().left;
    this.marginTop = this.canvas.getBoundingClientRect().top;

    // Début
    this.canvas.addEventListener('mousedown', this.onMouseDown.bind(this));
    // Dessin
    this.canvas.addEventListener('mousemove', this.onMouseMove.bind(this));
    // Fin
    this.canvas.addEventListener('mouseleave', this.stopDrawing.bind(this));
    this.canvas.addEventListener('mouseup', this.stopDrawing.bind(this));
    // Resize
    window.addEventListener('resize', this.updateCanvasPosition.bind(this));
};

Slate.prototype.getMouseLocation = function (e) {
    var mouseX = e.clientX;
    var mouseY = e.clientY;
    return {
        X: mouseX-this.marginLeft,
        Y: mouseY-this.marginTop
    };
};

Slate.prototype.onMouseDown = function (e) {
    this.isDrawing = true;
    var startLocation = this.getMouseLocation(e);
    this.pen.context.beginPath();
    this.pen.context.moveTo(startLocation.X, startLocation.Y);
};

Slate.prototype.stopDrawing = function () {
    this.isDrawing = false;
    this.pen.context.closePath();
};

Slate.prototype.onMouseMove = function (e) {
    if (this.isDrawing) {
        var location = this.getMouseLocation(e);
        this.pen.context.lineTo(location.X, location.Y);
        this.pen.context.stroke();
    }
};

Slate.prototype.updateCanvasPosition = function () {
    this.marginLeft = this.canvas.getBoundingClientRect().left;
    this.marginTop = this.canvas.getBoundingClientRect().top;
};

