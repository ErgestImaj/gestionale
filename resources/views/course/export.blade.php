<table>
	<thead>
	<tr>
		<th>Codice corso</th>
		<th>Categoria</th>
		<th>Nome</th>
		<th>Costo</th>
		<th>Descrizione</th>
		<th>A chi è rivolto</th>
		<th>Descrizione programma</th>
		<th>Ordine min partner</th>
		<th>Ordine min master</th>
		<th>Ordine min affiliate</th>
		<th>Aliquota</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($courses as $course)
		<tr>
			<td>{{$course->code}}</td>
			<td>{{$course->category->name ?? ''}}</td>
			<td>{{$course->name}}</td>
			<td>{{price_formater($course->price)}}</td>
			<td>{{$course->description}}</td>
			<td>{{$course->skills}}</td>
			<td>{{$course->program_description}}</td>
			<td>{{$course->min_order_partner}}</td>
			<td>{{$course->min_order_master}}</td>
			<td>{{$course->min_order_affiliate}}</td>
			<td>{{$course->vatRate->name ?? ''}}- {{$course->vatRate->value ?? ''}}</td>
			<td>{{ format_date($course->created)}}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
