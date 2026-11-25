<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class SchoolController extends Controller
{
    /**
     * @var array<int, array{slug: string, name: string, blurb: string, divisions: list<string>}>
     */
    private array $schools = [
        [
            'slug' => 'laboratory-medicine',
            'name' => 'Laboratory Medicine',
            'blurb' => 'Clinical diagnostics, microbiology, hematology, molecular biology, and laboratory excellence.',
            'divisions' => [
                'Laboratory Quality Management & Accreditation',
                'Clinical & Diagnostic Microbiology',
                'Clinical Parasitology',
                'Hematology & Transfusion Medicine',
                'Molecular Biology & Diagnostics',
            ],
        ],
        [
            'slug' => 'quality-patient-safety-accreditation',
            'name' => 'Quality Management, Patient Safety and Accreditation',
            'blurb' => 'Systems that protect patients and elevate institutional standards across healthcare.',
            'divisions' => [
                'Quality Systems',
                'Patient Safety',
                'Accreditation Pathways',
            ],
        ],
        [
            'slug' => 'healthcare-informatics-digital-health',
            'name' => 'Healthcare Informatics and Digital Health',
            'blurb' => 'Data, digital workflows, and intelligent systems for modern care delivery.',
            'divisions' => [
                'Health Informatics',
                'Digital Health',
                'Clinical Decision Support',
            ],
        ],
        [
            'slug' => 'management-leadership-governance',
            'name' => 'Management, Leadership and Governance',
            'blurb' => 'Leadership craft for healthcare institutions navigating complexity and change.',
            'divisions' => [
                'Healthcare Management',
                'Leadership',
                'Governance',
            ],
        ],
    ];

    public function index(): Response
    {
        return Inertia::render('Schools/Index', [
            'schools' => $this->schools,
            'canLogin' => true,
            'canRegister' => true,
        ]);
    }

    public function show(string $school): Response
    {
        $selected = collect($this->schools)->firstWhere('slug', $school);

        abort_if($selected === null, 404);

        return Inertia::render('Schools/Show', [
            'school' => $selected,
            'canLogin' => true,
            'canRegister' => true,
        ]);
    }
}
