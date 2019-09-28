<?php

namespace App\Traits;

use Storage;
use Exception;
use ZipArchive;
use App\Company;
use App\Mail\InvoiceMail;
use DOMDocument;
use App\Resolution;
use App\TypeDocument;
use App\User;
use QrCode;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Stenfrank\UBL21dian\Sign;
use PDF;

/**
 * Document trait.
 */
trait DocumentTrait
{
    /**
     * PPP.
     *
     * @var string
     */
    public $ppp = '000';

    /**
     * Payment form default.
     *
     * @var array
     */
    private $paymentFormDefault = [
        'payment_form_id' => 1,
        'payment_method_id' => 10,
    ];

    /**
     * Create xml.
     *
     * @param array $data
     *
     * @return DOMDocument
     */
    protected function createXML(array $data)
    {
        try {
            $DOMDocumentXML = new DOMDocument();
            $DOMDocumentXML->preserveWhiteSpace = false;
            $DOMDocumentXML->formatOutput = true;
            $DOMDocumentXML->loadXML(view("xml.{$data['typeDocument']['code']}", $data)->render());

            return $DOMDocumentXML;
        } catch (InvalidArgumentException $e) {
            throw new Exception("The API does not support the type of document '{$data['typeDocument']['name']}' Error: {$e->getMessage()}");
        } catch (Exception $e) {
            throw new Exception("Error: {$e->getMessage()}");
        }
    }

    /**
     * Create pdf.
     *
     * @param array $data
     *
     * @return DOMDocument
     */
    protected function createPDF($user, $company, $customer, $typeDocument, $resolution, $date, $time, $request  )
    {
        try {
            define("DOMPDF_ENABLE_REMOTE", true);
            $logoBase64 = base64_encode(file_get_contents('img/logo_mcs.png'));
            $qrBase64 = base64_encode(QrCode::format('png')
                            ->errorCorrection('Q')
                                ->size(130)
                                    ->margin(0)
                                        ->generate('NumFac: '.$request->number.' FecFac: '.$date.' NitFac: '. $customer->company->identification_number.' DocAdq: '. $request->type_document_id.' ValFac: '. $request->legal_monetary_totals['tax_exclusive_amount'].' ValIva: '. $request->tax_totals[0]['tax_amount'].' ValOtroIm: '.$request->legal_monetary_totals['allowance_total_amount'].' ValTotal: '.$request->legal_monetary_totals['payable_amount'].' CUFE: 2836a15058e90baabbf6bf2e97f05564ea0324a6'));
                                        
            $imgLogo    =  "data:image/png;base64, ".$logoBase64;
            $imageQr    =  "data:image/png;base64, ".$qrBase64;
            $pdf        =  PDF::loadView("invoice", compact("user", "company", "customer", "resolution", "date", "time", "request", "imageQr","imgLogo"))->setWarnings(false);
            $filename   =  "facturas/pdf/".date("Y-m-d")."/fehaytic" . mt_rand(0,99999) .".pdf";

            $filename_two = "FES-{$resolution->next_consecutive}.pdf";

            Storage::put($filename, $pdf->output());

            Storage::put($filename_two, $pdf->output());

//           $notificacion = $this->sendEmail($filename, compact('user','customer'));

//            if($notificacion)
            return $pdf->download($filename);

        } catch (InvalidArgumentException $e) {
            throw new Exception("The API does not support the type of document '{$typeDocument->name}' Error: {$e->getMessage()}");
        } catch (Exception $e) {
            throw new Exception("Error: {$e->getMessage()}");
        }
    }

    /**
     * Zip base64.
     *
     * @param \App\Company              $company
     * @param \App\Resolution           $resolution
     * @param \Stenfrank\UBL21dian\Sign $sign
     *
     * @return string
     */
    protected function zipBase64(Company $company, Resolution $resolution, Sign $sign, $GuardarEn = false)
    {
        $dir = "zip/{$resolution->company_id}";
        $nameXML = $this->getFileName($company, $resolution);
        $nameZip = $this->getFileName($company, $resolution, 6, '.zip');

        $this->pathZIP = "app/zip/{$resolution->company_id}/{$nameZip}";

        Storage::put("xml/{$resolution->company_id}/{$nameXML}", $sign->xml);

        if (!Storage::has($dir)) {
            Storage::makeDirectory($dir);
        }

        $zip = new ZipArchive();
        $zip->open(storage_path($this->pathZIP), ZipArchive::CREATE);
        $zip->addFile(storage_path("app/xml/{$resolution->company_id}/{$nameXML}"), $nameXML);
        $zip->close();

        if ($GuardarEn){
            copy(storage_path("app/xml/{$resolution->company_id}/{$nameXML}"), $GuardarEn.".xml");
            copy(storage_path($this->pathZIP), $GuardarEn.".zip");
        }

        return $this->ZipBase64Bytes = base64_encode(file_get_contents(storage_path($this->pathZIP)));
    }

    /**
     * Get file name.
     *
     * @param \App\Company    $company
     * @param \App\Resolution $resolution
     *
     * @return string
     */
    protected function getFileName(Company $company, Resolution $resolution, $typeDocumentID = null, $extension = '.xml')
    {
        $date = now();
        $prefix = (is_null($typeDocumentID)) ? $resolution->type_document->prefix : TypeDocument::findOrFail($typeDocumentID)->prefix;

        $send = $company->send()->firstOrCreate([
            'year' => $date->format('y'),
            'type_document_id' => $typeDocumentID ?? $resolution->type_document_id,
        ]);

        $name = "{$prefix}{$this->stuffedString($company->identification_number)}{$this->ppp}{$date->format('y')}{$this->stuffedString($send->next_consecutive ?? 1, 8)}{$extension}";

        $send->increment('next_consecutive');

        return $name;
    }

    /**
     * Stuffed string.
     *
     * @param string $string
     * @param int    $length
     * @param int    $padString
     * @param int    $padType
     *
     * @return string
     */
    protected function stuffedString($string, $length = 10, $padString = 0, $padType = STR_PAD_LEFT)
    {
        return str_pad($string, $length, $padString, $padType);
    }

    /**
     * Get ZIP.
     *
     * @return string
     */
    protected function getZIP()
    {
        return $this->ZipBase64Bytes;
    }

    /**
     * post sendEmail.
     *
     * @return string
     */
    protected function sendEmail(string $filename, array $data){
        $company    = $data['user'];
        $customer   = $data['customer'];

        $message = Mail::to($customer->email)->send(new InvoiceMail($data, $filename));

        return $message;
    }
}
