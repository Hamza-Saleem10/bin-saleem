<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    /**
     * Login
     *
     * @param Request $request
     * @return JSON
     */
    public function login(Request $request) {
       
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, $validator->messages()->first());
        }

        $username = $request->username;
        $user = User::where('username', $username)->first();
        if ($user) {
            if ($user->is_active == 1) {
                if (Auth::attempt($request->only('username', 'password'))) {
                    $user = Auth::user();
                    $user->role = roleName();
        
                    unset($user->roles);
        
                    $token = $user->createToken($user->username);
        
                    // $school = $teacher = $schoolFacilities =  null;
                    
                    // if($user->role == 'School') {
                    //     $school = School::with('cluster:id,name,level_1_id as division_id,level_1_name as division_name,level_2_id as district_id,level_2_name as district_name,level_3_id as tehsil_id,level_3_name as tehsil_name')
                    //                         ->selectRaw('schools.*,IF (toilets_for_females is not null, 1, null) as is_femail_toilet_avaiable, (toilets_for_students + toilets_for_teachers + toilets_for_females) as total_toilets')->where('code', $user->username)->first();
                    //     $user->school_latitude = $school->latitude;
                    //     $user->school_longitude = $school->longitude;

                    //     $school->basic_information = [
                    //         'division_name' => optional($school->cluster)->division_name,
                    //         'district_name' => optional($school->cluster)->district_name,
                    //         'tehsil_name' => optional($school->cluster)->tehsil_name,
                    //         'cluster_name' => optional($school->cluster)->name,
                    //         'village_name' => optional($school->village)->name,
                    //         'locality' => $school->locality,
                    //         'gbla_no' => $school->gbla_no
                    //     ];
                    //     $school->contact_information = [
                    //         'phone_no' => $school->phone_no,
                    //         'email' => $school->email,
                    //         'address' => $school->address
                    //     ];
                    //     $school->others = [
                    //         'status' => $school->status,
                    //         'build_year' => $school->build_year,
                    //         'designated_for' => $school->type,
                    //         'now_studying' => $school->official_school_type,
                    //         'medium' => $school->medium,
                    //         'sector' => $school->sector,
                    //         'public_sector' => $school->public_sector,
                    //         'other_public_sector' => $school->other_public_sector,
                    //         'shift' => $school->shift,
                    //         'upgrade_primary_year' => $school->upgrade_primary_year,
                    //         'upgrade_middle_year' => $school->upgrade_middle_year,
                    //         'upgrade_high_year' => $school->upgrade_high_year,
                    //         'upgrade_high_sec_year' => $school->upgrade_high_sec_year
                    //     ];

                    //     $schoolFacilities = [
                    //         'building_information' => $school->only(
                    //             'is_school_same_place_since_establishment',
                    //             'is_school_same_place_since_upgradation',
                    //             'school_have_building',
                    //             'ownership',
                    //             'is_any_construction',
                    //             'classroom_construction',
                    //             'toilet_construction',
                    //             'boundary_wall_construction',
                    //             'construction_type',
                    //             'building_condition',
                    //             'total_area_in_kanal',
                    //             'total_area_in_marla',
                    //             'constructed_area',
                    //             'open_area_in_kanal',
                    //             'open_area_in_marla',
                    //         ),
                    //         'class_rooms' => $school->only(
                    //             'functional_classroom',
                    //             'dangerous_classroom',
                    //             'total_non_classroom',
                    //             'dangerous_non_classroom',
                    //             'class_sections_in_open_air',
                    //             'total_rooms',
                    //             'total_class_sections',
                    //             'total_classes_with_students'
                    //         ),
                    //         'basic_facilities' => $school->only(
                    //             'is_drinking_water_available',
                    //             'water_quality',
                    //             'is_electricity_available',
                    //             'is_toilet_available',
                    //             'toilets_for_students',
                    //             'toilets_for_teachers',
                    //             'toilets_for_females',
                    //             'functional_toilets',
                    //             'nonfunctional_toilets',
                    //             'is_boundary_wall_available',
                    //             'boundary_wall_status',
                    //             'boundary_wall_height',
                    //             'security_arrangements',
                    //             'is_main_gate_available',
                    //             'main_gate_condition',
                    //             'is_sewerage_available',
                    //             'is_first_aid_kit_available',
                    //             'is_emergency_exit_available',
                    //             'is_fire_extinguisher_available',
                    //             'have_canteen',
                    //             'is_playing_ground_available',
                    //             'play_ground_area',
                    //             'is_femail_toilet_avaiable',
                    //             'total_toilets'
                    //         ),
                    //         'furniture' => $school->only(
                    //             'total_chairs',
                    //             'total_tables',
                    //             'total_cabinets',
                    //             'mini_chairs',
                    //             'bookrest_chairs',
                    //             'student_2_seaters',
                    //             'student_3_seaters',
                    //             'student_chairs'
                    //         ),
                    //         'sports' => $school->only(
                    //             'cricket_equipment_available',
                    //             'football_equipment_available',
                    //             'hockey_equipment_available',
                    //             'badminton_equipment_available',
                    //             'volley_ball_equipment_available',
                    //             'table_tennis_equipment_available',
                    //             'throw_ball_equipment_available',
                    //             'hand_ball_equipment_available',
                    //             'net_ball_equipment_available',
                    //             'basket_ball_equipment_available'
                    //         ),
                    //         'library_laboratory' => $school->only(
                    //             'have_library',
                    //             'available_books',
                    //             'have_science_lab',
                    //             'have_physics_lab',
                    //             'have_biology_lab',
                    //             'have_chemistry_lab',
                    //             'have_home_economics_lab',
                    //             'have_computer_lab',
                    //             'total_computers',
                    //             'total_laptops',
                    //             'internet_available',
                    //             'printer_available',
                    //             'multimedia_available',
                    //             'total_tablets',
                    //             'led_screen_available',
                    //             'total_led_screens',
                    //             'smart_board_available',
                    //             'total_smart_boards'
                    //         ),
                    //         'ece' => $school->only(
                    //             'ece_room_available',
                    //             'ece_established_year',
                    //             'ece_how_established',
                    //             'ece_sit_only_ece_students',
                    //             'ece_specific_teacher_available',
                    //             'ece_support_staff_available',
                    //             'ece_curriculum_guide_available',
                    //             'ece_teacher_received_service_ece_training',
                    //             'caregiver_received_ece_training',
                    //             'ece_kit_available',
                    //             'source_of_ece_kit',
                    //             'when_ece_kit_provided_to_school',
                    //             'ece_kit_need_replaced',
                    //             'ece_caregiver_maintaining_portfolio_ece_students',
                    //             'ece_age_appropriate_furniture_available',
                    //             'ece_classroom_painted',
                    //             'ece_classroom_wall_posters',
                    //             'total_trees',
                    //             'total_trees_planted_this_year'
                    //         )
                    //     ];
                    // }
                    // if($user->role == 'Teacher') {
                    //     $teacher = Teacher::with(
                    //         'currentDesignation:id,name',
                    //         'school:id,name,code,level_4_id,latitude,longitude'
                    //     )->find(@$user->teacher->id);
        
                    //     if ($teacher) {
                    //         $teacher->image = $teacher->teacher_image;
                    //         unset($teacher['media']);
                    //     }
                        
                    //     if(@$teacher->school) {
                    //         unset($user->roles);
                    //         $user->school_latitude = $teacher->school->latitude;
                    //         $user->school_longitude = $teacher->school->longitude;
                            
                    //         $teacher->school_name = $teacher->school->name.' ('.$teacher->school->code.')';
                    //         // unset($teacher->school);

                    //         $teacher->current_designation_name = $teacher->currentDesignation->name;
                    //         unset($teacher->current_designation);
                    //     }
                        
                    //     unset($user->teacher);
                    // }
        
                    // $schoolGrid['slug'] = 'school';
                    // $schoolGrid['title'] = 'School';
                    // $schoolGrid['icon'] = asset('images/app_icons/my_school.png');
                    // $schoolGrid['grids'][0]['slug'] = 'basic_information';
                    // $schoolGrid['grids'][0]['title'] = 'Basic Information';
                    // $schoolGrid['grids'][0]['icon'] = asset('images/app_icons/basic_information.png');
                    // $schoolGrid['grids'][1]['slug'] = 'school_facilities';
                    // $schoolGrid['grids'][1]['title'] = 'School Facilities';
                    // $schoolGrid['grids'][1]['icon'] = asset('images/app_icons/school_facilities.png');
        
                    // $teachersGrid['slug'] = 'staff';
                    // $teachersGrid['title'] = 'Staff';
                    // $teachersGrid['icon'] = asset('images/app_icons/staff.png');
                    
                    // if($user->role == 'School') {
                    //     $teachersGrid['grids'][0]['slug'] = 'staff_listing';
                    //     $teachersGrid['grids'][0]['title'] = 'Teaching Staff';
                    //     $teachersGrid['grids'][0]['icon'] = asset('images/app_icons/teachers_listing.png');
                        
                    //     $teachersGrid['grids'][1]['slug'] = 'support_staff_listing';
                    //     $teachersGrid['grids'][1]['title'] = 'Non-Teaching Staff';
                    //     $teachersGrid['grids'][1]['icon'] = asset('images/app_icons/support_staff_listing.png');
                        
                    //     $teachersGrid['grids'][2]['slug'] = 'staff_transfer';
                    //     $teachersGrid['grids'][2]['title'] = 'Staff Transfer';
                    //     $teachersGrid['grids'][2]['icon'] = asset('images/app_icons/transfer_in.png');
                    // }
                    
                    // if($user->role == 'Teacher') {
                    //     $teachersGrid['title'] = '';

                    //     $teachersGrid['grids'][0]['slug'] = 'profile';
                    //     $teachersGrid['grids'][0]['title'] = 'Basic Profile';
                    //     $teachersGrid['grids'][0]['icon'] = asset('images/app_icons/students.png');
                    //     $teachersGrid['grids'][1]['slug'] = 'self_attendance';
                    //     $teachersGrid['grids'][1]['title'] = 'Attendance';
                    //     $teachersGrid['grids'][1]['icon'] = asset('images/app_icons/attendance.png');
                        
                    //     $teachersGrid['grids'][2]['slug'] = 'transfer_posting';
                    //     $teachersGrid['grids'][2]['title'] = 'Transfer Posting';
                    //     $teachersGrid['grids'][2]['icon'] = asset('images/app_icons/transfer_in.png');
                    // }
        
                    // $studentsGrid['slug'] = 'students';
                    // $studentsGrid['title'] = 'Students';
                    // $studentsGrid['icon'] = asset('images/app_icons/students.png');
                    // $studentsGrid['grids'][0]['slug'] = 'students_enrolled';
                    // $studentsGrid['grids'][0]['title'] = 'Enrolled';
                    // $studentsGrid['grids'][0]['icon'] = asset('images/app_icons/students.png');
                    // $studentsGrid['grids'][1]['slug'] = 'student_attendance';
                    // $studentsGrid['grids'][1]['title'] = 'Attendance';
                    // $studentsGrid['grids'][1]['icon'] = asset('images/app_icons/attendance.png');
                    // $studentsGrid['grids'][2]['slug'] = 'transfer_in';
                    // $studentsGrid['grids'][2]['title'] = 'Transfer-In';
                    // $studentsGrid['grids'][2]['icon'] = asset('images/app_icons/transfer_in.png');
        
                    // $grids = [];
        
                    // if($user->role == 'School') {
                    //     $grids[] = $studentsGrid;

                    //     $grids[] = $schoolGrid;
                        // if(config('app.env') != 'production') {
                            // $grids[] = $teachersGrid;
                        // }
                    // }
                    
                    // if($user->role == 'Teacher') {
                    //     $grids[] = $teachersGrid;
                    // }
        
                    return $this->sendResponse(true, "User successfully loggedin", [
                        'token' => $token->plainTextToken,
                        // 'user' => $user,
                        // 'school' => $school,
                        // 'school_facilities' => $schoolFacilities,
                        // 'teacher' => $teacher,
                        'grids' => $grids,
                    ]);
                }
            } else {
                Auth::logout();
                return $this->sendResponse(false, 'Your account is inactive', null, 401);
            }

            return $this->sendResponse(false, 'Password do not match', null, 401);
        }

        return $this->sendResponse(false, "Username/Password do not match");
    }

    /**
     * Change Password
     *
     * @param Request $request
     * @return JSON
     */
    public function changePassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:8',
            'password' => ['required', Rules\Password::defaults()]
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, $validator->messages()->first());
        }


        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) { 

            $user->update(['password' => Hash::make($request->password)]);

            return $this->sendResponse(true, "Password updated successfully");
         
        } else {
            return $this->sendResponse(false, "Password do not match");
        }

    }

    /**
     * Send OTP
     *
     * @param Request $request
     * @return JSON
     */
    public function sendOtp(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, $validator->messages()->first());
        }

        $user = User::where('username', $request->username)->first();

        if($user) {
            $otp = random_int(1111, 9999);
            if($user->otp != '' && $user->otp != null) {
                $otp = $user->otp;
            } else {
                $user->update(['otp' => $otp]);
            }
            
            sendSms($user->mobile, 'Please enter OTP code: '. $otp, 'otp');

            return $this->sendResponse(true, "OTP successfully sent");
        }

        return $this->sendResponse(false, "User not found");
    }


    /**
     * Verify OTP
     *
     * @param Request $request
     * @return JSON
     */
    public function verifyOtp(Request $request) {
            
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'otp' => 'required|numeric|digits:4'
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, $validator->messages()->first());
        }

        $username = $request->username;
        $otp = (int) $request->otp;
        $user = User::where('username', $username)->first();

        if ($user) {

            if ($user->otp != $request->otp) {
                return $this->sendResponse(false, "Invalid OTP");
            }

            $user->otp = null;
            $user->save();

            return $this->sendResponse(true, "OTP successfully verified");
        }

        return $this->sendResponse(false, "User not found");
    }


    /**
     * Forgot Password
     *
     * @param Request $request
     * @return JSON
     */
    public function resetPassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(false, $validator->messages()->first());
        }


        $user = User::where('username', $request->username)->active()->first();

        if($user) {
              
            $user->update(['password' => Hash::make($request->password)]);

            return $this->sendResponse(true, "Password updated successfully");
        }

        return $this->sendResponse(false, "User not found");


    }
    

    public function getAppVersion () 
    {
        return $this->sendResponse(true, "App Version", [
            'app_version_name' => getSettingValue('app_version_name'),
            'app_version_code' => (int) getSettingValue('app_version_code')
        ]);
    }
}
