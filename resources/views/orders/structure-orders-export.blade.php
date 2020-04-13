<table>
	<thead>
	<tr>
		<th>Fatto richiesta</th>
		<th>Struttura madre</th>
		<th>Data</th>
		<th>Identificativo Ordine</th>
		<th>Dettaglio richiesta</th>
		<th>Totale</th>
		<th>Stato</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($orders as $order)
		<tr>
			<td>{{$order->structure->legal_name ?? '' }}</td>
			<td>{{$order->parentStructure->legal_name ?? '' }}</td>
			<td>{{$order->date}}</td>
			<td>{{$order->order_number}}</td>
			<td>
				@foreach($order->items as $item)
					{{$item->course->name ?? ''}} quantità:{{$item->qty}}<br>
				@endforeach
			</td>
			<td>{{ price_formater($order->price)}}</td>
			<td>{{ $order->status_name}}</td>
			<td>{{ format_date($order->created)}}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
