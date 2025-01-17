<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório em PDF</title>
</head>
<body>
    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>DESCRIÇÃO</th>
                <th>TIPO</th>
                <th>CATEGORIA</th>
                <th>DATA</th>
                <th>VALOR(R$)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $item)
                <tr>
                    <td style="width:50px">{{ $item->id }}</td>
                    <td>{{ $item->nome_despesa }}</td>
                    <td>{{ $item->descricao }}</td>
                    <td style="{{$item->style}};text-align:center">{{ $item->tipo }}</td>
                    <td style="text-align:center">{{ $item->categoria }}</td>
                    <td style="width: 80px">{{ $item->data_br }}</td>
                    <td style="width: 80px;text-align:right">{{ $item->valor_br }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align:right;background-color: RGB(0,136,150);color:white " >Entradas: R${{$painel->total_valor_entrada}}</td>
                <td colspan="2" style="text-align:right" >Saídas: R${{$painel->total_valor_saida}}</td>
                <td colspan="3" style="text-align:right">Saldo:
                 <b style="color:{{$painel_css}}">R${{$painel->saldo}}</b>
                </td>
            </tr>
        </tfoot>



    </table>


</body>
<style>

.styled-table {
    width: 80%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    text-align: left;
    margin: auto;

}


.styled-table th {
    background-color: RGB(0,136,150);
    color: white;
    padding: 10px;
    text-align: center;
    align-items: center;
    border: solid 1px lightgrey;
}


.styled-table td {
    height: 20px !important;
    padding: 8px;
    border: 1px solid #ddd;
}


.styled-table tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.styled-table tr:nth-child(even) {
    background-color: #ffffff;
}


tfoot>td{

background-color: #4CAF50;
color:white;
}
td[colspan]{
    height: 50px;
    background-color: RGB(0,136,150);
    color:white;
}
</style>
</html>
