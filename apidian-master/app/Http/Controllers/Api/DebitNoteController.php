<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Company;
use App\TaxTotal;
use App\PaymentForm;
use App\TypeDocument;
use App\PaymentMethod;
use App\BillingReference;
use App\LegalMonetaryTotal;
use Illuminate\Http\Request;
use App\Traits\DocumentTrait;
use App\Http\Controllers\Controller;
use App\InvoiceLine as DebitNoteLine;
use App\Http\Requests\Api\DebitNoteRequest;
use Stenfrank\UBL21dian\XAdES\SignDebitNote;
use Stenfrank\UBL21dian\Templates\SOAP\SendBillAsync;
use Stenfrank\UBL21dian\Templates\SOAP\SendTestSetAsync;

class DebitNoteController extends Controller
{
    use DocumentTrait;

    /**
     * Store.
     *
     * @param \App\Http\Requests\Api\DebitNoteRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(DebitNoteRequest $request)
    {
        // User
        $user = auth()->user();

        // User company
        $company = $user->company;

        // Type document
        $typeDocument = TypeDocument::findOrFail($request->type_document_id);

        // Customer
        $customerAll = collect($request->customer);
        $customer = new User($customerAll->toArray());

        // Customer company
        $customer->company = new Company($customerAll->toArray());

        // Resolution
        $request->resolution->number = $request->number;
        $resolution = $request->resolution;

        // Date time
        $date = $request->date;
        $time = $request->time;

        // Payment form default
        $paymentFormAll = (object) array_merge($this->paymentFormDefault, $request->payment_form ?? []);
        $paymentForm = PaymentForm::findOrFail($paymentFormAll->payment_form_id);
        $paymentForm->payment_method_code = PaymentMethod::findOrFail($paymentFormAll->payment_method_id)->code;
        $paymentForm->payment_due_date = $paymentFormAll->payment_due_date ?? null;
        $paymentForm->duration_measure = $paymentFormAll->duration_measure ?? null;

        // Allowance charges
        $allowanceCharges = collect();
        foreach ($request->allowance_charges ?? [] as $allowanceCharge) {
            $allowanceCharges->push(new AllowanceCharge($allowanceCharge));
        }

        // Tax totals
        $taxTotals = collect();
        foreach ($request->tax_totals ?? [] as $taxTotal) {
            $taxTotals->push(new TaxTotal($taxTotal));
        }

        // Requested monetary totals
        $requestedMonetaryTotals = new LegalMonetaryTotal($request->requested_monetary_totals);

        // Credit note lines
        $debitNoteLines = collect();
        foreach ($request->debit_note_lines as $debitNoteLine) {
            $debitNoteLines->push(new DebitNoteLine($debitNoteLine));
        }

        // Billing reference
        $billingReference = new BillingReference($request->billing_reference);

        // Create XML
        $debitNote = $this->createXML(compact('user', 'company', 'customer', 'taxTotals', 'resolution', 'paymentForm', 'typeDocument', 'debitNoteLines', 'allowanceCharges', 'requestedMonetaryTotals', 'billingReference', 'date', 'time'));

        // Signature XML
        $signDebitNote = new SignDebitNote($company->certificate->path, $company->certificate->password);
        $signDebitNote->softwareID = $company->software->identifier;
        $signDebitNote->pin = $company->software->pin;
        if ($request->GuardarEn)
            $signDebitNote->GuardarEn = $request->GuardarEn."\\ND-{$resolution->next_consecutive}.xml";
        else    
            $signDebitNote->GuardarEn = storage_path("ND-{$resolution->next_consecutive}.xml");

        $sendBillAsync = new SendBillAsync($company->certificate->path, $company->certificate->password);
        $sendBillAsync->To = $company->software->url;
        $sendBillAsync->fileName = "{$resolution->next_consecutive}.xml";
        if ($request->GuardarEn)
            $sendBillAsync->contentFile = $this->zipBase64($company, $resolution, $signDebitNote->sign($debitNote), $request->GuardarEn."\\NDS-{$resolution->next_consecutive}");
        else
            $sendBillAsync->contentFile = $this->zipBase64($company, $resolution, $signDebitNote->sign($debitNote), storage_path("NDS-{$resolution->next_consecutive}"));

        if ($request->GuardarEn)
            return [
                'message' => "{$typeDocument->name} #{$resolution->next_consecutive} generada con éxito",
                'ResponseDian' => $sendBillAsync->signToSend($request->GuardarEn."\\ReqND-{$resolution->next_consecutive}.xml")->getResponseToObject($request->GuardarEn."\\RptaND-{$resolution->next_consecutive}.xml"),
                'invoicexml'=>base64_encode(file_get_contents($request->GuardarEn."\\NDS-{$resolution->next_consecutive}.xml")),
                'urlinvoicexml'=>"/invoice/xml/ReqND-{$resolution->next_consecutive}.xml",
                'urlinvoicepdf'=>"/invoice/pdf/ReqND-{$resolution->next_consecutive}.pdf"
            ];
        else
            return [
                'message' => "{$typeDocument->name} #{$resolution->next_consecutive} generada con éxito",
                'ResponseDian' => $sendBillAsync->signToSend(storage_path("ReqND-{$resolution->next_consecutive}.xml"))->getResponseToObject(storage_path("RptaND-{$resolution->next_consecutive}.xml")),
                'invoicexml'=>base64_encode(file_get_contents(storage_path("\\NDS-{$resolution->next_consecutive}.xml"))),
                'urlinvoicexml'=>"/invoice/xml/ReqND-{$resolution->next_consecutive}.xml",
                'urlinvoicepdf'=>"/invoice/pdf/ReqND-{$resolution->next_consecutive}.pdf"
            ];
    }

    /**
     * Test set store.
     *
     * @param \App\Http\Requests\Api\DebitNoteRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function testSetStore(DebitNoteRequest $request, $testSetId)
    {
        // User
        $user = auth()->user();

        // User company
        $company = $user->company;

        // Type document
        $typeDocument = TypeDocument::findOrFail($request->type_document_id);

        // Customer
        $customerAll = collect($request->customer);
        $customer = new User($customerAll->toArray());

        // Customer company
        $customer->company = new Company($customerAll->toArray());

        // Resolution
        $request->resolution->number = $request->number;
        $resolution = $request->resolution;

        // Date time
        $date = $request->date;
        $time = $request->time;

        // Payment form default
        $paymentFormAll = (object) array_merge($this->paymentFormDefault, $request->payment_form ?? []);
        $paymentForm = PaymentForm::findOrFail($paymentFormAll->payment_form_id);
        $paymentForm->payment_method_code = PaymentMethod::findOrFail($paymentFormAll->payment_method_id)->code;
        $paymentForm->payment_due_date = $paymentFormAll->payment_due_date ?? null;
        $paymentForm->duration_measure = $paymentFormAll->duration_measure ?? null;

        // Allowance charges
        $allowanceCharges = collect();
        foreach ($request->allowance_charges ?? [] as $allowanceCharge) {
            $allowanceCharges->push(new AllowanceCharge($allowanceCharge));
        }

        // Tax totals
        $taxTotals = collect();
        foreach ($request->tax_totals ?? [] as $taxTotal) {
            $taxTotals->push(new TaxTotal($taxTotal));
        }

        // Requested monetary totals
        $requestedMonetaryTotals = new LegalMonetaryTotal($request->requested_monetary_totals);

        // Credit note lines
        $debitNoteLines = collect();
        foreach ($request->debit_note_lines as $debitNoteLine) {
            $debitNoteLines->push(new DebitNoteLine($debitNoteLine));
        }

        // Billing reference
        $billingReference = new BillingReference($request->billing_reference);

        // Create XML
        $debitNote = $this->createXML(compact('user', 'company', 'customer', 'taxTotals', 'resolution', 'paymentForm', 'typeDocument', 'debitNoteLines', 'allowanceCharges', 'requestedMonetaryTotals', 'billingReference', 'date', 'time'));

        // Signature XML
        $signDebitNote = new SignDebitNote($company->certificate->path, $company->certificate->password);
        $signDebitNote->softwareID = $company->software->identifier;
        $signDebitNote->pin = $company->software->pin;
        if ($request->GuardarEn)
            $signDebitNote->GuardarEn = $request->GuardarEn."\\ND-{$resolution->next_consecutive}.xml";
        else    
            $signDebitNote->GuardarEn = storage_path("ND-{$resolution->next_consecutive}.xml");

        $sendTestSetAsync = new SendTestSetAsync($company->certificate->path, $company->certificate->password);
        $sendTestSetAsync->To = $company->software->url;
        $sendTestSetAsync->fileName = "{$resolution->next_consecutive}.xml";

        if ($request->GuardarEn)
            $sendTestSetAsync->contentFile = $this->zipBase64($company, $resolution, $signDebitNote->sign($debitNote), $request->GuardarEn."\\NDS-{$resolution->next_consecutive}");
        else
            $sendTestSetAsync->contentFile = $this->zipBase64($company, $resolution, $signDebitNote->sign($debitNote), storage_path("NDS-{$resolution->next_consecutive}"));

        $sendTestSetAsync->testSetId = $testSetId;
    
        if ($request->GuardarEn)
            return [
                'message' => "{$typeDocument->name} #{$resolution->next_consecutive} generada con éxito",
                'ResponseDian' => $sendTestSetAsync->signToSend($request->GuardarEn."\\ReqND-{$resolution->next_consecutive}.xml")->getResponseToObject($request->GuardarEn."\\RptaND-{$resolution->next_consecutive}.xml"),
                'invoicexml'=>base64_encode(file_get_contents($request->GuardarEn."\\NDS-{$resolution->next_consecutive}.xml")),
                'urlinvoicexml'=>"/invoice/xml/ReqND-{$resolution->next_consecutive}.xml",
                'urlinvoicepdf'=>"/invoice/pdf/ReqND-{$resolution->next_consecutive}.pdf"
            ];
        else
            return [
                'message' => "{$typeDocument->name} #{$resolution->next_consecutive} generada con éxito",
                'ResponseDian' => $sendTestSetAsync->signToSend(storage_path("ReqND-{$resolution->next_consecutive}.xml"))->getResponseToObject(storage_path("RptaND-{$resolution->next_consecutive}.xml")),
                'invoicexml'=>base64_encode(file_get_contents(storage_path("NDS-{$resolution->next_consecutive}.xml"))),
                'urlinvoicexml'=>"/invoice/xml/ReqND-{$resolution->next_consecutive}.xml",
                'urlinvoicepdf'=>"/invoice/pdf/ReqND-{$resolution->next_consecutive}.pdf"
            ];
    }
}
