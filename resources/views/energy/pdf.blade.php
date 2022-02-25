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
            <td>Company</td>
            <td>Country</td>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->company }}</td>
            <td>{{ $item->country }}</td>
        </tr>
        @endforeach
    </tbody>
</table>