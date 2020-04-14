<table>
	<thead>
	<tr>
		<th>Identificativo Ordine</th>
		<th>Struttura</th>
		<th>Sessione d'esame</th>
		<th>Totale</th>
		<th>Metodo pagamento</th>
		<th>Data</th>
		<th>Stato</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($fasttracks as $fast)
		<tr>
			<td>{{$fast->order_number }}</td>
			<td>{{$fast->user->firstname ?? '' }}</td>
			<td>
				@foreach($fast->order_items as $order)
					{{@$order->course->name ?? ''}} - {{@$order->date}} ({{@$order->participants_count}}X{{price_formater($fast->general_price)}})<br>
				@endforeach
			</td>
			<td>{{ price_formater($fast->price)}}</td>
			<td>{{ $fast->payment_name}}</td>
			<td>{{ $fast->order_date}}</td>
			<td>{{ $fast->state_name}}</td>
			<td>{{ format_date($fast->created)}}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
