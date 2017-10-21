<style>
    table {
        width: 100%;
    }
    .underline {
        border-bottom: 1px solid #000;
    }
    .recepcionista {
        border: 1px solid #000;
    }
    .tessoura {
        height: 10px;
        border-bottom: 1px dotted #555;
    }
</style>
<table>
    <tbody>
    <tr>
        <td colspan="2">
            LOGO
        </td>
        <td colspan="4">
            Rua Xavier da Silva, 465 - Centro - CEP 85851-180 <br>
            Fone: +55 (45) 3027-2249 - Foz do Iguaçu - Paraná <br>
            Pousada-Quedas-Dágua <br>
            www.pousadaquedasdagua.com.br <br>
            pousadaquedasdagua@hotmail.com
        </td>
        <td colspan="4">
            Data Chegada: {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br>
            Horário Chegada: {{ \Carbon\Carbon::now()->format('H:i') }} <br>
            {{--N. Apto:_____ Pax:____--}}
        </td>
        <td colspan="2">
            FICHA DE HÓSPEDE
        </td>
    </tr>
    <tr>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td colspan="1">
            Nome:
        </td>
        <td colspan="7" class="underline">
            {{ $cliente->getNome() }}
        </td>
        <td colspan="1">Data de Nasc.:</td>
        <td colspan="3" class="underline">
            {{ $cliente->getDataNascimento() }}
        </td>
    </tr>
    <tr>
        <td colspan="1">Telefone</td>
        <td colspan="3" class="underline">
            {{ $cliente->getTelefone() }}
        </td>
        <td colspan="1">RG</td>
        <td colspan="3" class="underline">
            {{ $cliente->getRg() }}
        </td>
        <td colspan="1">CPF</td>
        <td colspan="3" class="underline">
            {{ $cliente->getCpf() }}
        </td>
    </tr>
    <tr>
        <td colspan="1">Endereco</td>
        <td colspan="11" class="underline">
            {{ $cliente->getEndereco() }}
        </td>
    </tr>
    <tr>
        <td colspan="1">Cidade</td>
        <td colspan="5" class="underline">
            {{ $cliente->getCidade()->getNome() }}
        </td>
        <td colspan="1">E-mail</td>
        <td colspan="5" class="underline">
            {{ $cliente->getEmail() }}
        </td>
    </tr>
    <tr>
        <td colspan="12"><hr></td>
    </tr>
    <tr>
        <td class="recepcionista" colspan="6">
            Nome do(a) recepcionista: {{ auth()->user()->getNome() }}
        </td>
        <td colspan="1">Assinatura do Responsável</td>
        <td colspan="5" class="underline"></td>
    </tr>
    <tr>
        <td colspan="12" class="tessoura"></td>
    </tr>
    </tbody>
</table>