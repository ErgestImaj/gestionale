<table>
	<thead>
	<tr>
		<th>Ragione</th>
		<th>Email</th>
		<th>Tipo</th>
		<th>Codice Fiscale</th>
		<th>Codice Destionario</th>
		<th>Codice LRN</th>
		<th>Ordine Minimo</th>
		<th>Piva</th>
		<th>Telefono</th>
		<th>Fax</th>
		<th>PEC</th>
		<th>Sito</th>
		<th>Strutura Madre</th>
		<th>Nazione</th>
		<th>Citta</th>
		<th>Regione</th>
		<th>Provinca</th>
		<th>Cap</th>
		<th>Indirizzo</th>
		<th>Accreditamento MF</th>
		<th>Accreditamento LRN</th>
		<th>Accreditamento IIQ</th>
		<th>Accreditamento DILE</th>
		<th>Accreditamento MIUR</th>
		<th>Creato</th>
	</tr>
	</thead>
	<tbody>
	@forelse($structures as $structure)
		<tr>
			<td>{{ $structure->legal_name }}</td>
			<td>{{ $structure->email }}</td>
			<td>{{ $structure->type_name }}</td>
			<td>{{ $structure->tax_code }}</td>
			<td>{{ $structure->codice_destinatario }}</td>
			<td>{{ $structure->lrn }}</td>
			<td>{{ $structure->minimum_order }}</td>
			<td>{{ $structure->piva }}</td>
			<td>{{ $structure->phone }}</td>
			<td>{{ $structure->fax }}</td>
			<td>{{ $structure->pec }}</td>
			<td>{{ $structure->website }}</td>
			<td>{{ $structure->parent->legal_name ?? '-' }}</td>
			<td>{{ $structure->country->name ?? '-' }}</td>
			<td>{{ $structure->town->title ?? '-' }}</td>
			<td>{{ $structure->region->title ?? '-' }}</td>
			<td>{{ $structure->province->title ?? '-' }}</td>
			<td>{{ $structure->legal_zipcode}}</td>
			<td>{{ $structure->legal_address}}</td>
			<td>{{ $structure->status->status == 1 ? 'Si' : 'No'}}</td>
			<td>{{ $structure->status->status_lrn == 1 ? 'Si' : 'No'}}</td>
			<td>{{ $structure->status->status_iiq == 1 ? 'Si' : 'No'}}</td>
			<td>{{ $structure->status->status_dile == 1 ? 'Si' : 'No'}}</td>
			<td>{{ $structure->status->status_miur == 1 ? 'Si' : 'No'}}</td>
			<td>{{ format_date($structure->created)}}</td>
		</tr>
	@empty
		<tr><td>Nessun record found</td></tr>
	@endforelse
	</tbody>
</table>
