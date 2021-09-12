$(document).ready(function () {
    datatable();
});

/* datatable */
function datatable() {
    let datatable = $('#table').DataTable({
        "language": {
            "search": "Rechercher",
            "lengthMenu": "Afficher _MENU_ enregistrements par page",
            "zeroRecords": "Aucune correspondance",
            "info": "Affichage page _PAGE_ de _PAGES_",
            "infoEmpty": "Aucune correspondance disponible",
            "infoFiltered": "(filté de _MAX_ enregistrements)",
            "paginate": {
                "previous": "<span><i class='fas fa-arrow-alt-circle-left arrow-left'></i></span>",
                "next": "<span><i class='fas fa-arrow-alt-circle-right arrow-right'></i></span>"
            }
        }
    });

    let datatable_search = $(".research");
    datatable_search.on("input",function(){
        datatable.search($(this).val()).draw();
    });
}