<table>
	<thead>
	<tr>
		<th>Nome</th>
		<th>Cognome</th>
		<th>Email</th>
		<th>Codice Fiscale</th>
		<th>Tipo</th>
		<th>Sesso</th>
		<th>Creato da</th>
		<th>Stato</th>
		<th>Creato</th>
		<th>Diploma</th>
		<th>Data diploma</th>
		<th>Istituto diploma</th>
		<th>Facoltà universitaria</th>
		<th>Laurea</th>
		<th>Data laurea</th>
		<th>Università</th>
		<th>Nazione</th>
		<th>Citta</th>
		<th>Regione</th>
		<th>Provinca</th>
		<th>Cap</th>
		<th>Indirizzo</th>
	</tr>
	</thead>
	<tbody>
	@forelse($users as $user)
		<tr>
			<td>{{ $user->firstname }}</td>
			<td>{{ $user->lastname}}</td>
			<td>{{$user->email }}</td>
			<td>{{$user->userInfo->fiscal_code ?? '-'}}</td>
			<td>{{$user->userInfo->types ?? '-'}}</td>
			<td>{{$user->userInfo->gender ?? '-'}}</td>
			<td>{{$user->user->lastname ?? '' }}</td>
			<td>{{ $user->state == 1 ? 'Attivo' : 'Non attivo'}}</td>
			<td>{{ format_date($user->created)}}</td>
			<td>{{$user->userInfo->high_school_diploma_name ?? '' }}</td>
			<td>{{$user->userInfo->high_school_diploma_date ?? '' }}</td>
			<td>{{$user->userInfo->high_school_diploma_institute ?? '' }}</td>
			<td>{{$user->userInfo->university_degree_faculty ?? '' }}</td>
			<td>{{$user->userInfo->university_degree_name ?? '' }}</td>
			<td>{{$user->userInfo->university_degree_date ?? '' }}</td>
			<td>{{$user->userInfo->university_degree_institute ?? '' }}</td>
			<td>{{$user->userInfo->userCountry->name ?? '' }}</td>
			<td>{{$user->userInfo->userTown->title ?? '' }}</td>
			<td>{{$user->userInfo->userRegion->title ?? '' }}</td>
			<td>{{$user->userInfo->userProv->title ?? '' }}</td>
			<td>{{$user->userInfo->zipcode ?? '' }}</td>
			<td>{{$user->userInfo->address ?? '' }}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
