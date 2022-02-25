<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  width:100%;
}
</style>
<table>
    <thead>
        <tr>
            <td>Model</td>
            <td>Type</td>
            <td>Year</td>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->model }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->year }}</td>
        </tr>
        @endforeach
    </tbody>
</table>