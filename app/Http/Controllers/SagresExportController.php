<?php

namespace App\Http\Controllers;

use App\Http\Requests\SagresExportRequest;
use App\Process;
use App\Services\SagresExport\ExportService;
use Illuminate\Http\Response as ResponseReturn;
use Illuminate\View\View;
use Response;

class SagresExportController extends Controller
{
    public function index(): View
    {
        $this->breadcrumb('Exportação para o Sagres', [
            url('intranet/educar_index.php') => 'Escola',
        ]);
        $this->menu(Process::SAGRES_EXPORT);

        return view('sagres-export.index');
    }

    public function export(SagresExportRequest $request, ExportService $exportService): ResponseReturn
    {
        $exportContent = $exportService->export($request->all());

        $headers = [
            'Content-type' => 'text/xml',
            'Content-Disposition' => 'attachment; filename="Educacao.xml"',
            'Content-Length' => strlen($exportContent),
        ];

        return Response::make($exportContent, 200, $headers);
    }
}
