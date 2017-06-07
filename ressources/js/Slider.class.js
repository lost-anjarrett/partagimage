var Slider = function(selector) {
	this.slider = $(selector);
	this.slides = this.slider.find('a');
	this.nbSlides = this.slides.length;
	this.activeSlide;
	this.onProcess = false;
	this.autoPlayIsActive = false;
	this.interval;
	this.controls;
	this.prevButton;
    this.nextButton;
    this.playButton;
    this.randomButton;
    this.pages;
	// Controls + Pagination
    this.setFirstSlide();
    this.generateControls();
	this.generatePagination();
	// CSS
	this.slider.css('width', this.activeSlide.find('img').css('width'));
	this.slider.css('height', this.activeSlide.find('img').css('height'));
	this.controls.css('width', this.activeSlide.find('img').css('width'));
	// Lancement à l'ouverture de la page
	this.autoPlay();

    /**
	 * ÉVÈNEMENTS
     */
	this.prevButton.click(this.gotoPrevSlide.bind(this));
	this.nextButton.click(this.gotoNextSlide.bind(this));
	this.playButton.click(this.autoPlay.bind(this));
	this.randomButton.click(this.randomSlide.bind(this));
	this.pages.click(this.clickOnPage.bind(this));
	this.slider.mouseenter(this.onMouseOver.bind(this));
	this.slider.mouseleave(this.onMouseLeave.bind(this));
};

Slider.prototype.setFirstSlide = function () {
	var firstSlideIndex = localStorage.getItem(this.slider.attr('id') + '_lastSlide') || 0;
    this.activeSlide = this.slides.eq(firstSlideIndex);
    this.activeSlide.css('display','block');
};

Slider.prototype.generateControls = function() {
    var controls = $('<div class="control">'+
		'<div class="pagination"></div>'+
			'<button class="prev"><i class="fa fa-backward"></i></button>'+
			'<button class="play"><i class="fa fa-play"></i></button>'+
			'<button class="next"><i class="fa fa-forward"></i></button>'+
			'<button class="random" title="Sélectionner une image aléatoire"><i class="fa fa-random"></i></button>'+
		'</div>');
    this.controls = controls;
    this.slider.after(this.controls);
    this.prevButton = this.controls.find('.prev');
    this.nextButton = this.controls.find('.next');
    this.playButton = this.controls.find('.play');
    this.randomButton = this.controls.find('.random');
};

Slider.prototype.generatePagination = function() {
	var pages = '';
	for (let i=1; i <= this.nbSlides; i++){
		pages += '<span>'+(i)+'</span>';
	}
	var pagination = $('<div class="pagination"></div>');
	pagination.html(pages);
    this.controls.append(pagination);
    this.pages = this.controls.find('.pagination span');
    this.updatePagination();
};

Slider.prototype.updatePagination = function() {
	this.pages.removeClass('active');
    this.pages.eq(this.activeSlide.index()).addClass('active');
};

Slider.prototype.gotoSlide = function(indexToGo) {
	if(!this.onProcess) {
        this.onProcess = true;
        this.activeSlide.fadeOut(1100);
        this.activeSlide = this.slides.eq(indexToGo);
        this.activeSlide.fadeIn(1100, function() {
            this.onProcess = false;
        }.bind(this));
        this.updatePagination();
        // Stockage dans le Local Storage
		window.localStorage.setItem(this.slider.attr('id') + '_lastSlide', indexToGo);
	}
};

Slider.prototype.gotoPrevSlide = function() {
	var indexToGo = this.activeSlide.index() - 1;
	if (indexToGo === -1) {
		indexToGo = this.nbSlides-1;
	}
	this.gotoSlide(indexToGo);
};

Slider.prototype.gotoNextSlide = function() {
	var indexToGo = this.activeSlide.index() + 1;
	if (indexToGo === this.nbSlides) {
		indexToGo = 0;
	}
	this.gotoSlide(indexToGo);
};

Slider.prototype.clickOnPage = function (event) {
	var indexToGo = $(event.target).index();
	if (indexToGo !== this.activeSlide.index()) {
		this.gotoSlide(indexToGo);
	}
};

Slider.prototype.autoPlay = function() {
	if (this.autoPlayIsActive) {
        this.autoPlayIsActive = false;
        this.stop();
        this.playButton.children().toggleClass('fa-play fa-stop');
    }
    else {
        this.autoPlayIsActive = true;
        this.play();
        this.playButton.children().toggleClass('fa-play fa-stop');
    }
};

Slider.prototype.play = function () {
	this.interval = setInterval(this.gotoNextSlide.bind(this), 2300);
};

Slider.prototype.stop = function() {
	clearInterval(this.interval);
};

Slider.prototype.onMouseOver = function() {
    if (this.autoPlayIsActive) {
        this.stop();
        this.playButton.children().toggleClass('fa-stop fa-pause');
    }
};

Slider.prototype.onMouseLeave = function() {
    if (this.autoPlayIsActive) {
        this.play();
        this.playButton.children().toggleClass('fa-stop fa-pause');
    }
};

Slider.prototype.randomSlide = function() {
    var indexToGo;
	do {
        indexToGo = rand(0, this.nbSlides - 1 );
	}
	while (indexToGo == this.activeSlide.index());
	this.gotoSlide(indexToGo);
};
