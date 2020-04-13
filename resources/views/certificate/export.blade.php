<table>
	<thead>
	<tr>
		<th>Centro</th>
		<th>Nominativo</th>
		<th>Codice utente</th>
		<th>Corso</th>
		<th>Tipo</th>
		<th>Data</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($certificates as $certificate)
		<tr>
			<td>{{$certificate->examSession->owner->firstname ?? '' }}</td>
			<td>{{$certificate->user->full_name ?? '' }}</td>
			<td>{{$certificate->user->username ?? '' }}</td>
			<td>{{$certificate->examSession->course->name ?? '' }}</td>
			<td>{{$certificate->type_name ?? '' }}</td>
			<td>{{format_date($certificate->examSession->date) ?? '' }}</td>
			<td>{{ format_date($certificate->created)}}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
