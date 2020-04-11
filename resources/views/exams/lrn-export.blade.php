<table>
	<thead>
	<tr>
		<th>Struttura</th>
		<th>Titolo Corso</th>
		<th>Sede</th>
		<th>Candidati</th>
		<th>Data</th>
		<th>Examiner</th>
		<th>Invigilator</th>
		<th>Inspettore</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($exams as $exam)
		<tr>
			<td>{{ $exam->owner->structure->legal_name ?? '' }}</td>
			<td>{{ $exam->course->name ?? '' }} - {{format_date($exam->date)}}</td>
			<td>{{ $exam->location }}</td>
			<td>@foreach($exam->participants as $student){{$student->full_name}}<br/>@endforeach</td>
			<td>{{format_date($exam->date)}}</td>
			<td>{{ $exam->examiner->full_name ?? '' }}</td>
			<td>{{ $exam->invigilator->full_name ?? '' }}</td>
			<td>{{  $exam->investigator->full_name ?? '' }}</td>
			<td>{{ format_date($exam->created)}}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
