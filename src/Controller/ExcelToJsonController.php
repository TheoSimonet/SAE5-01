<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shuchkin\SimpleXLSX;


class ExcelToJsonController extends AbstractController
{
    #[Route('/subjects', name: 'app_subjects')]
    public function uploadFile(Request $request, ParameterBagInterface $parameterBag): Response
    {
        $uploadedFile = $request->files->get('file');

        if ($uploadedFile instanceof UploadedFile) {
            $filename = $uploadedFile->getClientOriginalName();

            $uploadedFile->move(
                $this->getParameter('uploads_directory'),
                $filename
            );

            if ($xlsx = SimpleXLSX::parse($this->getParameter('uploads_directory') . '/' . $filename)) {
                $data = $xlsx->rows();
                return new JsonResponse($data);
            } else {
                $error = SimpleXLSX::parseError();
                return new JsonResponse(['error' => $error], 400);
            }
        } else {
            return new JsonResponse(['error' => 'No file uploaded'], 400);
        }
    }
}
