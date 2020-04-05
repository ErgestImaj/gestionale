<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mediaform invoice</title>

	<style>
		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 30px;
			border: 1px solid #eee;
			box-shadow: 0 0 10px rgba(0, 0, 0, .15);
			font-size: 16px;
			line-height: 24px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #555;
		}

		.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
		}

		.invoice-box table td {
			padding: 5px;
			vertical-align: top;
		}

		.invoice-box table tr td:nth-child(2) {
			text-align: right;
		}

		.invoice-box table tr.top table td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
		}

		.invoice-box table tr.information table td {
			padding-bottom: 40px;
		}

		.invoice-box table tr.heading td {
			background: #388E3C;
			border-bottom: 1px solid #ddd;
			font-weight: bold;
			color:white;
		}

		.invoice-box table tr.details td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.item td{
			border-bottom: 1px solid #eee;
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:nth-child(2) {
			border-top: 2px solid #eee;
			font-weight: bold;
		}

		@media only screen and (max-width: 600px) {
			.invoice-box table tr.top table td {
				width: 100%;
				display: block;
				text-align: center;
			}

			.invoice-box table tr.information table td {
				width: 100%;
				display: block;
				text-align: center;
			}
		}

	</style>
</head>

<body>
<div class="invoice-box">
	<table cellpadding="0" cellspacing="0">
		<tr class="top">
			<td colspan="2">
				<table>
					<tr>
						<td class="title">
							<img src="{{asset('images/logo.png')}}" style="width:100%; min-width:300px;">
						</td>

						<td>
							Fattura #: {{$order->order_number}}<br>
							Creato: {{format_date($order->order_date)}}<br>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr class="information">
			<td colspan="2">
				<table>
					<tr>
						<td>
							{{$config['cart_intestazione']}}<br>
							P.IVA: {{$config['invoice_mediaform_piva']}}<br>
							CF: {{$config['invoice_mediaform_cf']}}<br>
							TEL: {{$config['invoice_mediaform_tel']}}<br>
							EMAIL: {{$config['invoice_mediaform_email']}}<br>
						</td>

						<td>
							{{@$order->structure->structure->legal_name}}<br>
							P.IVA: {{@$order->structure->structure->piva}}<br>
							CF: {{@$order->structure->structure->tax_code}}<br>
							EMAIL: {{@$order->structure->email}}<br>
							TEL: {{@$order->structure->structure->phone}}
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr class="heading">
			<td>
				MODALITÁ DI PAGAMENTO
			</td>

			<td>

			</td>
		</tr>

		<tr class="details">
			<td>
				{{$order->payment_name}}
			</td>

			<td>

			</td>
		</tr>

		<tr class="heading">
			<td>
				Item
			</td>

			<td>
				Price
			</td>
		</tr>

		@foreach($order->orderItems as $item)
			<tr class="item  @if($loop->last) last @endif">
				<td>
					{{ $item->course->name}}
				</td>

				<td>
				{{price_formater($item->qty * $item->price)}}
				</td>
			</tr>

		@endforeach

		<tr class="total">
			<td></td>

			<td>
				Total: {{price_formater($order->price)}}
			</td>
		</tr>
	</table>
</div>
</body>
</html>
