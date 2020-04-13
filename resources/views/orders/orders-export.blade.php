<table>
	<thead>
	<tr>
		<th>Identificativo Ordine</th>
		<th>Struttura</th>
		<th>Acquisto</th>
		<th>Totale</th>
		<th>Tipologia ordine</th>
		<th>Metodo pagamento</th>
		<th>Data</th>
		<th>Stato</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($orders as $order)
		<tr>
			<td>{{$order->order_number }}</td>
			<td>{{$order->user->firstname ?? '' }}</td>
			<td>
				@if ($order->type == 1 && $order->paypalTransactions()->exists())
					{{$order->paypalTransactions->user_full_name ?? ''}}
				@else
					@foreach($order->orderItems as $item)
						{{$item->course->name ?? ''}} - ({{$item->qty}} X {{price_formater($item->price)}})<br>
					@endforeach
				@endif
			</td>
			<td>{{ price_formater($order->price)}}</td>
			<td>{{ $order->type_name}}</td>
			<td>{{ $order->payment_name}}</td>
			<td>{{ $order->order_date}}</td>
			<td>{{ $order->status_name}}</td>
			<td>{{ format_date($order->created)}}</td>
		</tr>
	@empty
		<tr>
			<td>Nessun record found</td>
		</tr>
	@endforelse
	</tbody>
</table>
