<h3 align="center">Operational Report</h3>
<h3>Date from <strong>{{$dtfrom}}</strong> to <strong>{{$dtto}}</strong></h3>

<table class="table">
    <tr align="center">
        <th rowspan="2">No</th>
        <th rowspan="2">Toll Plaza</th>
        <th colspan="4">GOLONGAN</th>

        <th rowspan="2">Subtotal</th>
    </tr>

    <tr align="center">
        <th>GOL 1</th>
        <th>GOL 2</th>
        <th>GOL 3</th>
        <th>GOL 4</th>
    </tr>


    @php ($i=1)
        @foreach ($items as $key => $item)
            <tr align="center">
                <td>{{$i}}</td>
                <td>{{ $item->plaza_name }}</td>
                <td>{{ $item->p001 }}</td>
                <td>{{ $item->p002 }}</td>
                <td>{{ $item->p003 }}</td>
                <td>{{ $item->p004 }}</td>
                <td>{{ $item->subtotal }}</td>
                @php ($i++);
        @endforeach
</table>