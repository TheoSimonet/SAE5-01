<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ExcelToJsonController extends AbstractController
{
    #[Route('/convert-excel-to-json', name: 'app_convert_excel_to_json')]

    public function convertExcelToJson(Request $request)
    {
        $excelFile = $request->files->get('excel_file');

        if ($excelFile) {
            $spreadsheet = IOFactory::load($excelFile);

            $worksheet = $spreadsheet->getActiveSheet();

            $data = [];
            foreach ($worksheet->toArray() as $row) {
                $data[] = $row;
            }

            $jsonData = json_encode($data);

            return new JsonResponse($jsonData, 200, [], true);
        } else {
            return new JsonResponse(['error' => 'Fichier Excel non trouvé.'], 400);
        }
    }
}
