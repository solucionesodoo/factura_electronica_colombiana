<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Stenfrank\UBL21dian\Templates\SOAP\GetStatus;
use Stenfrank\UBL21dian\Templates\SOAP\GetStatusZip;

class StateController extends Controller
{
    /**
     * Zip.
     *
     * @param string $trackId
     *
     * @return array
     */
    public function zip($trackId, $GuardarEn = false)
    {
        // User
        $user = auth()->user();

        $getStatusZip = new GetStatusZip($user->company->certificate->path, $user->company->certificate->password, $user->company->software->url);
        $getStatusZip->trackId = $trackId;
        $GuardarEn = str_replace("_", "\\", $GuardarEn);

        if ($GuardarEn)
            return [
                'message' => 'Consulta generada con éxito',
                'ResponseDian' => $getStatusZip->signToSend($GuardarEn."\\ReqZIP-".$trackId.".xml")->getResponseToObject($GuardarEn."\\RptaZIP-".$trackId.".xml"),
            ];
        else
            return [
                'message' => 'Consulta generada con éxito',
                'ResponseDian' => $getStatusZip->signToSend(storage_path("ReqZIP-".$trackId.".xml"))->getResponseToObject(storage_path("RptaZIP-".$trackId.".xml")),
            ];
    }

    /**
     * Document.
     *
     * @param string $trackId
     *
     * @return array
     */
    public function document($trackId, $GuardarEn = false)
    {
        // User
        $user = auth()->user();

        $getStatus = new GetStatus($user->company->certificate->path, $user->company->certificate->password, $user->company->software->url);
        $getStatus->trackId = $trackId;
        $GuardarEn = str_replace("_", "\\", $GuardarEn);

        if ($GuardarEn)
            return [
                'message' => 'Consulta generada con éxito',
                'ResponseDian' => $getStatus->signToSend($GuardarEn."\\ReqZIP-".$trackId.".xml")->getResponseToObject($GuardarEn."\\RptaZIP-".$trackId.".xml"),
            ];
        else    
            return [
                'message' => 'Consulta generada con éxito',
                'ResponseDian' => $getStatus->signToSend(storage_path("ReqZIP-".$trackId.".xml"))->getResponseToObject(storage_path("RptaZIP-".$trackId.".xml")),
            ];
    }
}
