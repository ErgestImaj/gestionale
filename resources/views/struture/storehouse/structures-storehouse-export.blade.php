<style>
	.tbl {background-color:#000;}
	.tbl td,th,caption{background-color:red}
</style>
<table cellspacing="1" class="tbl">
	<thead>
	<tr>
		<th>Corso</th>
		<th>Acquistati</th>
		<th>Assegnati</th>
		<th>Distribuiti</th>
		<th>Disponibili</th>
		<th>Amministrazione</th>
	</tr>
	</thead>
	<tbody>
	@if($isSingle)
		<tr><td colspan="6">{{ $structures->legal_name }}</td></tr>
		@forelse($structures->courses as $course)
			<tr>
				<td class="td-coursename">{{$course->name}}</td>
				<td class="text-center {{$course->purchased_qty > 0 ? 'gnr' : ''}}">{{$course->purchased_qty}}</td>
				<td class="text-center {{$course->assigned_qty > 0 ? 'gnr' : ''}}">{{$course->assigned_qty}}</td>
				<td class="text-center {{$course->distributed_qty > 0 ? 'gnr' : ''}}">{{$course->distributed_qty}}</td>
				<td class="text-center {{$course->available_qty > 0 ? 'gnr' : ''}}">{{$course->available_qty}}</td>
				<td class="text-center {{$course->admin_qty > 0 ? 'gnr' : ''}}">{{$course->admin_qty}}</td>
			</tr>
		@empty
			<tr>
				<td>Nessun corso da visualizzare</td>
			</tr>
		@endforelse
	@else
		@forelse ($structures as $structure)
			<tr><td colspan="6">{{ $structure->legal_name }}</td></tr>
			@forelse($structure->courses as $course)
				<tr>
					<td class="td-coursename">{{$course->name}}</td>
					<td class="text-center {{$course->purchased_qty > 0 ? 'gnr' : ''}}">{{$course->purchased_qty}}</td>
					<td class="text-center {{$course->assigned_qty > 0 ? 'gnr' : ''}}">{{$course->assigned_qty}}</td>
					<td class="text-center {{$course->distributed_qty > 0 ? 'gnr' : ''}}">{{$course->distributed_qty}}</td>
					<td class="text-center {{$course->available_qty > 0 ? 'gnr' : ''}}">{{$course->available_qty}}</td>
					<td class="text-center {{$course->admin_qty > 0 ? 'gnr' : ''}}">{{$course->admin_qty}}</td>
				</tr>
			@empty
				<tr>
					<td>Nessun corso da visualizzare</td>
				</tr>
			@endforelse
		@empty
			<tr>
				<td>Nessun struttura da visualizzare</td>
			</tr>
		@endforelse
	@endif
	</tbody>
</table>
