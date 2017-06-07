var Tools = function (slate) {
    this.slate = slate;
    this.toolbar = this.slate.canvas.nextElementSibling;
    this.colorSelectors = this.toolbar.querySelectorAll('.pen-color');
    this.sizeSelector = this.toolbar.querySelector('.pen-size');
    this.clearButton = this.toolbar.querySelector('.clear');

    for (let colorSelector of this.colorSelectors) {
        colorSelector.addEventListener('click', this.changePenColor.bind(this));
    }
    this.sizeSelector.addEventListener('change', this.changePenSize.bind(this));
    this.clearButton.addEventListener('click', this.clear.bind(this));
};

Tools.prototype.changePenColor = function(e) {
    this.toolbar.querySelector('.active').classList.remove('active');
    this.slate.pen.setColor(e.target.dataset.color); // marche aussi avec e.currentTarget
    e.target.classList.add('active');
};
Tools.prototype.changePenSize = function(e) {
    this.slate.pen.setSize(e.target.value);
};
Tools.prototype.clear = function(e) {
    e.preventDefault();
    this.slate.pen.context.clearRect(0,0, this.slate.canvas.width, this.slate.canvas.height);
};
Tools.prototype.save = function(e) {
    e.preventDefault();
    this.saveButton.parentNode.setAttribute('href', this.slate.canvas.toDataURL());
    this.saveButton.parentNode.setAttribute('download', 'mondessin.png');
};
