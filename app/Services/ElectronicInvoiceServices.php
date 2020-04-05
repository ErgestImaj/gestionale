<?php


namespace App\Services;


use App\Helpers\ConfigHelper;
use App\Helpers\CurrencyHelper;
use App\Models\Cart\ElectronicInvoice;
use App\Traits\DatabaseDateFomat;
use Carbon\Carbon;

class ElectronicInvoiceServices
{
	use DatabaseDateFomat;

	public static function generateXMLInvoice($invoice, $client)
	{
		$payment_mode = $invoice->payment_type == 0 ? 'MP05' : 'MP08';
		$class = get_class($invoice);
		$price = $bolo2 = $p_without_iva1 = $iva1 = $imp1 = $impon1 = $p_without_iva2 = $iva2 = $impon2 = $imp2 = $p_without_iva3 = $iva3 = $tatal_order = 0;
		$invoice_date = $invoice->order_date;
		if ($class != 'App\Models\Cart\Orders') {
			$p_no_iva = 0;
			foreach ($invoice->order_items as $orderItem):
				$prezo_unico = CurrencyHelper::renderValue(ConfigHelper::getConfigValue('fast_track_price', 0, 'cart') / (1 + 22 / 100));
				$total = CurrencyHelper::renderValue($prezo_unico * $orderItem->participants_count);
				$p_no_iva += $total;
			endforeach;
			$price = CurrencyHelper::renderValue($p_no_iva * (1 + 22 / 100));

		} else {

			foreach ($invoice->orderItems as $orderItem):
				$iva = @$orderItem->course->vatRate->value;
				$iva_rate = @$orderItem->course->vatRate->id;
				if ($iva_rate == 1) {
					$iva1 = $iva;
					$p_without_iva1 += CurrencyHelper::renderValue($orderItem->price / (1 + $iva / 100));
					$impon1 = +CurrencyHelper::renderValue(($p_without_iva1 * $orderItem->qty));
					$imp1 = +urrencyHelper::renderValue($impon1 * (1 + $iva / 100) - $impon1);
				} elseif ($iva_rate != 3) {
					if (in_array($iva_rate, [4, 5])) {
						$bolo2 = $invoice->price > 77.47 ? 2 : 0;

						$iva3 = $iva_rate;
						$p_without_iva3 += CurrencyHelper::renderValue($orderItem->price * $orderItem->qty);
					}
				} else {
					$iva2 = $iva;
					$p_without_iva2 += CurrencyHelper::renderValue($orderItem->price / (1 + $iva / 100));
					$impon2 += CurrencyHelper::renderValue(($p_without_iva2 * $orderItem->qty));
					$imp2 += CurrencyHelper::renderValue($impon2 * (1 + $iva / 100) - $impon2);
				}
			endforeach;
			$tatal_order = CurrencyHelper::renderValue($impon1 + $imp1 + $imp2 + $impon2 + $p_without_iva3 + $bolo2);
		}


		$codice_destinatario = empty($client->codice_destinatario) ? "0000000" : $client->codice_destinatario;

		// Create the document.
		$xml = new \DOMDocument();


		//adding root off all ements
		$fatturaElettronica = $xml->createElement("p:FatturaElettronica");
		//attributes of root element
		$fatturaElettronica->setAttribute('versione', "FPR12");
		$fatturaElettronica->setAttribute('xmlns:ds', "http://www.w3.org/2000/09/xmldsig#");
		$fatturaElettronica->setAttribute('xmlns:p', "http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2");
		$fatturaElettronica->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
		$fatturaElettronica->setAttribute('xsi:schemaLocation', "http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2 http://www.fatturapa.gov.it/export/fatturazione/sdi/fatturapa/v1.2/Schema_del_file_xml_FatturaPA_versione_1.2.xsd");

		// creating FatturaElettronicaHeader
		$fatturaElettronicaHeader = $xml->createElement("FatturaElettronicaHeader");

		// creating DatiTrasmissione
		$datiTrasmissione = $xml->createElement("DatiTrasmissione");
		// creating IdTrasmittente
		$IdTrasmittente = $xml->createElement("IdTrasmittente");

		$IdPaese = $xml->createElement("IdPaese", "IT");
		$IdTrasmittente->appendChild($IdPaese);

		$IdCodice = $xml->createElement("IdCodice", "10209790152");
		$IdTrasmittente->appendChild($IdCodice);

		$datiTrasmissione->appendChild($IdTrasmittente);
		//end IdTrasmittente

		$ProgressivoInvio = $xml->createElement("ProgressivoInvio", ElectronicInvoice::getMaxProgresNumber());
		$datiTrasmissione->appendChild($ProgressivoInvio);

		$FormatoTrasmissione = $xml->createElement("FormatoTrasmissione", "FPR12");
		$datiTrasmissione->appendChild($FormatoTrasmissione);

		$CodiceDestinatario = $xml->createElement("CodiceDestinatario", $codice_destinatario);
		$datiTrasmissione->appendChild($CodiceDestinatario);

		// company show pec email

		$PECDestinatario = $xml->createElement("PECDestinatario", $client->pec);
		$datiTrasmissione->appendChild($PECDestinatario);


		$fatturaElettronicaHeader->appendChild($datiTrasmissione);
		// end DatiTrasmissione

		// creating CedentePrestatore
		$CedentePrestatore = $xml->createElement("CedentePrestatore");

		//creating DatiAnagrafici
		$DatiAnagrafici = $xml->createElement("DatiAnagrafici");

		$IdFiscaleIVA = $xml->createElement("IdFiscaleIVA");

		$IdPaese = $xml->createElement("IdPaese", "IT");
		$IdFiscaleIVA->appendChild($IdPaese);
		$IdCodice = $xml->createElement("IdCodice", "07240111216");
		$IdFiscaleIVA->appendChild($IdCodice);

		$DatiAnagrafici->appendChild($IdFiscaleIVA);

		$CodiceFiscale = $xml->createElement("CodiceFiscale", "07240111216");
		$DatiAnagrafici->appendChild($CodiceFiscale);

		$Anagrafica = $xml->createElement("Anagrafica");
		$Denominazione = $xml->createElement("Denominazione", "MEDIAFORM EDUCATIONAL QUALIFICATIONS AND INTERNATIONAL");
		$Anagrafica->appendChild($Denominazione);
		$DatiAnagrafici->appendChild($Anagrafica);

		$RegimeFiscale = $xml->createElement("RegimeFiscale", "RF01");
		$DatiAnagrafici->appendChild($RegimeFiscale);

		$CedentePrestatore->appendChild($DatiAnagrafici);
		//end DatiAnagrafici

		//create sede
		$Sede = $xml->createElement("Sede");
		$Indirizzo = $xml->createElement("Indirizzo", "CORSO ITALIA");
		$Sede->appendChild($Indirizzo);
		$NumeroCivico = $xml->createElement("NumeroCivico", "125/127");
		$Sede->appendChild($NumeroCivico);
		$CAP = $xml->createElement("CAP", "80011");
		$Sede->appendChild($CAP);
		$Comune = $xml->createElement("Comune", "Acerra");
		$Sede->appendChild($Comune);
		$Provincia = $xml->createElement("Provincia", "NA");
		$Sede->appendChild($Provincia);
		$Nazione = $xml->createElement("Nazione", "IT");
		$Sede->appendChild($Nazione);
		$CedentePrestatore->appendChild($Sede);
		//end sede

		// creating IscrizioneREA
		$IscrizioneREA = $xml->createElement("IscrizioneREA");
		$Ufficio = $xml->createElement("Ufficio", "NA");
		$IscrizioneREA->appendChild($Ufficio);
		$NumeroREA = $xml->createElement("NumeroREA", "0870875");
		$IscrizioneREA->appendChild($NumeroREA);
		$CapitaleSociale = $xml->createElement("CapitaleSociale", "1250.00");
		$IscrizioneREA->appendChild($CapitaleSociale);
		$SocioUnico = $xml->createElement("SocioUnico", "SM");
		$IscrizioneREA->appendChild($SocioUnico);
		$StatoLiquidazione = $xml->createElement("StatoLiquidazione", "LN");
		$IscrizioneREA->appendChild($StatoLiquidazione);
		$CedentePrestatore->appendChild($IscrizioneREA);
		// end IscrizioneREA

		// creating Contatti
		$Contatti = $xml->createElement("Contatti");
		$Telefono = $xml->createElement("Telefono", "0813198141");
		$Contatti->appendChild($Telefono);
		$Email = $xml->createElement("Email", "amministrazione@mediaform.it");
		$Contatti->appendChild($Email);
		$CedentePrestatore->appendChild($Contatti);
		// end Contatti

		$fatturaElettronicaHeader->appendChild($CedentePrestatore);
		// end CedentePrestatore

		// creating CessionarioCommittente  ===============================================
		$CessionarioCommittente = $xml->createElement("CessionarioCommittente");

		//creating DatiAnagrafici===========================================================
		$DatiAnagrafici = $xml->createElement("DatiAnagrafici");

		$IdFiscaleIVA = $xml->createElement("IdFiscaleIVA");

		$IdPaese = $xml->createElement("IdPaese", "IT");
		$IdFiscaleIVA->appendChild($IdPaese);
		$IdCodice = $xml->createElement("IdCodice", $client->piva);
		$IdFiscaleIVA->appendChild($IdCodice);
		$DatiAnagrafici->appendChild($IdFiscaleIVA);

		$CodiceFiscale = $xml->createElement("CodiceFiscale", $client->tax_code); // dynamic data
		$DatiAnagrafici->appendChild($CodiceFiscale);

		$Anagrafica = $xml->createElement("Anagrafica");
		$Denominazione = $xml->createElement("Denominazione", htmlentities($client->legal_name));
		$Anagrafica->appendChild($Denominazione);

		$DatiAnagrafici->appendChild($Anagrafica);

		$CessionarioCommittente->appendChild($DatiAnagrafici);
		//end DatiAnagrafici=============================================

		//create sede=====================================================
		$Sede = $xml->createElement("Sede");
		$Indirizzo = $xml->createElement("Indirizzo", $client->legal_address);
		$Sede->appendChild($Indirizzo);

		$CAP = $xml->createElement("CAP", $client->legal_zipcode);
		$Sede->appendChild($CAP);

		$Comune = $xml->createElement("Comune", optional($client->town)->title);
		$Sede->appendChild($Comune);

		$Provincia = $xml->createElement("Provincia", optional($client->province)->code);
		$Sede->appendChild($Provincia);

		$Nazione = $xml->createElement("Nazione", optional($client->country)->code);
		$Sede->appendChild($Nazione);

		$CessionarioCommittente->appendChild($Sede);
		//end sede=================================================================

		$fatturaElettronicaHeader->appendChild($CessionarioCommittente);
		// end CessionarioCommittente

		$fatturaElettronica->appendChild($fatturaElettronicaHeader);
		// end of  FatturaElettronicaHeader================================================================================================

		// creating FatturaElettronicaBody========================================
		$FatturaElettronicaBody = $xml->createElement("FatturaElettronicaBody");


		//creating DatiGenerali=====================================================
		$DatiGenerali = $xml->createElement("DatiGenerali");
		$DatiGeneraliDocumento = $xml->createElement("DatiGeneraliDocumento");
		$TipoDocumento = $xml->createElement("TipoDocumento", "TD01");
		$DatiGeneraliDocumento->appendChild($TipoDocumento);
		$Divisa = $xml->createElement("Divisa", "EUR");
		$DatiGeneraliDocumento->appendChild($Divisa);
		$Data = $xml->createElement("Data", $invoice_date);
		$DatiGeneraliDocumento->appendChild($Data);
		$Numero = $xml->createElement("Numero", ElectronicInvoice::getMaxProgresNumber() . Carbon::now()->year);
		$DatiGeneraliDocumento->appendChild($Numero);
		$ImportoTotaleDocumento = $xml->createElement("ImportoTotaleDocumento", $class == 'App\Models\Cart\Orders' ? $tatal_order : $price);
		$DatiGeneraliDocumento->appendChild($ImportoTotaleDocumento);
		$DatiGenerali->appendChild($DatiGeneraliDocumento);
		$FatturaElettronicaBody->appendChild($DatiGenerali);
		//end DatiGenerali============================

		if ($class == 'App\Models\Cart\Orders'):
			//creating DatiBeniServizi=========================
			$DatiBeniServizi = $xml->createElement("DatiBeniServizi");

			//creating DettaglioLine================
			$num = 1;
			$iva = 0;
			$iva_rate = 0;
			$vats = array();
			$bolo = 0;
			foreach ($invoice->orderItems as $orderItem):
				$DettaglioLinee = $xml->createElement("DettaglioLinee");

				$iva = @$orderItem->course->vatRate->value;
				$iva_rate = @$orderItem->course->vatRate->id;

				if (in_array($iva_rate, [1, 3])) array_push($vats, $iva_rate);
				$price_without_iva = CurrencyHelper::renderValue($orderItem->price / (1 + $iva / 100));

				$NumeroLinea = $xml->createElement("NumeroLinea", $num);
				$DettaglioLinee->appendChild($NumeroLinea);

				$Descrizione = $xml->createElement("Descrizione", $invoice->order_number);
				$DettaglioLinee->appendChild($Descrizione);

				$Quantita = $xml->createElement("Quantita", CurrencyHelper::renderValue($orderItem->qty));
				$DettaglioLinee->appendChild($Quantita);

				$PrezzoUnitario = $xml->createElement("PrezzoUnitario", $price_without_iva);
				$DettaglioLinee->appendChild($PrezzoUnitario);
				$PrezzoTotale = $xml->createElement("PrezzoTotale", CurrencyHelper::renderValue($price_without_iva * $orderItem->qty));
				$DettaglioLinee->appendChild($PrezzoTotale);

				$AliquotaIVA = $xml->createElement("AliquotaIVA", $iva);
				$DettaglioLinee->appendChild($AliquotaIVA);
				if ($iva == 0.00) {
					$Natura = $xml->createElement("Natura", 'N2');
					$DettaglioLinee->appendChild($Natura);
				}

				$DatiBeniServizi->appendChild($DettaglioLinee);
				$num++;
			endforeach;
			if (($iva_rate == 4 || $iva_rate == 5) && $invoice->price > 77.47):
				$DettaglioLinee = $xml->createElement("DettaglioLinee");
				$bolo = 2;
				$NumeroLinea = $xml->createElement("NumeroLinea", $num);
				$DettaglioLinee->appendChild($NumeroLinea);
				$TipoCessionePrestazione = $xml->createElement("TipoCessionePrestazione", "AC");
				$DettaglioLinee->appendChild($TipoCessionePrestazione);
				$Descrizione = $xml->createElement("Descrizione", "Bollo su importi esenti");
				$DettaglioLinee->appendChild($Descrizione);
				$Quantita = $xml->createElement("Quantita", "1.00");
				$DettaglioLinee->appendChild($Quantita);
				$PrezzoUnitario = $xml->createElement("PrezzoUnitario", "2.00");
				$DettaglioLinee->appendChild($PrezzoUnitario);
				$PrezzoTotale = $xml->createElement("PrezzoTotale", "2.00");
				$DettaglioLinee->appendChild($PrezzoTotale);
				$AliquotaIVA = $xml->createElement("AliquotaIVA", "0.00");
				$DettaglioLinee->appendChild($AliquotaIVA);
				$Natura = $xml->createElement("Natura", 'N1');
				$DettaglioLinee->appendChild($Natura);
				$DatiBeniServizi->appendChild($DettaglioLinee);
			endif;

			$DatiBeniServizi->appendChild($DettaglioLinee);

			// end DettaglioLinee==============================================


			//creating DatiRiepilogo=================================================


			if ($iva1 != 0) {
				$DatiRiepilogo = $xml->createElement("DatiRiepilogo");
				$AliquotaIVA = $xml->createElement("AliquotaIVA", "22.00");
				$DatiRiepilogo->appendChild($AliquotaIVA);
				$ImponibileImporto = $xml->createElement("ImponibileImporto", CurrencyHelper::renderValue($impon1));
				$DatiRiepilogo->appendChild($ImponibileImporto);
				$Imposta = $xml->createElement("Imposta", CurrencyHelper::renderValue($imp1));
				$DatiRiepilogo->appendChild($Imposta);
				$EsigibilitaIVA = $xml->createElement("EsigibilitaIVA", "I");
				$DatiRiepilogo->appendChild($EsigibilitaIVA);
				$DatiBeniServizi->appendChild($DatiRiepilogo);
			}
			if ($iva2 != 0) {
				$DatiRiepilogo = $xml->createElement("DatiRiepilogo");
				$AliquotaIVA = $xml->createElement("AliquotaIVA", "20.00");
				$DatiRiepilogo->appendChild($AliquotaIVA);
				$ImponibileImporto = $xml->createElement("ImponibileImporto", CurrencyHelper::renderValue($impon2));
				$DatiRiepilogo->appendChild($ImponibileImporto);
				$Imposta = $xml->createElement("Imposta", CurrencyHelper::renderValue($imp2));
				$DatiRiepilogo->appendChild($Imposta);
				$EsigibilitaIVA = $xml->createElement("EsigibilitaIVA", "I");
				$DatiRiepilogo->appendChild($EsigibilitaIVA);
				$DatiBeniServizi->appendChild($DatiRiepilogo);
			}
			if ($iva3 != 0):
				$DatiRiepilogo = $xml->createElement("DatiRiepilogo");
				$AliquotaIVA = $xml->createElement("AliquotaIVA", "0.00");
				$DatiRiepilogo->appendChild($AliquotaIVA);
				$Natura = $xml->createElement("Natura", 'N2');
				$DatiRiepilogo->appendChild($Natura);
				$ImponibileImporto = $xml->createElement("ImponibileImporto", CurrencyHelper::renderValue($p_without_iva3 + $bolo));
				$DatiRiepilogo->appendChild($ImponibileImporto);
				$Imposta = $xml->createElement("Imposta", '0.00');
				$DatiRiepilogo->appendChild($Imposta);
				$RiferimentoNormativo = $xml->createElement("RiferimentoNormativo", $iva3 == 4 ? "N.I. art. 10 DPR 633/72" : "N.I. art. 15 DPR 633/72");
				$DatiRiepilogo->appendChild($RiferimentoNormativo);
				$DatiBeniServizi->appendChild($DatiRiepilogo);
			endif;


		// end DatiRiepilogo==================================================================================

		else:
			//creating DatiBeniServizi 2=========================
			$DatiBeniServizi = $xml->createElement("DatiBeniServizi");
			$num = 1;
			$total = 0;
			$p_no_iva = 0;
			//creating DettaglioLine 2================
			foreach ($invoice->order_items as $orderItem):

				$DettaglioLinee = $xml->createElement("DettaglioLinee");

				$prezo_unico = CurrencyHelper::renderValue(ConfigHelper::getConfigValue('fast_track_price', 0,'cart') / (1 + 22 / 100));
				$total = CurrencyHelper::renderValue($prezo_unico *  $orderItem->participants_count);
				$p_no_iva += CurrencyHelper::renderValue($total);
				$NumeroLinea = $xml->createElement("NumeroLinea", $num);
				$DettaglioLinee->appendChild($NumeroLinea);
				$Descrizione = $xml->createElement("Descrizione", $invoice->order_number);
				$DettaglioLinee->appendChild($Descrizione);
				$Quantita = $xml->createElement("Quantita", CurrencyHelper::renderValue( $orderItem->participants_count));
				$DettaglioLinee->appendChild($Quantita);

				$PrezzoUnitario = $xml->createElement("PrezzoUnitario", $prezo_unico);
				$DettaglioLinee->appendChild($PrezzoUnitario);

				$PrezzoTotale = $xml->createElement("PrezzoTotale", $total);
				$DettaglioLinee->appendChild($PrezzoTotale);

				$AliquotaIVA = $xml->createElement("AliquotaIVA", "22.00");
				$DettaglioLinee->appendChild($AliquotaIVA);
				$DatiBeniServizi->appendChild($DettaglioLinee);
				$num++;
			endforeach;

			$DatiBeniServizi->appendChild($DettaglioLinee);

			// end DettaglioLinee1 2==============================================


			//creating DatiRiepilogo 2=================================================

			$price = CurrencyHelper::renderValue($p_no_iva * (1 + 22 / 100));
			$DatiRiepilogo = $xml->createElement("DatiRiepilogo");
			$AliquotaIVA = $xml->createElement("AliquotaIVA", "22.00");
			$DatiRiepilogo->appendChild($AliquotaIVA);

			$ImponibileImporto = $xml->createElement("ImponibileImporto", CurrencyHelper::renderValue($p_no_iva));
			$DatiRiepilogo->appendChild($ImponibileImporto);

			$Imposta = $xml->createElement("Imposta", CurrencyHelper::renderValue($price - $p_no_iva));
			$DatiRiepilogo->appendChild($Imposta);
			$EsigibilitaIVA = $xml->createElement("EsigibilitaIVA", "I");
			$DatiRiepilogo->appendChild($EsigibilitaIVA);


			$DatiBeniServizi->appendChild($DatiRiepilogo);

			// end DatiRiepilogo 2==================================================================================
		endif;

		$FatturaElettronicaBody->appendChild($DatiBeniServizi);
		//end DatiBeniServizi======================================


		//creating DatiPagamento==========================
		$DatiPagamento = $xml->createElement("DatiPagamento");

		$CondizioniPagamento = $xml->createElement("CondizioniPagamento", "TP02");
		$DatiPagamento->appendChild($CondizioniPagamento);

		//creating DettaglioPagamento
		$DettaglioPagamento = $xml->createElement("DettaglioPagamento");
		$ModalitaPagamento = $xml->createElement("ModalitaPagamento", $payment_mode);
		$DettaglioPagamento->appendChild($ModalitaPagamento);
		$DataScadenzaPagamento = $xml->createElement("DataScadenzaPagamento", $invoice_date);
		$DettaglioPagamento->appendChild($DataScadenzaPagamento);
		$ImportoPagamento = $xml->createElement("ImportoPagamento", $class == 'App\Models\Cart\Orders' ? $tatal_order : $price);
		$DettaglioPagamento->appendChild($ImportoPagamento);
		$IstitutoFinanziario = $xml->createElement("IstitutoFinanziario", "Poste Italiane Spa");
		$DettaglioPagamento->appendChild($IstitutoFinanziario);
		$IBAN = $xml->createElement("IBAN", "IT15G0760103400001024439968");
		$DettaglioPagamento->appendChild($IBAN);

		$DatiPagamento->appendChild($DettaglioPagamento);
		// end DettaglioPagamento


		$FatturaElettronicaBody->appendChild($DatiPagamento);
		//end DatiPagamento====================


		$fatturaElettronica->appendChild($FatturaElettronicaBody);
		// end FatturaElettronicaBody=================================================

		$xml->appendChild($fatturaElettronica);
		//Save XML as a file
		$file_name = 'IT10209790152_' . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 5) . '.xml';
		$type = isset($invoice->type) ? $invoice->type : ElectronicInvoice::TYPE_FAST_TRACK;

		try {
			$xml->save(storage_path('app/public/'.ElectronicInvoice::CONTENT_PATH.DIRECTORY_SEPARATOR).  $file_name);

         $electronic_invoice = ElectronicInvoice::create([
         	'user_id'=>$invoice->user_id,
					 'type'=>$type,
					 'invoice_number'=>(int)filter_var(ElectronicInvoice::getMaxProgresNumber(),FILTER_SANITIZE_NUMBER_INT),
					 'invoice_oldnr'=>$invoice->order_number,
					 'receipt'=>$file_name,
				 ]);
				return $electronic_invoice;

		}catch (\Exception $exception){
			logger($exception->getMessage());
		  return false;
		}

	}
}
