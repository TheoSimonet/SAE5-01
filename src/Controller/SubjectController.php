<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Subject;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubjectController extends AbstractController
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

                $subjectRepository = $entityManager->getRepository(Subject::class);
                $subjectRepository->createQueryBuilder('s')
                    ->delete()
                    ->getQuery()
                    ->execute();

                $allData = [];

                $worksheets = iterator_to_array($spreadsheet->getWorksheetIterator());
                $lastWorksheet = end($worksheets);

                foreach ($worksheets as $worksheet) {
                    $sheetName = $worksheet->getTitle();

                    if ('Histogramme' === $sheetName) {
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
                            if (empty($row[4]) || str_starts_with($row[1], 'BUT')) {
                                continue;
                            }

                            $subject = new Subject();

                            if (empty($row[1]) && !empty($row[3])) {
                                for ($i = count($allData[$sheetName]) - 1; $i >= 0; --$i) {
                                    if (!empty($allData[$sheetName][$i][1])) {
                                        $subjectCode = $allData[$sheetName][$i][1];
                                        break;
                                    }
                                }

                                $subject->setSubjectCode($subjectCode ?? null);
                            } else {
                                $subject->setSubjectCode($row[1]);
                            }

                            if (empty($row[2])) {
                                for ($i = count($allData[$sheetName]) - 1; $i >= 0; --$i) {
                                    if (!empty($allData[$sheetName][$i][2])) {
                                        $name = $allData[$sheetName][$i][2];
                                        break;
                                    }
                                }

                                $subject->setName($name ?? null);
                            } else {
                                $subject->setName($row[2]);
                            }

                            $hourstotal = (int) $row[5];
                            $subject->setHoursTotal($hourstotal);
                            $subject->setFirstWeek($firstWeek);
                            $subject->setLastWeek($lastWeek);
                            $entityManager->persist($subject);

                            $group = new Group();
                            $group->setType($row[4]);


                            $subjectRepository = $entityManager->getRepository(Subject::class);
                            $subject = $subjectRepository->findOneBy(['subjectCode' => $row[4]]);

                            if ($subject) {
                                $group->setSubject($subject);
                                $subject->addGroup($group);
                                $entityManager->persist($group);
                            } else {
                                $this->addFlash('error', 'No subject found for group: '.$row[4]);
                            }
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
