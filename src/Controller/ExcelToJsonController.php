<?php

namespace App\Controller;

use App\Entity\Subject;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExcelToJsonController extends AbstractController
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    #[Route('/upload', name: 'app_upload')]
    public function upload(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $file = $request->files->get('file');

            if ($file && $file->isValid()) {
                $spreadsheet = IOFactory::load($file->getPathname());
                $entityManager = $this->registry->getManagerForClass(Subject::class);

                $allData = [];

                $worksheets = iterator_to_array($spreadsheet->getWorksheetIterator());
                $lastWorksheet = end($worksheets);

                foreach ($worksheets as $worksheet) {
                    $sheetName = $worksheet->getTitle();

                    // Check if sheet name is "Histogramme", and skip it if true
                    if ($sheetName === 'Histogramme') {
                        continue;
                    }

                    $data = $worksheet->toArray();

                    if ($data) {
                        if ($worksheet !== $lastWorksheet) {
                            for ($i = 1; $i < count($data); ++$i) {
                                if (!empty($data[$i][4])) {
                                    if (empty($data[$i][1])) {
                                        $data[$i][1] = $data[$i - 1][1];
                                    }

                                    if (empty($data[$i][2])) {
                                        $data[$i][2] = $data[$i - 1][2];
                                    }
                                }
                            }

                            $allData[$sheetName] = $data;
                        }
                        $firstWeek = null;
                        foreach ($data[0] as $value) {
                            if (is_numeric($value)) {
                                $firstWeek = $value;
                                break;
                            }
                        }

                        $lastWeek = null;
                        for ($i = count($data[0]) - 1; $i >= 0; --$i) {
                            if (is_numeric($data[0][$i])) {
                                $lastWeek = $data[0][$i];
                                break;
                            }
                        }
                        foreach ($data as $row) {
                            $subject = new Subject();

                            // Check if subjectCode is empty
                            if (empty($row[1])) {
                                // Iterate backwards to find the first non-empty subjectCode above
                                for ($i = count($allData[$sheetName]) - 1; $i >= 0; --$i) {
                                    if (!empty($allData[$sheetName][$i][1])) {
                                        $subjectCode = $allData[$sheetName][$i][1];
                                        break;
                                    }
                                }

                                // Set subjectCode to the value from above (or null if not found)
                                $subject->setSubjectCode($subjectCode ?? null);
                            } else {
                                $subject->setSubjectCode($row[1]);
                            }

                            // Check if name is empty
                            if (empty($row[2])) {
                                // Iterate backwards to find the first non-empty name above
                                for ($i = count($allData[$sheetName]) - 1; $i >= 0; --$i) {
                                    if (!empty($allData[$sheetName][$i][2])) {
                                        $name = $allData[$sheetName][$i][2];
                                        break;
                                    }
                                }

                                // Set name to the value from above (or null if not found)
                                $subject->setName($name ?? null);
                            } else {
                                $subject->setName($row[2]);
                            }

                            $hourstotal = (int) $row[6];
                            $subject->setHoursTotal($hourstotal);
                            $subject->setFirstWeek($firstWeek);
                            $subject->setLastWeek($lastWeek);
                            $entityManager->persist($subject);
                        }
                    } else {
                        $this->addFlash('error', 'No data found in sheet: '.$sheetName);
                    }
                }
                $entityManager->flush();
            } else {
                $this->addFlash('error', 'Invalid file');
            }
        }

        return $this->render('subject/index.html.twig', [
            'data' => $allData ?? null,
        ]);
    }
}
