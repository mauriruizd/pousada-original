$(document).ready(function() {
    const consultaEndpoint = $('#consulta-endpoint').val();
    const dataEntrada = $('#data-entrada');
    const dataSaida = $('#data-saida');
    const quartosSelectContainer = $('#quartos-select-container');

    // Setup datepicker
    $('.datepick').datepicker({
        dateFormat: 'dd/mm/yy'
    });

    dataEntrada.on('blur', function () {
        getQuartosDisponiveis();
    });

    dataSaida.on('blur', function () {
        getQuartosDisponiveis();
    });

    function getQuartosDisponiveis() {
        if (dataSaida.val() !== '' && dataEntrada.val() !== '') {
            $.ajax({
                'url': consultaEndpoint,
                'method': 'get',
                'data': {
                    'dataentrada': dataEntrada.val(),
                    'datasaida': dataSaida.val()
                },
                success: function (res) {
                    quartosSelectContainer.html(res);
                }
            });
        }
    }

});