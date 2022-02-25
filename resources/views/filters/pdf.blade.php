<style>
    table{
        width:100%;
    }
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<table>
    <thead>
        <tr>
            <td>Filter Name</td>
            <td>Filter Type</td>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->filter_name }}</td>
            <td>{{ $item->filter_type }}</td>
        </tr>
        @endforeach
    </tbody>
</table>