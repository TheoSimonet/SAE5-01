<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Shuchkin\SimpleXLSX;
use Symfony\Component\Routing\Annotation\Route;

class ExcelToJsonController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    public function upload(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $file = $request->files->get('file');

            if ($file && $file->isValid()) {
                $spreadsheet = IOFactory::load($file->getPathname());

                $allData = [];

                foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                    $sheetName = $worksheet->getTitle();
                    $data = $worksheet->toArray();

                    if ($data) {
                        $allData[$sheetName] = $data;
                    } else {
                        $this->addFlash('error', 'No data found in sheet: ' . $sheetName);
                    }
                }
            } else {
                $this->addFlash('error', 'Invalid file');
            }
        }

        return $this->render('subject/index.html.twig', [
            'data' => $allData ?? null,
        ]);
    }
}
