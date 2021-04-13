//jQuery
$(document).ready(function (){
    //Recup de la div qui contient l'attribut data-prototype
    let $container = $('div#produit_ajouter_distributeurs');
    //Ajout d'un liens pour ajouter un distributeur
    let $addLink = $('<a href="#" id="add_distributeur" class="btn btn-outline-success">Ajouter un distributeur</a>')
    $container.append($addLink)
    //On ajoute un nouveau champ a chaque click sur le lien d'ajout
    $addLink.click(function (event){
        //Methode de entité Produits
        addDistributeur($container);
        //Supprime le comportement normal html
        event.preventDefault()
        return false
    })

    //On definit un index unique pour nommer les champs qu'on ajoute dynamiquement
    let index = $container.find(':input').length

    if(index != 0){
        //Pour chaque DistributeurType qui existe on ajoute un lien de supression
        $container.children('div').each(function (){
            addDeleteLink($(this))
        })
    }

    //La fonction qui ajoute un formulaire DistributeurType
    function addDistributeur($container){
        //Dans le contenu de attribut data-prototype on remplace
        // __name__label__  = label du champ
        //__name__ = numero du champs
        let $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Distributeur N°' + (index + 1)).replace(/__name__/g, index))

        //On ajoute au prototype un lien pour pouvoir supprimer le DistributeurType
        addDeleteLink($prototype)
        //On ajoute le prototype modifié a la finde la balise a la fin de la balise <div>
        $container.append($prototype)

        //Enfin on incremente le compteur pour que le prochain ajout ce fasse avec un autre numero
        index++;
        //La fonction qui ajoute le lien de supression d'un distributeur
        function addDeleteLink($prototype){
            //Creation du lien
            $deleteLink = $('<a href="#" class="btn btn-outline-danger">Supprimer</a>')
            //Ajout du liens
            $prototype.append($deleteLink)

            //Ajout de l'event listener au click du liens
            $deleteLink.click(function (event){
                $prototype.remove()
                event.preventDefault()
                return false
            })
        }
    }
})