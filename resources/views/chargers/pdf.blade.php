<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<table>
    <thead>
        <tr>
            <td>Charger ID</td>
            <td>Location</td>
            <td>Usage Type</td>
            <td>Connector Type</td>
            <td>Operator</td>
            <td>Contact Telephone</td>
            <td>Cost</td>
            <td>Service Time</td>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->charger_id }}</td>
            <td>{{ $item->location }}</td>
            <td>{{ $item->usage_type }}</td>
            <td>{{ $item->connector_type }}</td>
            <td>{{ $item->operator }}</td>
            <td>{{ $item->contact_number }}</td>
            <td>{{ $item->cost }}</td>
            <td>{{ $item->service_time }}</td>
        </tr>
        @endforeach
    </tbody>
</table>