(function() {
    const api = $('#consultar-estoque-endpoint').val();
    const produtoSelect = $('#produto-select');
    const quantidade = $('#quantidade');

    produtoSelect.on('change', function () {
        getEstoque();
    });

    function getEstoque() {
        quantidade.prop('disabled', true);
        $.ajax({
            url: api,
            method: 'GET',
            data: {
                id: produtoSelect.val()
            },
            success: function (qtd) {
                quantidade.val(1);
                quantidade.attr('max', qtd);
                quantidade.prop('disabled', false);
            }
        })
    }
    getEstoque();
})();