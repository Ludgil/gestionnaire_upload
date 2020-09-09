Dropzone.prototype.defaultOptions.dictDefaultMessage = "Clique ou drag and drop un fichier pour l'upload";
Dropzone.prototype.defaultOptions.dictFallbackMessage = "Votre browser ne supporte pas le drag and drop.";
Dropzone.prototype.defaultOptions.dictFileTooBig = "Le fichier est trop gros ({{filesize}}MiB). Taille Maximum: {{maxFilesize}}MiB.";
Dropzone.prototype.defaultOptions.dictInvalidFileType = "Vous ne pouvez pas upload ce type de fichier.";
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "Vous ne pouvez pas upload plus de fichiers.";

function basename(path) {
  return path.replace(/\/+$/, "").replace( /.*\//, "" );
}
// recup la valeur de l'hidden input 
let onlyFile = [];
let counter_success = 1;
let counter_display = 0;
let file_count = 0;
let responseData ='';
let file_name = '';
//*********************PARAMETRE DROP ZONE**********************************************//
Dropzone.options.form = {
    uploadMultiple: true,
    autoProcessQueue: true,
    parallelUploads: 500,
    maxFiles: 500,
    maxFilesize: 5000,

    init: function() {

      this.on("error", function(file, response) {
          $('#error').html(response);
          $('#error').show();
      });
      
      // récupére le nom des fichiers apres le traitement de php
      let i = 0;
      this.on("success", function(file,response) { 
        $('#success').show();
        setTimeout(function(){
          $('#success').hide();
        },3000);
        // donne un id à chaque preview-element
        $(file.previewElement).attr("id", i );
        //récup la reponse
        responseData = response;
        file_name = responseData.split('"');
        // si file_name est plus grand que 3 cela veut dire qu'il y a plusieurs fichiers il faut donc incrémanter counter_succes par 2
        // sinon laisser counter success a 1 pour les fichiers unique 
        if(file_name.length > 3){
          onlyFile.push(file_name[counter_success]);
          counter_success+=2;
        }else{
          counter_success=1;
          onlyFile.push(file_name[counter_success]);
        }
        i++;
      });
  }
}


// ouvre le modal en lui donnant les valeurs de l'image correspondante 
$(document).on('click','.dz-preview',function(e){
  let id = e.target.parentNode.getAttribute("id");
  $('#nameFile').attr("value", basename(onlyFile[id]));
  $('.modal-title').text('Remarque pour '+ basename(onlyFile[id]));
  $('#ModalCenter').modal('show');
});

// en cliquant sur le bouton envoyer du modal pour la remarque envoyer les données vers record_note.php via ajax
$('#submit-modal').on("click",function() {
  let note = $('#note').val();
  let nameFile = $('#nameFile').val();
  $.ajax({
    url: "note.php",
    type: "POST",
    data: {
      note: note,
      name_file : nameFile
    },
    success: function() {
      // ferme le modal apres l'envoi 
      $('#ModalCenter').modal('hide');
      $('#note').val('');
   }
  });
 
});



$(document).ready(function() {
  //**********************PARAMETRE DATATABLES*****************************************/
  $('#table_id').DataTable({
    language :    
        {
            "sEmptyTable":     "Aucune donnée disponible dans le tableau",
            "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     "Afficher _MENU_ éléments",
            "sLoadingRecords": "Chargement...",
            "sProcessing":     "Traitement...",
            "sSearch":         "Rechercher :",
            "sZeroRecords":    "Aucun élément correspondant trouvé",
            "oPaginate": {
                "sFirst":    "Premier",
                "sLast":     "Dernier",
                "sNext":     "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
            },
            "select": {
                    "rows": {
                        "_": "%d lignes sélectionnées",
                        "0": "Aucune ligne sélectionnée",
                        "1": "1 ligne sélectionnée"
                    } 
            }
        },
        "columnDefs": [ 
          
            {
                "targets":[0,1,2],
                "orderable": false
            }
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        stateSave: true,
    }
    );

//  script pour selectionner ou deselectionner toute les checkbox en même temps 
  $('#select_all').click(function() {
    if ($(this).is(':checked')) {
        $('.select_one').prop('checked', true);
    } else {
        $('.select_one').prop('checked', false);
    }
  });


  // script pour supprimer les fichiers 
  let select_delete = '';
  $(document).on('click','.btn_delete', function(e) {
    let targ = $(e.target);
    select_delete = targ.data("value");
    $.ajax({
      url: "delete.php",
      type: "POST",
      data: {
        delete: select_delete
      },
      success: function() {
        //refresh la page apres la suppression
        location.reload();
     }
    });
  });


  
  
});





