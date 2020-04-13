<table>
	<thead>
	<tr>
		<th>Codice</th>
		<th>Data stimata</th>
		<th>Struttura</th>
		<th>Sessione d'esame</th>
		<th>Certificati</th>
		<th>Data di invio</th>
		<th>Data di scadenza</th>
		<th>Stato</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($trackings as $tracking)
		<tr>
			<td>{{$tracking->code }}</td>
			<td>{{$tracking->estimate_date }}</td>
			<td>{{$tracking->structure->lastname ?? '' }}</td>
			<td>{{$tracking->lrnexam->course->name ?? '' }} - {{$tracking->lrnexam->date}}</td>
			<td>{{$tracking->nr_certificates }}</td>
			<td>{{$tracking->send_date }}</td>
			<td>{{$tracking->expiry_date}}</td>
			<td>{{$tracking->status_name}}</td>
			<td>{{ format_date($tracking->created)}}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
