$(document).ready(function() {
    // Setup elements
    const paisesFormElement = $('#paises');
    const estadosFormElement = $('#estados');
    const cidadesFormElement = $('#cidades');

    // Setup endpoints
    const estadosEndpoint = $('#estados-endpoint').val();
    const cidadesEndpoint = $('#cidades-endpoint').val();

    // Set paises change listener
    paisesFormElement.on('change', function() {
        showPreloader();
        // Get estados select with pais id
        getSelect($(this), estadosEndpoint, estadosFormElement, function() {
            getSelect(estadosFormElement, cidadesEndpoint, cidadesFormElement);
            hidePreloader();
        });
    });

    // Set estados change listener
    estadosFormElement.on('change', function() {
        showPreloader();
        getSelect($(this), cidadesEndpoint, cidadesFormElement, function () {
            hidePreloader();
        });
    });

    function getSelect(changedElement, endpoint, affectedElement, callback) {
        $.ajax({
            url : [endpoint, '/', changedElement.val()].join(''),
            method: 'GET',
            success: function(newList) {
                // Change estados select html
                affectedElement.html(newList);
                if (callback) {
                    // Excecute callback if present
                    callback();
                }
            },
            error: function(error) {
                console.log(error);
                alert('Houve um erro na atualização da lista! Detalhes do erro no log.');
            }
        });
    }

    // Setup datepicker
    $('#data-nascimento').datepicker({
        dateFormat: 'dd/mm/yy'
    });

    function showPreloader() {
        $('.preloader').show();
    }

    function hidePreloader() {
        $('.preloader').hide();
    }
});