<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Level2;
use App\Models\Level3;
use App\Models\Level4;
use App\Models\User;
use App\Models\Institution;
use App\Models\Application;
use App\Models\ApplicationLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InstitutionFacilities;
use App\Models\InstitutionFacultyInfo;
use App\Models\InstitutionOwnerDetail;
use Yajra\DataTables\Facades\DataTables;
use App\Models\InstitutionInfrastructure;
use App\Models\InstitutionPrincipalDetail;
use App\Models\InstitutionEnrollmentCount;
use App\Models\InstitutionCurriculumAdopted;
use App\Models\InstitutionLaboratoryDetails;
use App\Models\TransparencyPublicDisclosures;
use App\Http\Requests\StoreInstitutionRequest;
use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\InstitutionFacultyQualification;
use App\Models\InstitutionBoardOfDirectorsOwner;
use App\Models\FeeChallan;
use App\Models\FeeStructure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $institutions = Institution::with(['level_2:id,name', 'level_3:id,name', 'level_4:id,name', 'activeApplication.feeChallan']);

            $roleName = roleName();
            $user = Auth::user();

            if ($roleName == 'School Owner') {
                $institutions->where('created_by', $user->id);
                // ->whereIn('activeApplication.status', ['Submitted', 'Approved', 'Rejected'])
                // ->where(function ($q) {
                //     $q->whereDoesntHave('activeApplication.feeChallan', function ($sub) {
                //         $sub->active();
                //     })
                //     ->orWhereHas('activeApplication.feeChallan', function ($sub) {
                //         $sub->active()->where('status', 1);
                //     });

                // });

            } elseif ($roleName == 'DEO') {
                $institutions->where('level_2_id', $user->level_2_id)
                    ->where('level_3_id', $user->level_3_id)
                    ->whereHas('activeApplication', function ($q) {
                        $q->whereIn('status', ['Submitted', 'Assigned back to DEO']);
                    });
            } elseif ($roleName == 'DED') {
                $institutions->whereHas('level_2', function ($query) use ($user) {
                    $query->where('level_1_id', $user->level_1_id);
                })
                    ->whereHas('activeApplication', function ($q) {
                        $q->whereIn('status', ['Forward to DED', 'Assigned back to DED']);
                    });
            } elseif ($roleName == 'DGS') {
                $institutions->whereHas('activeApplication', function ($q) {
                    $q->whereIn('status', ['Forward to DGS']);
                });
            }

            if (!$request->filled('order')) {
                $institutions->orderBy('id', 'ASC');
            }

            return DataTables::of($institutions)
                ->editColumn('status', function ($institution) {
                    if ($institution->is_active == 0) {
                        $status = getStatusBadge($institution->is_active);
                    } else if ($institution->status != 'Pending' && $institution->activeApplication->status == 'Approved') {

                        if ($institution->status == 'Approved') {
                            $status = '<span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-success" >Approved</a></span>';
                        } elseif ($institution->status == 'Rejected' || $institution->status == 'Closed' || $institution->status == 'E-License Expired') {
                            $status = '<span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-danger" >' . $institution->status . '</a></span>';
                        } else {
                            $status = '<span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-info" >' . $institution->status . '</a></span>';
                        }
                    } else {
                        $applicationStatus = $institution->activeApplication->status;

                        if ($applicationStatus == 'Approved') {
                            $status = '<span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-success" >Approved</a></span>';
                        } elseif ($applicationStatus == 'Rejected') {
                            $status = '<span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-danger" >' . $applicationStatus . '</a></span>';
                        } else {
                            $status = '<span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-info" >' . $applicationStatus . '</a></span>';
                        }
                    }
                    return $status;
                })
                ->addColumn('fee_status', function ($institution) {
                    return getFeeStatusBadge($institution->activeApplication->fee_status);
                })
                ->addColumn('action', function ($institution) {
                    $applicationStatus = $institution->activeApplication->status;
                    $feeStatus = $institution->activeApplication->fee_status;

                    $actions = '<td><div class="overlay-edit">';

                    if (auth()->user()->can('View Institution Status')) {
                        $actions .= '<button type="button" onclick="showStatusModal(' . $institution->id . ')" class="btn btn-icon btn-info me-1" data-toggle="modal" data-target="#statusModal"><i class="feather icon-map"></i></button>';
                    }

                    if (auth()->user()->can('Update Institution') && ($applicationStatus == 'Approved' || $applicationStatus == 'Rejected')) {
                        $actions .= '<a href="' . route('institutions.edit', $institution->uuid) . '" class="btn btn-icon btn-secondary me-1"><i class="feather icon-edit-2"></i></a>';
                    }

                    if (auth()->user()->can('View Institution') || (auth()->user()->can('Review Institution') && $feeStatus == 'Paid')) {
                        $actions .= '<a href="' . route('institutions.show', $institution->uuid) . '" class="btn btn-icon btn-info me-1"><i class="feather icon-eye"></i></a>';
                    }

                    if (auth()->user()->can('Institution Challan') && $applicationStatus == 'Submitted' && $feeStatus == 'Unpaid') {
                        $actions .= '<a href="' . route('institutions.challan', $institution->uuid) . '" target="_blank" class="btn btn-icon btn-primary me-1" title="Generate Challan"><i class="feather icon-credit-card"></i></a>';
                    }

                    if (auth()->user()->can('Institution Challan Mark Paid') && !is_null($institution->activeApplication->feeChallan) && $feeStatus == 'Unpaid') {
                        $actions .= '<a href="' . route('institutions.markPaidChallan', $institution->uuid) . '" title="Mark as Paid" class="btn btn-icon btn-success mark-paid-voucher"><i class="fas fa-dollar-sign"></i></a>';
                    }

                    if (auth()->user()->can('Institution Certificate') && $applicationStatus == 'Approved') {
                        $actions .= '<a href="' . route('institutions.certificate', $institution->uuid) . '" target="_blank" class="btn btn-icon btn-success me-1" title="Certificate"><i class="feather icon-file-text"></i></a>';
                    }

                    if (auth()->user()->can('Closed Institution') && $institution->status == 'Approved') {
                        $actions .= '<a href="' . route('institutions.closed', $institution->uuid) . '" class="btn btn-icon ' . ($institution->is_active == 1 ? 'btn-danger' : 'btn-success') . ' btn-status me-1" title="Closed Institution">' . '<i class="feather icon-x"></i></a>';
                    }

                    if (auth()->user()->can('Delete Institution') && $institution->status == 'Submitted' && $feeStatus == 'Unpaid') {
                        $actions .= '<a href="' . route('institutions.destroy', $institution->uuid) . '" class="btn btn-icon btn-danger btn-delete"><i class="feather icon-trash-2"></i></a>';
                    }

                    if (auth()->user()->can('Renew Institution') && $institution->status == 'E-License Expired') {
                        $actions .= '<a href="' . route('institutions.renew', $institution->uuid) . '" class="btn btn-icon btn-success renewal-request"><i class="feather icon-refresh-cw"></i></a>';
                    }
                    $actions .= '</div></td>';

                    return $actions;
                })
                ->rawColumns(['status', 'fee_status', 'action'])
                ->make(true);
        }
        return view('institutions.index');
    }

    public function create()
    {
        // Fetch all level data
        $districts = Level2::active()->pluck('name', 'id');
        $tehsils = Level3::active()->pluck('name', 'id');
        $villages = Level4::active()->pluck('name', 'id');
        $grades = Grade::pluck('name', 'id');

        return view('institutions.create', ['institution' => null], get_defined_vars());
    }

    public function store(StoreInstitutionRequest $request)
    {

        // dump($request->all());
        $validated = $request->validated();
        DB::beginTransaction();

        try {
            // dd($request->all());    
            $totalFaculty = $validated['male_faculty'] + $validated['female_faculty'];
            $totalStudents = $validated['male_students'] + $validated['female_students'];

            $str = $totalFaculty > 0 ? round($totalStudents / $totalFaculty, 2) : 0;
            $institution = Institution::create([
                'name' => $validated['name'],
                'level_2_id' => $validated['level_2_id'],
                'level_3_id' => $validated['level_3_id'],
                'level_4_id' => $validated['level_4_id'] ?? null,
                'institution_nature' => $validated['institution_nature'] ?? null,
                'institution_level' => $validated['institution_level'] ?? null,
                'management_nature' => $validated['management_nature'] ?? null,
                'institution_type' => $validated['institution_type'] ?? null,
                'teaching_level' => $validated['teaching_level'] ?? null,
                'institution_medium' => $validated['institution_medium'] ?? null,
                'institution_gender' => $validated['institution_gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'institution_official_web_url' => $validated['institution_official_web_url'] ?? null,
                'institution_official_email' => $validated['institution_official_email'] ?? null,
                'institution_phone' => $validated['institution_phone'] ?? null,
                'institution_fax' => $validated['institution_fax'] ?? null,
                'institution_public_email' => $validated['institution_public_email'] ?? null,
                'board_of_directors_owners' => $validated['board_of_directors_owners'],
                'male_faculty' => $validated['male_faculty'],
                'female_faculty' => $validated['female_faculty'],
                'total_faculty' => $validated['male_faculty'] + $validated['female_faculty'],
                'institution_str' => $str,
                'examination_board' => $validated['examination_board'] ?? null,
                'national_education_policy_adherence' => $validated['national_education_policy_adherence'] ?? null,
                'other_allied_facilities' => $validated['other_allied_facilities'] ?? 'no',
            ]);

            //insert record in Application table
            Application::create([
                'type' => 'Registration',
                'institution_id' => $institution->id,
                'status' => 'Submitted',
            ]);

            // $institution->boardOfDirectorsOwners()->delete();

            if ($validated['board_of_directors_owners']) {
                foreach ($validated['board_of_directors'] as $director) {
                    $institution->boardOfDirectorsOwners()->create([
                        'name' => $director['name'],
                        'designation' => $director['designation'] ?? null,
                    ]);
                }
            }

            if (!empty($validated['faculty'])) {
                foreach ($validated['faculty'] as $index => $facultyData) {
                    $cvPath = null;

                    // if (isset($facultyData['cv']) && $facultyData['cv'] instanceof \Illuminate\Http\UploadedFile) {
                    //     $cvPath = $facultyData['cv']->store('faculty_cvs', 'public');
                    // }

                    $faculty = $institution->facultyInfos()->create([
                        'name' => $facultyData['name'],
                        'cnic' => $facultyData['cnic'],
                        // 'cv' => $cvPath,
                    ]);

                    if ($request->hasFile("faculty.$index.cv")) {
                        $faculty->addMedia($request->file("faculty.$index.cv"))
                            ->toMediaCollection('cv', 'faculty');
                    }

                    if (!empty($facultyData['qualification'])) {
                        InstitutionFacultyQualification::create([
                            'institution_id' => $institution->id,
                            'faculty_id' => $faculty->id,
                            'qualification' => $facultyData['qualification'],
                        ]);
                    }
                }
            }

            InstitutionOwnerDetail::create([
                'institution_id' => $institution->id,
                'name' => $validated['owner']['name'],
                'designation' => $validated['owner']['designation'] ?? null,
                'mobile' => $validated['owner']['mobile'] ?? null,
                'phone' => $validated['owner']['phone'] ?? null,
                'fax' => $validated['owner']['fax'] ?? null,
                'email' => $validated['owner']['email'] ?? null,
            ]);

            InstitutionPrincipalDetail::create([
                'institution_id' => $institution->id,
                'name' => $validated['principal']['name'],
                'designation' => $validated['principal']['designation'] ?? null,
                'mobile' => $validated['principal']['mobile'] ?? null,
                'phone' => $validated['principal']['phone'] ?? null,
                'fax' => $validated['principal']['fax'] ?? null,
                'email' => $validated['principal']['email'] ?? null,
            ]);
            InstitutionEnrollmentCount::create([
                'institution_id' => $institution->id,
                'grade_id' => $validated['grade_id'],
                'male_students' => $validated['male_students'],
                'female_students' => $validated['female_students'],
                'total_students' => $totalStudents,
            ]);

            if (!empty($validated['curriculums'])) {
                foreach ($validated['curriculums'] as $gradeId => $curriculum) {
                    // Skip if empty or null value (optional)
                    if (empty($curriculum)) {
                        continue;
                    }

                    InstitutionCurriculumAdopted::create([
                        'institution_id' => $institution->id,
                        'grade_id' => $gradeId,
                        'curriculum_adopted' => $curriculum,
                    ]);
                }
            }

            InstitutionInfrastructure::create([
                'institution_id' => $institution->id,
                'building_type' => $validated['infrastructure']['building_type'],
                'building_possession' => $validated['infrastructure']['building_possession'],
                'area_in_kanal' => $validated['infrastructure']['area_in_kanal'] ?? null,
                'area_in_marla' => $validated['infrastructure']['area_in_marla'] ?? null,
                'no_of_classrooms' => $validated['infrastructure']['no_of_classrooms'] ?? null,
            ]);

            $facility = $institution->institutionFacility()->create([
                'has_auditorium' => $validated['facilities']['has_auditorium'] ?? 0,
                'has_conference_room' => $validated['facilities']['has_conference_room'] ?? 0,
                'has_tutorial_room' => $validated['facilities']['has_tutorial_room'] ?? 0,
                'has_examination_hall' => $validated['facilities']['has_examination_hall'] ?? 0,
                'has_other' => $validated['facilities']['has_other'] ?? 0,
                'other_facilities' => $validated['facilities']['other_facilities'] ?? null,
                'has_library' => $validated['library']['has_library'] ?? 0,
                'no_of_books' => $validated['library']['no_of_books'] ?? null,
                'no_of_subscription_e_library' => $validated['library']['no_of_subscription_e_library'] ?? null,
                'no_of_subscription_e_journals' => $validated['library']['no_of_subscription_e_journals'] ?? null,
                'other_instructional_material' => $validated['other_resources']['other_instructional_material'],
                'has_atlas' => $validated['other_resources']['has_atlas'] ?? 0,
                'has_dictionaries' => $validated['other_resources']['has_dictionaries'] ?? 0,
                'has_encyclopedia' => $validated['other_resources']['has_encyclopedia'] ?? 0,
                'has_daily_newspaper' => $validated['other_resources']['has_daily_newspaper'] ?? 0,
                'has_magazines' => $validated['other_resources']['has_magazines'] ?? 0,
            ]);


            InstitutionLaboratoryDetails::create([
                'institution_id' => $institution->id,

                // SCIENCE LAB
                'science_laboratories' => $request->science_laboratories === 'yes' ? 1 : 0,
                'physic_laboratories' => $request->physic_laboratories === 'yes' ? 1 : 0,
                'no_of_physic_laboratory_staff' => $request->no_of_physic_laboratory_staff,
                'has_bunsen_burner' => $request->has_bunsen_burner ?? 0,
                'has_test_tubes' => $request->has_test_tubes ?? 0,
                'physic_has_microscope' => $request->physic_has_microscope ?? 0,
                'has_funnels' => $request->has_funnels ?? 0,
                'physics_has_eye_wash' => $request->physics_has_eye_wash ?? 0,
                'physics_has_fume_hood' => $request->physics_has_fume_hood ?? 0,
                'physics_has_disposable_masks' => $request->physics_has_disposable_masks ?? 0,
                'physics_has_lab_coat' => $request->physics_has_lab_coat ?? 0,

                // BIO LAB
                'bio_laboratories' => $request->bio_laboratories === 'yes' ? 1 : 0,
                'no_of_bio_laboratory_staff' => $request->no_of_bio_laboratory_staff,
                'has_siring' => $request->has_siring ?? 0,
                'has_dropper' => $request->has_dropper ?? 0,
                'has_retort' => $request->has_retort ?? 0,
                'has_beaker' => $request->has_beaker ?? 0,
                'bio_has_eye_wash' => $request->bio_has_eye_wash ?? 0,
                'bio_has_fume_hood' => $request->bio_has_fume_hood ?? 0,
                'bio_has_disposable_masks' => $request->bio_has_disposable_masks ?? 0,
                'bio_has_lab_coat' => $request->bio_has_lab_coat ?? 0,

                // CHEMISTRY LAB 
                'chemistry_laboratories' => $request->chemistry_laboratories === 'yes' ? 1 : 0,
                'no_of_chemistry_laboratory_staff' => $request->no_of_chemistry_laboratory_staff,
                'has_ph_strip' => $request->has_ph_strip ?? 0,
                'has_hot_plate' => $request->has_hot_plate ?? 0,
                'has_centrifuge' => $request->has_centrifuge ?? 0,
                'chemistry_has_microscope' => $request->chemistry_has_microscope ?? 0,
                'chemistry_has_eye_wash' => $request->chemistry_has_eye_wash ?? 0,
                'chemistry_has_fume_hood' => $request->chemistry_has_fume_hood ?? 0,
                'chemistry_has_disposable_masks' => $request->chemistry_has_disposable_masks ?? 0,
                'chemistry_has_lab_coat' => $request->chemistry_has_lab_coat ?? 0,

                // COMPUTER LAB
                'computer_laboratories' => $request->computer_laboratories === 'yes' ? 1 : 0,
                'no_of_computers' => $request->no_of_computers,
                'has_computer' => $request->has_computer ?? 0,
                'has_modems' => $request->has_modems ?? 0,
                'has_printer' => $request->has_printer ?? 0,
                'has_scanner' => $request->has_scanner ?? 0,
                'has_laptops' => $request->has_laptops ?? 0,
            ]);

            TransparencyPublicDisclosures::create([
                'institution_id' => $institution->id,
                'fee_structure_public' => $validated['fee_structure_public'] === 'yes' ? 1 : 0,
                'scholarship_policy_public' => $validated['scholarship_policy_public'] === 'yes' ? 1 : 0,
                'other_income_source' => $validated['other_income_source'] === 'yes' ? 1 : 0,
                'record_income_expenditure' => $validated['record_income_expenditure'] === 'yes' ? 1 : 0,
                'financial_accounts_audited' => $validated['financial_accounts_audited'] === 'yes' ? 1 : 0,
                'academic_calendar_public' => $validated['academic_calendar_public'] === 'yes' ? 1 : 0,

                'faculty_to_admin_staff_ratio' => $validated['faculty_to_admin_staff_ratio'],
                'extra_curricular_activities' => $validated['extra_curricular_activities'],
                'extracurricular_facilities' => $validated['extracurricular_facilities']
            ]);

            DB::commit();

            return redirect()
                ->route('institutions.index')
                ->with('success', 'Institution Register successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to save data: ' . $e->getMessage()]);
        }
    }

    public function show(Institution $institution)
    {
        $title = (roleName() == 'School Owner') ? 'View' : 'Review';

        $institution->load([
            'boardOfDirectorsOwners',
            'facultyInfos.qualifications',
            'principalDetail',
            'facultyQualifications',
            'enrollmentCounts',
            'curriculumsAdopted',
            'infrastructure',
            'institutionFacility',
            'laboratoryDetails',
            'transparencyPublicDisclosure',
            // 'institutionGrades',
            'activeApplication'
        ]);
        $selectedDistrict = $institution->level_2_id;
        $selectedTehsil = $institution->level_3_id;
        $selectedVillage = $institution->level_4_id;

        $districts = Level2::active()->pluck('name', 'id');
        $tehsils = Level3::where('level_2_id', $selectedDistrict)->pluck('name', 'id');
        $villages = Level4::where('level_2_id', $selectedDistrict)->where('level_3_id', $selectedTehsil)->pluck('name', 'id');
        $grades = Grade::pluck('name', 'id');

        $enrollmentCount = $institution->enrollmentCounts()->first();
        $selectedGradeId = $enrollmentCount ? $enrollmentCount->grade_id : null;

        $selectedCurriculums = InstitutionCurriculumAdopted::where('institution_id', $institution->id)
            ->pluck('curriculum_adopted', 'grade_id')->toArray();

        $facultyData = $institution->facultyInfos->map(function ($faculty) use ($institution) {
            $qualification = $institution->facultyQualifications
                ->firstWhere('faculty_id', $faculty->id);

            return [
                'id' => $faculty->id,
                'name' => $faculty->name,
                'cnic' => $faculty->cnic,
                'qualification' => $qualification ? $qualification->qualification : null,
                // 'cv_path' => $faculty->cv_path ?? null,
                'cv_path' => $faculty->cv ?? null,
            ];
        })->toArray();

        return view('institutions.view', get_defined_vars() + ['facultyData' => $facultyData]);
    }

    public function edit(Institution $institution)
    {
        $institution->load([
            'boardOfDirectorsOwners',
            'facultyInfos.qualifications',
            'principalDetail',
            'facultyQualifications',
            'enrollmentCounts',
            'curriculumsAdopted',
            'infrastructure',
            'institutionFacility',
            'laboratoryDetails',
            'transparencyPublicDisclosure',
            // 'institutionGrades',
        ]);
        $selectedDistrict = $institution->level_2_id;
        $selectedTehsil = $institution->level_3_id;
        $selectedVillage = $institution->level_4_id;

        $districts = Level2::active()->pluck('name', 'id');
        $tehsils = Level3::where('level_2_id', $selectedDistrict)->pluck('name', 'id');
        $villages = Level4::where('level_2_id', $selectedDistrict)->where('level_3_id', $selectedTehsil)->pluck('name', 'id');
        $grades = Grade::pluck('name', 'id');

        $enrollmentCount = $institution->enrollmentCounts()->first();
        $selectedGradeId = $enrollmentCount ? $enrollmentCount->grade_id : null;

        $selectedCurriculums = InstitutionCurriculumAdopted::where('institution_id', $institution->id)
            ->pluck('curriculum_adopted', 'grade_id')->toArray();

        $facultyData = $institution->facultyInfos->map(function ($faculty) use ($institution) {
            $qualification = $institution->facultyQualifications
                ->firstWhere('faculty_id', $faculty->id);

            return [
                'id' => $faculty->id,
                'name' => $faculty->name,
                'cnic' => $faculty->cnic,
                'qualification' => $qualification ? $qualification->qualification : null,
                // 'cv_path' => $faculty->cv_path ?? null,
                'cv_path' => $faculty->cv ?? null,
            ];
        })->toArray();

        return view('institutions.edit', get_defined_vars() + ['facultyData' => $facultyData]);
    }

    public function update(UpdateInstitutionRequest $request, Institution $institution)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Update main institution data
            $updateData = [
                'name' => $validated['name'],
                'level_2_id' => $validated['level_2_id'],
                'level_3_id' => $validated['level_3_id'],
                'level_4_id' => $validated['level_4_id'],
                'institution_nature' => $validated['institution_nature'],
                'institution_level' => $validated['institution_level'],
                'management_nature' => $validated['management_nature'],
                'institution_type' => $validated['institution_type'],
                'teaching_level' => $validated['teaching_level'],
                'institution_medium' => $validated['institution_medium'],
                'institution_gender' => $validated['institution_gender'],
                'address' => $validated['address'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'institution_official_web_url' => $validated['institution_official_web_url'],
                'institution_official_email' => $validated['institution_official_email'],
                'institution_phone' => $validated['institution_phone'],
                'institution_fax' => $validated['institution_fax'],
                'institution_public_email' => $validated['institution_public_email'],
                'board_of_directors_owners' => $validated['board_of_directors_owners'],
                'examination_board' => $validated['examination_board'],
                'national_education_policy_adherence' => $validated['national_education_policy_adherence'],
                'other_allied_facilities' => $validated['other_allied_facilities'],
            ];

            // Update faculty counts
            if (isset($validated['male_faculty']) && isset($validated['female_faculty'])) {
                $updateData['male_faculty'] = $validated['male_faculty'];
                $updateData['female_faculty'] = $validated['female_faculty'];
                $updateData['total_faculty'] = $validated['male_faculty'] + $validated['female_faculty'];
            }

            // Recalculate STR if students data provided
            if (isset($validated['male_students']) && isset($validated['female_students'])) {
                $totalStudents = $validated['male_students'] + $validated['female_students'];
                $updateData['institution_str'] = $updateData['total_faculty'] > 0 ?
                    round($totalStudents / $updateData['total_faculty'], 2) : 0;
            }

            $institution->update($updateData);

            // Update Board of Directors
            $institution->boardOfDirectorsOwners()->delete();
            if ($validated['board_of_directors_owners'] && !empty($validated['board_of_directors'])) {
                foreach ($validated['board_of_directors'] as $director) {
                    $institution->boardOfDirectorsOwners()->create([
                        'name' => $director['name'],
                        'designation' => $director['designation'] ?? null,
                    ]);
                }
            }

            // Update Owner Details
            if (isset($validated['owner'])) {
                $ownerData = [
                    'name' => $validated['owner']['name'],
                    'designation' => $validated['owner']['designation'] ?? null,
                    'mobile' => $validated['owner']['mobile'] ?? null,
                    'phone' => $validated['owner']['phone'] ?? null,
                    'fax' => $validated['owner']['fax'] ?? null,
                    'email' => $validated['owner']['email'] ?? null,
                ];

                // Use firstOrCreate to handle both create and update
                $institution->ownerDetail()->firstOrCreate([], $ownerData)->update($ownerData);
            }

            // Update Principal Details 
            if (isset($validated['principal'])) {
                $principalData = [
                    'name' => $validated['principal']['name'],
                    'designation' => $validated['principal']['designation'] ?? null,
                    'mobile' => $validated['principal']['mobile'] ?? null,
                    'phone' => $validated['principal']['phone'] ?? null,
                    'fax' => $validated['principal']['fax'] ?? null,
                    'email' => $validated['principal']['email'] ?? null,
                ];

                $institution->principalDetail()->firstOrCreate([], $principalData)->update($principalData);
            }

            // Update Faculty Information
            if (isset($validated['faculty'])) {

                $submittedFacultyIds = [];

                foreach ($validated['faculty'] as $index => $facultyData) {

                    // Find faculty by CNIC or create new
                    $faculty = $institution->facultyInfos()->where('cnic', $facultyData['cnic'])->first();

                    // Handle CV upload
                    // if (isset($facultyData['cv']) && $facultyData['cv'] instanceof \Illuminate\Http\UploadedFile) {
                    //     $cvPath = $facultyData['cv']->store('faculty_cvs', 'public');
                    // } else {
                    //     $cvPath = $faculty ? $faculty->cv : null;
                    // }

                    if ($faculty) {
                        $faculty->update([
                            'name' => $facultyData['name'],
                            'cnic' => $facultyData['cnic'],
                            // 'cv' => $cvPath,
                        ]);
                    } else {
                        $faculty = $institution->facultyInfos()->create([
                            'name' => $facultyData['name'],
                            'cnic' => $facultyData['cnic'],
                            // 'cv' => $cvPath,
                        ]);
                    }

                    if ($request->hasFile("faculty.$index.cv")) {
                        $faculty->clearMediaCollection('cv');

                        $faculty->addMedia($request->file("faculty.$index.cv"))
                            ->toMediaCollection('cv', 'faculty');
                    }

                    // Store faculty id for later cleanup
                    $submittedFacultyIds[] = $faculty->id;

                    // Update or create qualification for this faculty
                    if (!empty($facultyData['qualification'])) {
                        InstitutionFacultyQualification::updateOrCreate(
                            [
                                'institution_id' => $institution->id,
                                'faculty_id' => $faculty->id,
                            ],
                            [
                                'qualification' => $facultyData['qualification'],
                                'updated_by' => auth()->id(),
                            ]
                        );
                    }
                }

                // DELETE faculty records for this institution which are NOT in submitted faculty ids
                $institution->facultyInfos()
                    ->whereNotIn('id', $submittedFacultyIds)
                    ->delete();

                // DELETE qualification records for this institution which are NOT linked to submitted faculty ids
                InstitutionFacultyQualification::where('institution_id', $institution->id)
                    ->whereNotIn('faculty_id', $submittedFacultyIds)
                    ->delete();
            }


            // Update Enrollment Counts
            if (isset($validated['grade_id']) && isset($validated['male_students']) && isset($validated['female_students'])) {
                $totalStudents = $validated['male_students'] + $validated['female_students'];
                $enrollmentData = [
                    'grade_id' => $validated['grade_id'],
                    'male_students' => $validated['male_students'],
                    'female_students' => $validated['female_students'],
                    'total_students' => $totalStudents,
                ];

                $institution->enrollmentCounts()->firstOrCreate([], $enrollmentData)->update($enrollmentData);
            }

            // Update Curriculums
            if (isset($validated['curriculums'])) {
                $institution->curriculumsAdopted()->delete();

                foreach ($validated['curriculums'] as $gradeId => $curriculum) {
                    if (!empty($curriculum)) {
                        InstitutionCurriculumAdopted::create([
                            'institution_id' => $institution->id,
                            'grade_id' => $gradeId,
                            'curriculum_adopted' => $curriculum,
                        ]);
                    }
                }
            }

            // Update Infrastructure
            if (isset($validated['infrastructure'])) {
                $infrastructureData = [
                    'building_type' => $validated['infrastructure']['building_type'],
                    'building_possession' => $validated['infrastructure']['building_possession'],
                    'area_in_kanal' => $validated['infrastructure']['area_in_kanal'] ?? null,
                    'area_in_marla' => $validated['infrastructure']['area_in_marla'] ?? null,
                    'no_of_classrooms' => $validated['infrastructure']['no_of_classrooms'] ?? null,
                ];

                $institution->infrastructure()->firstOrCreate([], $infrastructureData)->update($infrastructureData);
            }

            // Update Facilities
            if (isset($validated['facilities']) || isset($validated['library']) || isset($validated['other_resources'])) {
                $facilityData = [
                    'has_auditorium' => $validated['facilities']['has_auditorium'] ?? 0,
                    'has_conference_room' => $validated['facilities']['has_conference_room'] ?? 0,
                    'has_tutorial_room' => $validated['facilities']['has_tutorial_room'] ?? 0,
                    'has_examination_hall' => $validated['facilities']['has_examination_hall'] ?? 0,
                    'has_other' => $validated['facilities']['has_other'] ?? 0,
                    'other_facilities' => $validated['facilities']['other_facilities'] ?? null,
                    'has_library' => $validated['library']['has_library'] ?? 0,
                    'no_of_books' => $validated['library']['no_of_books'] ?? null,
                    'no_of_subscription_e_library' => $validated['library']['no_of_subscription_e_library'] ?? null,
                    'no_of_subscription_e_journals' => $validated['library']['no_of_subscription_e_journals'] ?? null,
                    'other_instructional_material' => $validated['other_resources']['other_instructional_material'] ?? 0,
                    'has_atlas' => $validated['other_resources']['has_atlas'] ?? 0,
                    'has_dictionaries' => $validated['other_resources']['has_dictionaries'] ?? 0,
                    'has_encyclopedia' => $validated['other_resources']['has_encyclopedia'] ?? 0,
                    'has_daily_newspaper' => $validated['other_resources']['has_daily_newspaper'] ?? 0,
                    'has_magazines' => $validated['other_resources']['has_magazines'] ?? 0,
                ];

                $institution->institutionFacility()->firstOrCreate([], $facilityData)->update($facilityData);
            }

            // Update Laboratory Details
            if (isset($validated['science_laboratories'])) {
                $labData = [
                    'science_laboratories' => $request->science_laboratories === 'yes' ? 1 : 0,
                    'physic_laboratories' => $request->physic_laboratories === 'yes' ? 1 : 0,
                    'no_of_physic_laboratory_staff' => $request->no_of_physic_laboratory_staff,
                    'has_bunsen_burner' => $request->has_bunsen_burner ?? 0,
                    'has_test_tubes' => $request->has_test_tubes ?? 0,
                    'physic_has_microscope' => $request->physic_has_microscope ?? 0,
                    'has_funnels' => $request->has_funnels ?? 0,
                    'physics_has_eye_wash' => $request->physics_has_eye_wash ?? 0,
                    'physics_has_fume_hood' => $request->physics_has_fume_hood ?? 0,
                    'physics_has_disposable_masks' => $request->physics_has_disposable_masks ?? 0,
                    'physics_has_lab_coat' => $request->physics_has_lab_coat ?? 0,
                    'bio_laboratories' => $request->bio_laboratories === 'yes' ? 1 : 0,
                    'no_of_bio_laboratory_staff' => $request->no_of_bio_laboratory_staff,
                    'has_siring' => $request->has_siring ?? 0,
                    'has_dropper' => $request->has_dropper ?? 0,
                    'has_retort' => $request->has_retort ?? 0,
                    'has_beaker' => $request->has_beaker ?? 0,
                    'bio_has_eye_wash' => $request->bio_has_eye_wash ?? 0,
                    'bio_has_fume_hood' => $request->bio_has_fume_hood ?? 0,
                    'bio_has_disposable_masks' => $request->bio_has_disposable_masks ?? 0,
                    'bio_has_lab_coat' => $request->bio_has_lab_coat ?? 0,
                    'chemistry_laboratories' => $request->chemistry_laboratories === 'yes' ? 1 : 0,
                    'no_of_chemistry_laboratory_staff' => $request->no_of_chemistry_laboratory_staff,
                    'has_ph_strip' => $request->has_ph_strip ?? 0,
                    'has_hot_plate' => $request->has_hot_plate ?? 0,
                    'has_centrifuge' => $request->has_centrifuge ?? 0,
                    'chemistry_has_microscope' => $request->chemistry_has_microscope ?? 0,
                    'chemistry_has_eye_wash' => $request->chemistry_has_eye_wash ?? 0,
                    'chemistry_has_fume_hood' => $request->chemistry_has_fume_hood ?? 0,
                    'chemistry_has_disposable_masks' => $request->chemistry_has_disposable_masks ?? 0,
                    'chemistry_has_lab_coat' => $request->chemistry_has_lab_coat ?? 0,
                    'computer_laboratories' => $request->computer_laboratories === 'yes' ? 1 : 0,
                    'no_of_computers' => $request->no_of_computers,
                    'has_computer' => $request->has_computer ?? 0,
                    'has_modems' => $request->has_modems ?? 0,
                    'has_printer' => $request->has_printer ?? 0,
                    'has_scanner' => $request->has_scanner ?? 0,
                    'has_laptops' => $request->has_laptops ?? 0,
                ];

                $institution->laboratoryDetails()->firstOrCreate([], $labData)->update($labData);
            }

            // Update Transparency Public Disclosures
            if (isset($validated['fee_structure_public'])) {
                $transparencyData = [
                    'fee_structure_public' => $validated['fee_structure_public'] === 'yes' ? 1 : 0,
                    'scholarship_policy_public' => $validated['scholarship_policy_public'] === 'yes' ? 1 : 0,
                    'other_income_source' => $validated['other_income_source'] === 'yes' ? 1 : 0,
                    'record_income_expenditure' => $validated['record_income_expenditure'] === 'yes' ? 1 : 0,
                    'financial_accounts_audited' => $validated['financial_accounts_audited'] === 'yes' ? 1 : 0,
                    'academic_calendar_public' => $validated['academic_calendar_public'] === 'yes' ? 1 : 0,
                    'faculty_to_admin_staff_ratio' => $validated['faculty_to_admin_staff_ratio'],
                    'extra_curricular_activities' => $validated['extra_curricular_activities'],
                    'extracurricular_facilities' => $validated['extracurricular_facilities'],
                ];

                $institution->transparencyPublicDisclosure()->firstOrCreate([], $transparencyData)->update($transparencyData);
            }

            DB::commit();

            return redirect()
                ->route('institutions.index')
                ->with('success', 'Institution updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }

    public function destroy(Institution $institution)
    {
        // try {

        //     // If route model binding: $institution = Institution $institution
        //     // If not: resolve manually
        //     if (!$institution instanceof Institution) {
        //         $institution = Institution::where('uuid', $institution)->first();
        //     }

        //     if (!$institution) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Institution not found.'
        //         ], 404);
        //     }

        //     DB::beginTransaction();

        //     // DELETE CHILD TABLE RECORDS
        //     InstitutionFacultyQualification::where('institution_id', $institution->id)->delete();
        //     InstitutionFacultyInfo::where('institution_id', $institution->id)->delete();
        //     InstitutionBoardOfDirectorsOwner::where('institution_id', $institution->id)->delete();
        //     InstitutionPrincipalDetail::where('institution_id', $institution->id)->delete();
        //     InstitutionEnrollmentCount::where('institution_id', $institution->id)->delete();
        //     InstitutionCurriculumAdopted::where('institution_id', $institution->id)->delete();
        //     InstitutionLaboratoryDetails::where('institution_id', $institution->id)->delete();
        //     InstitutionInfrastructure::where('institution_id', $institution->id)->delete();
        //     InstitutionFacilities::where('institution_id', $institution->id)->delete();
        //     TransparencyPublicDisclosures::where('institution_id', $institution->id)->delete();

        //     // DELETE MAIN INSTITUTION
        //     $institution->delete();

        //     DB::commit();

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Institution deleted successfully.'
        //     ], 200);

        // } catch (\Exception $e) {

        //     DB::rollBack();

        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Failed to delete institution.'
        //     ], 500);
        // }

        if ($institution) {

            $institution->is_active = !$institution->is_active;
            $institution->save();

            return $this->sendResponse(true, __('messages.institution_update'));
        }

        return $this->sendResponse(false, __('messages.institution_not_found'), [], 404);
    }

    public function closed($uuid)
    {
        $institution = Institution::uuid($uuid)->first();
        if ($institution) {

            $institution->status = 'Closed';
            $institution->save();

            return $this->sendResponse(true, 'Institution Closed Successfully');
        }

        return $this->sendResponse(false, __('messages.institution_not_found'), [], 404);
    }

    /**
     * add Review.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'action' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, $validator->errors()->first());
        }

        $uuid = $request->id;

        $application = Application::uuid($uuid)->first();
        if ($application) {
            switch ($request->action) {
                case 'Forward':
                    $status = $this->forward($application, $request);
                    break;
                case 'Approve':
                    $status = $this->approved($application, $request);
                    break;
                case 'Reject':
                    $status = $this->reject($application, $request);
                    break;
                case 'Returned':
                    $status = $this->returned($application, $request);
                    break;
                default:
                    $status = false;
            }

            if ($status) {
                return $this->sendResponse(true, 'Application status successfully updated');
            } else {
                return $this->sendResponse(false, 'Error!, Application status not updated');
            }

        }

        return $this->sendResponse(false, 'Applocation not found against this id');
    }

    private function forward($application, $request)
    {
        $role = roleName();

        if ($role == 'DEO' && in_array($application->status, ['Submitted', 'Assigned back to DEO'])) {
            $application->status = 'Forward to DED';
            $application->save();

            $this->saveApplicationLog($application, 'Forward to DED', $request->comment);
        } else if ($role == 'DED' && in_array($application->status, ['Forward to DED', 'Assigned back to DED'])) {
            $application->status = 'Forward to DGS';
            $application->save();

            $this->saveApplicationLog($application, 'Forward to DGS', $request->comment);
        }

        return true;
    }

    private function approved($application, $request)
    {
        $role = roleName();

        if ($role == 'DGS' && ($application->status == 'Forward to DGS')) {
            $application->status = 'Approved';
            $application->save();

            $institution = Institution::where('id', $application->institution_id)->first();
            if ($institution) {
                $institution->emis_code = getEMISCode($institution);
                $institution->license_start_date = $application->license_start_date;
                $institution->license_end_date = $application->license_end_date;
                $institution->status = 'Approved';
                $institution->save();
            }

            $this->saveApplicationLog($application, 'Approved', $request->comment);
        }

        return true;
    }

    private function reject($application, $request)
    {
        $role = roleName();
        if ($role == 'DEO' && in_array($application->status, ['Submitted', 'Assigned back to DEO'])) {
            $application->status = 'Rejected';
            $application->save();

            $institution = Institution::where('id', $application->institution_id)->first();
            if ($institution) {
                $institution->status = 'Rejected';
                $institution->save();
            }

            $this->saveApplicationLog($application, 'Rejected by DEO', $request->comment);
        }

        return true;
    }

    private function returned($application, $request)
    {
        $role = roleName();

        if ($role == 'DED' && in_array($application->status, ['Forward to DED', 'Assigned back to DED'])) {
            $application->status = 'Assigned back to DEO';
            $application->save();

            $this->saveApplicationLog($application, 'Assigned back to DEO', $request->comment);
        } else if ($role == 'DGS' && $application->status == 'Forward to DGS') {
            $application->status = 'Assigned back to DED';
            $application->save();

            $this->saveApplicationLog($application, 'Assigned back to DED', $request->comment);
        }

        return true;
    }

    private function saveApplicationLog($application, $status, $comment = null)
    {
        $fromUserId = $toUserId = null;

        if ($application) {

            $DEOUser = User::role('DEO')->first();
            $DEDUser = User::role('DED')->first();
            $DGSUser = User::role('DGS')->first();

            if ($status == 'Forward to DED') {
                $fromUserId = ($DEOUser) ? $DEOUser->id : null;
                $toUserId = ($DEDUser) ? $DEDUser->id : null;
            } else if ($status == 'Forward to DGS') {
                $fromUserId = ($DEDUser) ? $DEDUser->id : null;
                $toUserId = ($DGSUser) ? $DGSUser->id : null;
            } else if ($status == 'Assigned back to DED') {
                $fromUserId = ($DGSUser) ? $DGSUser->id : null;
                $toUserId = ($DEDUser) ? $DEDUser->id : null;
            } else if ($status == 'Assigned back to DEO') {
                $fromUserId = ($DEDUser) ? $DEDUser->id : null;
                $toUserId = ($DEOUser) ? $DEOUser->id : null;
            } else if (in_array($status, ['Approved', 'Rejected by DGS'])) {
                $fromUserId = ($DGSUser) ? $DGSUser->id : null;
            } else if ($status == 'Rejected by DEO') {
                $fromUserId = ($DEOUser) ? $DEOUser->id : null;
            }

            ApplicationLog::create([
                'application_id' => $application->id,
                'from_user_id' => ($fromUserId) ? $fromUserId : null,
                'to_user_id' => ($toUserId) ? $toUserId : null,
                'comment' => $comment,
                'status' => $status
            ]);

        }
    }


    public function statusModal(Request $request)
    {
        if (!$request->has('institution_id')) {
            return response()->json(['error' => 'Institution ID is required'], 400);
        }

        $Institution = Institution::with('activeApplication')->where('id', $request->institution_id)->first();

        if (!$Institution) {
            return response()->json(['error' => 'Institution not found'], 404);
        }

        $application = $Institution->activeApplication;
    // dd($application);
        // Define the stages in order
        $stages = [
            'Application Submission',
            'Deputy Education Officer (DEO)',
            'Deputy Education Director (DED)',
            'Director General Schools (DGS)'
        ];

        // Get stage statuses based on current institution status
        $stageStatuses = $this->getStageStatusesByInstitutionStatus($application->status);

        // Return the modal content view
        return view('institutions.partials.status-modal-content', get_defined_vars());
    }

    private function getStageStatusesByInstitutionStatus($status)
    {
        $statusMapping = [
            'Submitted' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Pending',
                'Deputy Education Director (DED)' => 'Pending',
                'Director General Schools (DGS)' => 'Pending'
            ],
            'Assigned to DEO' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Pending',
                'Deputy Education Director (DED)' => 'Pending',
                'Director General Schools (DGS)' => 'Pending'
            ],
            'Assigned back to DEO' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Pending',
                'Deputy Education Director (DED)' => 'Pending',
                'Director General Schools (DGS)' => 'Pending'
            ],
            'Forward to DED' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Forwarded to DED',
                'Deputy Education Director (DED)' => 'Pending',
                'Director General Schools (DGS)' => 'Pending'
            ],
            'Assigned back to DED' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Completed',
                'Deputy Education Director (DED)' => 'Pending',
                'Director General Schools (DGS)' => 'Pending'
            ],
            'Forward to DGS' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Completed',
                'Deputy Education Director (DED)' => 'Forwarded to DGS',
                'Director General Schools (DGS)' => 'Pending'
            ],
            'Approved' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Approved',
                'Deputy Education Director (DED)' => 'Approved',
                'Director General Schools (DGS)' => 'Approved'
            ],
            'Rejected' => [
                'Application Submission' => 'Completed',
                'Deputy Education Officer (DEO)' => 'Rejected',
                'Deputy Education Director (DED)' => 'N/A',
                'Director General Schools (DGS)' => 'N/A'
            ],
        ];

        return $statusMapping[$status] ?? [
            'Application Submission' => 'Completed',
            'Deputy Education Officer (DEO)' => 'Pending',
            'Deputy Education Director (DED)' => 'Pending',
            'Director General Schools (DGS)' => 'Pending'
        ];
    }

    public function getChallan(Institution $institution)
    {
        $application = $institution->activeApplication;

        $challan = FeeChallan::where('application_id', $application->id)->where('institution_id', $institution->id)->where('status', 1)->first();
        if (!$challan || $challan->expiry_date <= date('Y-m-d')) {
            // return redirect()->back()->withErrors(['error' => 'Fee challan not found for this institution.']);

            $fee = FeeStructure::where('fee_type', 'Registration Fee')->first();
            if (!$fee) {
                return redirect()->back()->withErrors(['error' => 'Fee Structure not found.']);
            }

            $total_fee = 0;
            switch ($institution->institution_level) {
                case 'Primary':
                    $total_fee = $fee->primary_fee;
                    break;
                case 'Elementary':
                    $total_fee = $fee->middle_fee;
                    break;
                case 'High':
                    $total_fee = $fee->high_fee;
                    break;
                default:
                    $total_fee = $total_fee;
            }

            if ($total_fee == 0) {
                return redirect()->back()->withErrors(['error' => 'Fee not defined for this institution level.']);
            }

            $challan = FeeChallan::updateORCreate([
                'id' => $challan ? $challan->id : null
            ], [
                'application_id' => $application->id,
                'institution_id' => $institution->id,
                'psid' => strtoupper(uniqid()),
                'fee_type' => $application->type . ' Fee',
                'issue_date' => now(),
                'expiry_date' => now()->addDays($fee->payment_deadline_days),
                'total_fee' => $total_fee
            ]);

            $application->update([
                'license_start_date' => $fee->academic_year_start,
                'license_end_date' => $fee->academic_year_end,
            ]);
        }

        $owner = optional(optional($challan)->institution)->ownerDetail;
        return view('institutions.pdf.challan', get_defined_vars());
    }

    /**
     * paid mark Fee Voucher.
     *
     * @param  Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function markPaidChallan(Institution $institution)
    {
        $applicationId = $institution->activeApplication->id;

        $fee_challan = FeeChallan::where('application_id', $applicationId)->where('institution_id', $institution->id)->where('status', 1)->active()->first();
        if ($fee_challan) {
            if ($fee_challan->expiry_date <= date('Y-m-d')) {
                return $this->sendResponse(false, 'Fee Challan expired', [], 404);
            }

            $fee_challan->update([
                'status' => 2,
                'paid_amount' => $fee_challan->total_fee,
                'paid_date' => date('Y-m-d'),
                'paid_time' => date('H:i:s'),
                'payment_type' => 'Manual'
            ]);
            return $this->sendResponse(true, 'Fee Challan marked successfully');
        }
        return $this->sendResponse(false, __('messages.fee_challan_not_found'), [], 404);
    }

    public function getCertificate(Institution $institution)
    {
        $owner = optional($institution)->user;
        return view('institutions.pdf.certificate', get_defined_vars());
    }

    public function renewLicense(Institution $institution)
    {
        //insert record in Application table
        Application::create([
            'type' => 'Renewal',
            'institution_id' => $institution->id,
            'status' => 'Submitted',
        ]);

        return $this->sendResponse(true, 'Renewal Request Submitted successfully');
    }
}