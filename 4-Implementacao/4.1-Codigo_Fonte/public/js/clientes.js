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
        console.log(this.value);
        localStorage.setItem('lastEstado', this.value);
        showPreloader();
        getSelect($(this), cidadesEndpoint, cidadesFormElement, function () {
            hidePreloader();
        });
    });

    cidadesFormElement.on('change', function() {
        localStorage.setItem('lastCidade', this.value);
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
        dateFormat: 'dd/mm/yy',
        maxDate: '+0m +0w',
        changeMonth: true,
        changeYear: true,
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });

    function showPreloader() {
        $('.preloader').show();
    }

    function hidePreloader() {
        $('.preloader').hide();
    }

    function boot() {
        const lastEstado = localStorage.getItem('lastEstado');
        const lastCidade = localStorage.getItem('lastCidade');
        if (lastEstado) {
            getSelect(paisesFormElement, estadosEndpoint, estadosFormElement, function () {
                estadosFormElement.val(lastEstado);
                getSelect(estadosFormElement, cidadesEndpoint, cidadesFormElement, function () {
                    cidadesFormElement.val(lastCidade);
                    hidePreloader();
                    localStorage.removeItem('lastEstado');
                    localStorage.removeItem('lastCidade');
                });
            });
        }
        localStorage.removeItem('lastEstado');
        localStorage.removeItem('lastCidade');
    }

    boot();
});