<?php

namespace App\Http\Controllers\Api;

use App\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NumberingRangeRequest;
use Stenfrank\UBL21dian\Templates\SOAP\GetNumberingRange;


class NumberingRangeController extends Controller
{
    /**
     * NumberingRange.
     *
     * @param \App\Http\Requests\Api\NumberingRangeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function NumberingRange(NumberingRangeRequest $request)
    {
        // User
        $user = auth()->user();

        $getNumberingRange = new GetNumberingRange($user->company->certificate->path, $user->company->certificate->password);
        $getNumberingRange->Nit = $request->Nit;
        $getNumberingRange->IDSoftware = $request->IDSoftware;

        if ($request->GuardarEn)
          return [
              'message' => 'Consulta generada con éxito',
              'ResponseDian' => $getNumberingRange->signToSend($request->GuardarEn.'\\Req-NumbRg.xml')->getResponseToObject($request->GuardarEn.'\\Rpta-NumbRg.xml'),
          ];
        else  
          return [
              'message' => 'Consulta generada con éxito',
              'ResponseDian' => $getNumberingRange->signToSend()->getResponseToObject(),
          ];
  }
}
