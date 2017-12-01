$(document).ready(function() {
    const consultaEndpoint = $('#consulta-endpoint').val();
    const dataEntrada = $('#data-entrada');
    const dataSaida = $('#data-saida');
    const quartosSelectContainer = $('#quartos-select-container');

    // Setup datepicker
    $('.datepick').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '+0m +0w',
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

    dataSaida.datepicker("option", "minDate", "+1d");

    dataEntrada.datepicker("option", "onSelect", function(date) {
        const selectedDate = new Date(date.split('/').reverse());
        var minDate = new Date(selectedDate);
        minDate.setDate(selectedDate.getDate() + 1);
        dataSaida.datepicker("option", "minDate", minDate);
        getQuartosDisponiveis();
    });

    dataSaida.on('change', function () {
        getQuartosDisponiveis();
    });

    getQuartosDisponiveis();

    function getQuartosDisponiveis() {
        console.log('test');
        if (dataSaida.val() !== '' && dataEntrada.val() !== '') {
            $.ajax({
                'url': consultaEndpoint,
                'method': 'get',
                'data': {
                    'dataentrada': dataEntrada.val(),
                    'datasaida': dataSaida.val()
                },
                success: function (res) {
                    console.log(res);
                    quartosSelectContainer.html('');
                    var idTipoQuarto;
                    var first = true;
                    for(idTipoQuarto in res) {
                        quartosSelectContainer.append("<h4>" + res[idTipoQuarto][0].tipo_quarto.nome + "</h4>");
                        res[idTipoQuarto].forEach(function (quarto) {
                            quartosSelectContainer.append(
                                "<div class='row'><label><input type='radio' name='id_quarto' value='" + quarto.id + "' " + (first ? 'checked' : '') + "> " + quarto.numero + "</label></div>"
                            );
                            if (first) first = false;
                        });
                    }
                }
            });
        }
    }

});