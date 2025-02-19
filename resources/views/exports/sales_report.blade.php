<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre cliente</th>
            <th>Identificación cliente</th>
            <th>Correo cliente</th>
            <th>Cantidad productos</th>
            <th>Monto total</th>
            <th>Fecha y hora</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale['code'] }}</td>
                <td>{{ $sale['customer_name'] }}</td>
                <td>{{ $sale['customer_id'] }}</td>
                <td>{{ $sale['customer_email'] }}</td>
                <td>{{ $sale['total_products'] }}</td>
                <td>{{ $sale['total_amount'] }}</td>
                <td>{{ $sale['sale_date'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
