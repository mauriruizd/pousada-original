<div style="width: 80%; margin: auto;">
    <h1>Alteração de Senha</h1>
    <div>
        <p>
            Você está recebendo esse email porque recebemos um pedido de restauração de senha.
        </p>
        <p>
            <a href="{{ url('password/reset', $this->token) }}" style="display: block; padding: 20px; background: #2d75b4; color: #fff;">Restaurar Senha</a>
        </p>
        <p>
            Se você não solicitou a restauração de sua senha, por favor ignore esta mensagem.
        </p>
    </div>
</div>