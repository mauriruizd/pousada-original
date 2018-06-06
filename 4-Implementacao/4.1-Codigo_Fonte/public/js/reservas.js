$(document).ready(function() {
    var boot = true;
    const consultaEndpoint = $('#consulta-endpoint').val();
    const consultaTiposPagamentosEndpoint = $('#consulta-tipos-pagamentos-endpoint').val();
    const dataEntrada = $('#data-entrada');
    const dataSaida = $('#data-saida');
    const quartosSelectContainer = $('#quartos-select-container');
    const tiposPagamentosContainer = $('#tipos-pagamentos-container');
    const fonteReservaSelect = $('#fonte-reserva');

    // Setup datepicker
    $('.datepick').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '+0m +0w',
        maxDate: '+18m',
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
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

    fonteReservaSelect.on('change', function () {
        getTiposPagamentos();
    });

    getQuartosDisponiveis();
    getTiposPagamentos();

    function getQuartosDisponiveis() {
        if (dataSaida.val() !== '' && dataEntrada.val() !== '') {
            $.ajax({
                'url': consultaEndpoint,
                'method': 'get',
                'data': {
                    'dataentrada': dataEntrada.val(),
                    'datasaida': dataSaida.val(),
                    'reservaId' : typeof reservaId !== 'undefined' ? reservaId : null
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
                                "<div class='row'><label><input id='quarto_" + quarto.id + "' type='radio' name='id_quarto' value='" + quarto.id + "' " + (first ? 'checked' : '') + "> " + quarto.numero + "</label></div>"
                            );
                            if (first) first = false;
                        });
                    }
                    if (boot) {
                        if (typeof savedNumeroQuarto !== 'undefined') {
                            $('#quarto_' + savedNumeroQuarto).prop('checked', true);
                        }
                        boot = false;
                    }
                }
            });
        }
    }

    function getTiposPagamentos() {
        $.ajax({
            'url': consultaTiposPagamentosEndpoint,
            'method': 'get',
            'data': {
                'fonte': fonteReservaSelect.val()
            },
            success: function (res) {
                console.log(res);
                tiposPagamentosContainer.html('');
                if (res.pagamento_vista) {
                    tiposPagamentosContainer.append('<div class="col-md-12"><label><input type="radio" name="tipo_pagamento" value="1"> Pagamento à vista</label></div>');
                }
                if (res.pagamento_parcelado) {
                    tiposPagamentosContainer.append('<div class="col-md-12"><label><input type="radio" name="tipo_pagamento" value="2"> Pagamento parcelado</label></div>');
                }
                tiposPagamentosContainer.children()[0].children[0].children[0].checked = true;
            }
        });
    }

});