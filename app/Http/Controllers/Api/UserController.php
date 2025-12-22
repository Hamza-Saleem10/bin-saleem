<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Models\Classes;
use App\Models\Designation;
// use App\Models\Level1;
// use App\Models\Level2;
// use App\Models\Section;
// use App\Models\Subject;
// use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // public function metaData() {

    //     $user = Auth::user();

    //     $isSchool = hasRole('School'); 
    //     $isTeacher = hasRole('Teacher'); 
        
    //     $staticData = [];

    //     $teachersData = [];

    //     $schoolId = $teachersCount = 0;
    //     if($isSchool) {

    //         $schoolLevel = $user->school->school_level;
    //         $schoolId = $user->school->id;

    //         $teachers = Teacher::with('currentDesignation:id,name')
    //                     ->where(['school_id' => $schoolId, 'is_active' => 1])->get();
    //         if($teachers) {
    //             $teachersData = $teachers;
    //             $teachersCount = $teachers->count();
    //         }
    //     }
    //     if($isTeacher) {
    //         $schoolLevel = $user->teacher->school->school_level;
    //         $schoolId = $user->teacher->school->id;
    //     }

    //     if($isSchool || $isTeacher) {

    //         $schoolLevels = getSchoolLevels();

    //         $classesData = [];

    //         if (isset($schoolLevels[$schoolLevel])) {

    //             $classes = Classes::select('id','name')
    //                 ->where('id', '<=', $schoolLevels[$schoolLevel])
    //                         ->active()
    //                         ->get();

    //             foreach($classes as $class) {
    //                 $class['sections'] = Section::select('id', 'name', 'class_id')
    //                             // ->withCount('students')
    //                             ->where('school_id', $schoolId)
    //                             ->where('class_id', $class->id)
    //                             ->get();
                                
    //                 $classesData[] = $class;
    //             }   
    //         }
            
    //         $staticData['teachers'] = $teachersData;
    //         $staticData['teachers_count'] = $teachersCount;
    //         $staticData['classes'] = $classesData;
    //         $staticData['designations'] = Designation::select('id', 'name', 'cadre', 'min_grade', 'max_grade', 'teacher_min_grade', 'teacher_max_grade')->where('is_active', 1)->get();
    //         $staticData['grades'] = collect(config('app.grades'))->map(function($key) {
    //             return array(["id" => $key, "name" => $key]);
    //         })->collapse();
    //         $staticData['genders'] = collect(config('app.genders'))->map(function($key) {
    //             return array(["id" => $key, "name" => $key]);
    //         })->collapse();
    //         $staticData['religions'] = collect(config('app.religions'))->map(function($key) {
    //             return array(["id" => $key, "name" => $key]);
    //         })->collapse();
            
    //         $levels = Level2::select('id', 'name')
    //                     ->with(
    //                         'tehsils:level_2_id,id,name,level_2_id AS district_id', 
    //                         'tehsils.clustors:level_3_id,id,name,level_3_id AS tehsil_id'
    //                     )
    //                     ->active()->get();

    //         $staticData['districts'] = $levels;
    //         $staticData['distance'] = config('app.distance');
    //         $staticData['income'] = config('app.income');
    //         $staticData['disability_types'] = config('app.disability_types');
    //         $staticData['difficulty_types'] = config('app.difficulty_types');

    //         $staticData['benefits'] = [
    //             [
    //                 "id" => "availed_gb_education_endowment_fund",
    //                 "name" => "GB Education Endowment Fund",
    //             ],
    //             [
    //                 "id" => "availed_cct_by_bisp",
    //                 "name" => "CCT By BISP",
    //             ],
    //             [
    //                 "id" => "availed_scottish_scholarship",
    //                 "name" => "Scottish Scholarship",
    //             ],
    //             [
    //                 "id" => "availed_student_learning_kit_by_unicef",
    //                 "name" => "Student learning Kit by UNICEF",
    //             ]
    //         ];
    //         $staticData['countries'] = config('app.countries');

    //         $staticData['transfer_out_reasons'] = [
    //             'Transferred to Other Government School',
    //             'Others'
    //         ];
    //         $staticData['dropout_reasons'] = [
    //             'Migration',
    //             'Student is not punctual for Consecutive 3 weeks',
    //             'Left for Hifz-e-Quran',
    //             'Shifted to private school',
    //             'Discontinue studies',
    //             'Health Issues',
    //             'Learning Disabilities',
    //             'Others',
    //         ];
            
    //         $staticData['ownership'] = config('app.ownership');
    //         $staticData['construction_types'] = config('app.construction_types');
    //         $staticData['building_conditions'] = config('app.building_conditions');
    //         $staticData['boundary_wall_status'] = [
    //             'Completed',
    //             'Not Completed',
    //             'Need Repairing',
    //             'Only Fence'
    //         ];
    //         $staticData['boundary_wall_height'] = [
    //             'Less than 5ft','5ft','6ft'
    //         ];
    //         $staticData['security_arrangements'] = [
    //             'Satisfactory', 'Unsatisfactory', 'Not Available'
    //         ];
    //         $staticData['sector'] = [
    //             'Public',
    //             'Other Public',
    //             'Home School/Community School'
    //         ];
    //         $staticData['public_sector'] = [
    //             'Government',
    //             'Mosque School',
    //             'Home School'
    //         ];
    //         $staticData['other_public_sector'] = [
    //             'BECS',
    //             'NCHD',
    //             'Armed Force School',
    //             'Public BoD',
    //             'Pakistan Bait ul Mall',
    //             'Police School'
    //         ];
    //         $staticData['water_quality'] = [
    //             'Running Water',
    //             'Clean Water'
    //         ];
    //         $staticData['main_gate_conditions'] = [
    //             'Complete',
    //             'Broken'
    //         ];
    //         $staticData['how_ece_room_established'] = [
    //             'Under GB ADP',
    //             'Privately established by School',
    //             'Community Support',
    //             'NGO/Development Partner'
    //         ];
    //     }

    //     return $this->sendResponse(true, 'Fetch meta data', $staticData);

    // }

    // public function chatbot()
    // {
    //     return [
    //         [
    //             'district_name' => 'Gilgit',
    //             'total_students' => 1000,
    //             'male_students' => 600,
    //             'female_students' => 400,
    //         ],
    //         [
    //             'district_name' => 'Skardu',
    //             'total_students' => 800,
    //             'male_students' => 400,
    //             'female_students' => 400,
    //         ]
    //     ];
    // }
}
