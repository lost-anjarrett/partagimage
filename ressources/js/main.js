$(function(){

    // Comme main.js est appelé dans toutes les pages il faut vérifier que l'élément est présent sur la page avant d'agir dessus sinon ça va bloquer le script
    if ($('#slate').length !== 0) {

        var slate = new Slate('#slate');

        $('#drawingForm').submit(function(){
            $(this).find('[name="drawing"]').val(slate.canvas.toDataURL());
            // Permet de stocker les données du canvas dans un champs de formulaire caché
        });

    	// ressources/js/main.js

    	 if($('#drawingForm').find('[name="drawing_src"]').length !== 0){
    		 var baseImg = new Image();
             var context = document.getElementById('slate').getContext('2d');  // On récupère le context du canvas

    		 baseImg.src = $('#drawingForm').find('[name="drawing_src"]').val();

    		 baseImg.onload = function(){  // Une fois l'image entièrement chargée on l'injecte dans le canvas:

    		context.drawImage(baseImg, 0, 0);

    		}
    	}
    }



    // Slider
    if ($('#homeSlider').length !== 0) {
        var slider = new Slider('#homeSlider');
    }

    // Confirme la suppression d'un post
    $('.post-delete').submit(function() {
        return confirm('Etes-vous sûr de vouloir supprimer ce post ?');
    });

    // Ratings
    if ($('.percent-form').length !== 0) {
        var ratings = rate('.percent-form');
    }


});
