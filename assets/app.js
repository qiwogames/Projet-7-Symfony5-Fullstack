/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

//Jquery
const $ = require('jquery')

// start the Stimulus application
import './bootstrap';

//Afficher le nom de l'image dans le formulaire
$(".custom-file-input").on("change", function (){
    let fileName = $(this).val().split("\\").pop()
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName)
})
