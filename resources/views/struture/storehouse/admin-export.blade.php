<table>
	<thead>
	<tr>
		<th>Corso</th>
		<th>Acquistati</th>
		<th>Totale</th>
		<th>Admin</th>
	</tr>
	</thead>
	<tbody>
	@forelse($courses as $course)
		<tr>
			<td>{{ $course->name ?? 'Course Cancellato' }}</td>
			<td>{{ $course->aquisti }}</td>
			<td>{{ $course->total }}</td>
			<td>{{ $course->admin }}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
