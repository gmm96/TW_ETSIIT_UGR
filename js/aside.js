// Cambia el border inferior de las capsulas del aside según si están abiertas o cerradas
$(document).ready(function(){

    $('#sections').on('hidden.bs.collapse', function () {
        $("#collapse1-heading").addClass("panel-heading-with-bottom-border");
    });
    $('#member').on('hidden.bs.collapse', function () {
        $("#collapse2-heading").addClass("panel-heading-with-bottom-border");
    });
    $('#admin').on('hidden.bs.collapse', function () {
        $("#collapse3-heading").addClass("panel-heading-with-bottom-border");
    });

    $('#sections').on('show.bs.collapse', function () {
        $("#collapse1-heading").removeClass("panel-heading-with-bottom-border");
    });
    $('#member').on('show.bs.collapse', function () {
        $("#collapse2-heading").removeClass("panel-heading-with-bottom-border");
    });
    $('#admin').on('show.bs.collapse', function () {
        $("#collapse3-heading").removeClass("panel-heading-with-bottom-border");
    });

});