<?php

// use App\Models\Level2;
// use App\Models\Level3;
// use App\Models\Level4;
use App\Models\User;
// use App\Models\School;
use App\Models\Setting;
use App\Models\SMSLog;
// use App\Models\Subject;
// use App\Models\Teacher;
// use App\Models\Institution;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

// use PDF;
// use QrCode;


if(!function_exists('filterRequestData')) {

    function filterRequestData($request) {
        // dd($request);
        if (@$request->cnic) {
            $request->merge(['cnic' => str_replace('-', '', $request->cnic)]);
        }
        if (@$request->mobile) {
            $request->mobile = str_replace('-', '', $request->mobile);
            $request->merge(['mobile' => str_replace('-', '', $request->mobile)]);
        }
        // if (@$request['dob']) {
        //     $request['dob'] = Carbon::parse($request['dob'])->format('Y-m-d');
        // }

        return $request;
    }

}

/**
* Check Active Route
*
* @param $route
* @param $output
* @return mix
*/
if (!function_exists('isActiveRoute')) {

    function isActiveRoute($route, $output = "active") {
        if (Route::current()->uri == $route)
            return $output;
    }

}

/**
* Active Route
*
* @param $paths
* @param $class
* @return mix
*/
if (!function_exists('setActive')) {

    function setActive($paths, $class = TRUE, $className = 'menu-item-active') {
        foreach ($paths as $path) {

            if (Request::is($path . '*')) {
                if ($class)
                    return ' class=menu-item-active';
                else
                    return ' ' . $className;
            }
        }
    }

}

/**
* Active Routes
*
* @param $routes
* @param $output
* @return mix
*/
if (!function_exists('areActiveRoutes')) {

    function areActiveRoutes(Array $routes, $output = "active") {
        foreach ($routes as $route) {
            if (Route::current()->uri == $route) {
                return $output;
            }
        }
    }

}

/**
* Redirect Routes
*
* @param $routes
* @param $output
* @return mix
*/
if (!function_exists('redirectRoute')) {

    function redirectRoute() {
        $role = roleName();

        if($role == 'School Owner'){
            return RouteServiceProvider::APPLICATIONS;
        }else{
            return RouteServiceProvider::HOME;
        }
    }

}

/**
* Get Setting Value
* @param $key
* @return mix
*/
if (!function_exists('getSettingValue')) {

    function getSettingValue($key)
    {
        return @Setting::where('key', $key)->first()->value;
    }

}

/**
* Get School Levels
* @return Array
*/
// if (!function_exists('getSchoolLevels')) {

//     function getSchoolLevels () {
//         return [
//             'Primary' => 7,
//             'Middle' => 10,
//             'Elementary' => 10,
//             'High' => 12,
//             'Secondary' => 12,
//             'Higher Secondary' => 14
//         ];
//     }

// }

/**
* Get Role Name
*
* @return mix
*/
if (!function_exists('roleName')) {

    function roleName()
    {
        $roleName = '';
        $user = Auth::user();
        if (@$user->getRoleNames()->first()) {
            $roleName = $user->getRoleNames()->first();
        }
            
        return $roleName;
    }

}

/**
* Get Role Name
*
* @return mix
*/
if (!function_exists('isSuperAdmin')) {

    function isSuperAdmin()
    {
        $isSuperAdmin = false;
        $user = Auth::user();
        if (@$user->getRoleNames()->first() && $user->getRoleNames()->first() == 'Super Admin') {
            $isSuperAdmin = true;
        }
            
        return $isSuperAdmin;
    }

}

/**
 * Get Subject Teach
 *
 * @return mix
 */
// if (!function_exists('getSubjectTeach')) {

//     function getSubjectTeach($subjectIds)
//     {
//         return Subject::whereIn('id', explode(',', $subjectIds))->pluck('name')->implode(', ', 'name');
//     }
// }

/**
* Send Message to Mobile Number
*
* @param $number
* @param $message
* @return mix
*/
if (!function_exists('sendPasswordMessage')) {

    function sendPasswordMessage($number, $password)
    {
        $message = 'Your password is ' . $password;
        sendSms($number, $message, "reset_password");
    }

}

/**
* Get Application Status Badge
*
* @param $status
* @return mix
*/
if (!function_exists('getStatusBadge')) {

    function getStatusBadge($status = 1)
    {
        $badge = '<span style="overflow: visible; position: relative; width: 130px;">';
                    
        switch ($status) {
            case 1:
                $badge .= '<a href="#" class="badge bg-success" > Active </a>';
                break;
            default:
                $badge .= '<a href="#" class="badge bg-danger" > In Active </a>';
        }
        
        $badge .= '</span>';    
        return $badge;
    }

}

/**
* Get Fee Status Badge
*
* @param $status
* @return mix
*/
// if (!function_exists('getFeeStatusBadge')) {

//     function getFeeStatusBadge($status)
//     {
//         $badge = '<span style="overflow: visible; position: relative; width: 130px;">';
                    
//         switch ($status) {
//             case 'Paid':
//                 $badge .= '<a href="#" class="badge bg-success" > Paid </a>';
//                 break;
//             default:
//                 $badge .= '<a href="#" class="badge bg-danger" > Unpaid </a>';
//         }
        
//         $badge .= '</span>';    
//         return $badge;
//     }

// }

/**
* Get Uuid
*
* @return mix
*/
if (!function_exists('getUuid')) {

    function getUuid()
    {
        //(string) \Uuid::generate(4);
        return \DB::raw('uuid()');
    }

}

/**
* dd with json
*
* @return mix
*/
if (!function_exists('dj')) {

    function dj($data)
    {
        return response()->json([
            'data' => $data
        ], 200);
        exit;
    }

}

/**
 * Attendance Status Colors
 * @return Array
 */
// if (!function_exists('getAttendanceStatusColors')) {

//     function getAttendanceStatusColors()
//     {
//         return [
//             'Unmarked' => '#656565',
//             'Absent' => '#FB303C',
//             'Present' => '#35BB9F',
//             'Casual Leave' => '#EF9E24',
//             'Medical Leave' => '#EF9E24',
//             'Holiday' => '#FB303C'
//         ];
//     }
// }

/**
 * Success Response
 *
 * @param $message
 * @return JSON
 */
if (!function_exists('successResponse')) {
    function successResponse($message, $response = []) {
        $responseData = [
            'message' => $message,
            'code' => 200,
            'status' => true,
        ];

        $response = array_merge($responseData, $response);

        return response()->json($response, 200);
    }
}

/**
 * Error Response
 *
 * @param $message
 * @return JSON
 */
if (!function_exists('errorResponse')) {
    function errorResponse($message, $response = [], $status = 400) {
        $responseData = [
            'message' => $message,
            'code' => $status,
            'status' => false,
        ];

        $response = array_merge($responseData, $response);

        return response()->json($response, 200);
    }
    
}

function load_pdf($pdf) {
    header('Content-Type: application/pdf');
    $image_name = image_name_decode($pdf);
    readfile($image_name);
}

/**
* add Dashes In CNIC
*
* @return mix
*/
if (!function_exists('addDashesInCNIC')) {

    function addDashesInCNIC($cnic)
    {
        return preg_replace("/^(\d{5})(\d{7})(\d{1})$/", "$1-$2-$3", $cnic);
    }

}

/**
* add Dash In Mobile
*
* @return mix
*/
if (!function_exists('addDashInMobile')) {

    function addDashInMobile($mobile)
    {
        return preg_replace("/^(\d{4})(\d{7})$/", "$1-$2", $mobile);
    }

}

/**
 * Get All Districts
 * @return Number
 */
// if (!function_exists('getAllDistricts')) {

//     function getAllDistricts()
//     {
//         $user = Auth::user();
//         $role = roleName();
//         $districts = Level2::active();
//         if ($role == 'Division') {
//             $districts->where('level_1_id', $user->level_1_id);
//         } else if ($role == 'DEO') {
//             $districts->where('id', $user->level_2_id);
//         }
//         return $districts->pluck('id', 'name');
//     }
// }

/**
 * Get All District Tehsils
 * @return Number
 */
// if (!function_exists('getAllDistrictTehsils')) {

//     function getAllDistrictTehsils($level2Id = 'all')
//     {
//         $tehsils = Level3::active();
//         if ($level2Id != 'all') {
//             $tehsils->where('level_2_id', $level2Id);
//         }
//         return $tehsils->pluck('id', 'name');
//     }
// }

/**
 * Get All Clusters
 * @return Number
 */
// if (!function_exists('getAllClusters')) {

//     function getAllClusters($level3Id = 'all')
//     {
//         $clusters = Level4::active();
//         if ($level3Id != 'all') {
//             $clusters->where('level_3_id', $level3Id);
//         }
//         return $clusters->pluck('id', 'code');
//     }
// }

/**
 * Get All Schools
 * @return Array
 */
// if (!function_exists('getAllSchools')) {

//     function getAllSchools($level4Id = 'all')
//     {
//         return true;
//     }
// }

/**
* add Dash In Mobile
*
* @return mix
*/
if (!function_exists('loggedInUserId')) {

    function loggedInUserId()
    {
        return Auth::id();
    }

}


/**
* return logged in school id
*
* @return mix
*/
// if (!function_exists('loggedInSchoolId')) {

//     function loggedInSchoolId()
//     {
//         return optional(Auth::user()->school)->id;
//     }

// }

/**
* return school id of logged in teacher
*
* @return mix
*/
// if (!function_exists('getLoggedInTeacherSchoolId')) {

//     function getLoggedInTeacherSchoolId()
//     {
//         return optional(Auth::user()->teacher->school)->id;
//     }

// }

/**
* return logged in teacher id
*
* @return mix
*/
// if (!function_exists('getLoggedInTeacherId')) {

//     function getLoggedInTeacherId()
//     {
//         return optional(Auth::user()->teacher)->id;
//     }

// }

/**
* Get Teacher related keys
*
* @return mix
*/
// if (!function_exists('getTeacherRelatedKeys')) {

//     function getTeacherRelatedKeys($teacherId, $keys = [])
//     {
//         $keys = collect($keys);
//         $teacher = Teacher::where('id', $teacherId)
//                         ->with('school:level_4_id,id')
//                         ->first();

//         $teacherData = [];
//         if($teacher && $keys->contains('school_id')) {
//             $teacherData['school_id'] = $teacher->school->id;
//         }
//         if($teacher && $keys->contains('level_4_id')) {
//             $teacherData['level_4_id'] = $teacher->school->level_4_id;
//         }

//         return $teacherData;
//     }

// }

/**
* Get Role Name
*
* @return mix
*/
if (!function_exists('hasRole')) {

    function hasRole($role)
    {
        $hasRole = false;
        $user = Auth::user();
        if (@$user->getRoleNames()->first() && $user->getRoleNames()->first() == $role) {
            $hasRole = true;
        }
            
        return $hasRole;
        
    }

}

/**
* Count of Schools
* @return Number
*/
// if (!function_exists('totalSchools')) {

//     function totalSchools ($request = null) {

//         $user = Auth::user();
//         $role = roleName();
        
//         if ($role == 'Division') {
//             $schools = School::whereHas('cluster', function ($query) use ($user) {
//                 $query->where('level_1_id', $user->level_1_id);
//             });
//         } else if ($role == 'DEO') {
//             $schools = School::whereHas('cluster', function ($query) use ($user) {
//                 $query->where('level_2_id', $user->level_2_id);
//             });
//         } else if ($role == 'Cluster') {
//             $schools = School::whereHas('cluster', function ($query) use ($user) {
//                 $query->where('code', $user->username);
//             });
//         }
//         else {
//             $schools = School::query();
//         }

//         if ($request->filled('c') && $request->c > 0) {
//             $schools->where('level_4_id', $request->c);
//         } else if ($request->filled('t') && $request->t > 0) {
//             $schools->whereHas('cluster', function (Builder $query) use ($request) {
//                 $query->where('level_3_id', $request->t);
//             });
//         } else if ($request->filled('d') && $request->d > 0) {
//             $schools->whereHas('cluster', function (Builder $query) use ($request) {
//                 $query->where('level_2_id', $request->d);
//             });
//         }

//         $schools = $schools->where('school_level', '!=', 'Office')->active()->count();

//         return number_format($schools);
//     }

// }

/**
* Count of Schools
* @return Number
*/
// if (!function_exists('totalTeachers')) {

//     function totalTeachers () {
//         return number_format(Teacher::count());
//     }

// }

/**
* Get Role Name
*
* @return mix
*/
// if (!function_exists('getSchoolTehsilId')) {

//     function getSchoolTehsilId()
//     {
//         $schoolId = loggedInSchoolId();

//         $school = School::select('level_4_id')
//                 ->with('unionCouncil')
//                 ->find($schoolId);

//         if($school) {
//             return $school->unionCouncil->level_3_id;
//         }
//         return false;
        
//     }

// }

/**
* Get Level 4 Id of Teacher
*
* @return mix
*/
// if (!function_exists('getTeacherLevelFourId')) {

//     function getTeacherLevelFourId()
//     {
//         #return optional(Auth::user()->teacher->school)->id;
//         $user = Auth::user();
//         $level4Id = $user;
//         return $level4Id;
//     }

// }


/**
* Get partition column value of students table
* @param TehsilId
* @param status
* @return mix
*/
// if (!function_exists('getStudentPart')) {

//     function getStudentPart($tehsilId, $status = 1)
//     {
//         return ($status * 10000) + $tehsilId;        
//     }

// }


/**
* Send Message to Mobile Number
*
* @param $number
* @param $message
* @param $language
* @return mix
*/
if (!function_exists('sendSms')) {

    function sendSms($number, $message, $type = null, $language = 'english')
    {
        if($number == '' || $number == null) {
            return false;
        }

        if (config('app.sms_enable')) {
            $firstDigit = substr($number, 0, 1);
            if ($firstDigit != 0) {
                $number = '0'. substr($number, 1);
            }
    
            $request = [
                'phone_no' => $number,
                'sms_text' => $message,
                'sec_key' => config('app.sms_key'), 
                'sms_language' => $language
            ];
            
            $smsLog = SMSLog::create([
                'mobile' => $number,
                'request' => json_encode($request),
                'request_time' => date('Y-m-d H:i:s'),
                'type' => $type
            ]);
            
            try {
                $response = Http::withOptions([
                        'debug' => false,
                        'verify' => false,
                    ])->asForm()
                    ->post(config('app.sms_url'), $request);

                $res = $response->object();
                $smsLog->response = $response->json();
                $smsLog->response_time = date('Y-m-d H:i:s');
                $smsLog->status = ($response->ok() && $res->status == 'success') ? 1 : 2;
                $smsLog->save();

                return $response->json();
            
            } catch (Exception $e) {

                $smsRes = json_encode([
                    'code' => $e->getCode(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'message' => $e->getMessage(),
                ]);
    
                $smsLog->response = $smsRes;
                $smsLog->response_time = date('Y-m-d H:i:s');
                $smsLog->status = 2;
                $smsLog->save();

                return false;
            }
        } 
    }

}


/**
* return school id of logged in teacher
*
* @return mix
*/
// if (!function_exists('getLoggedInUserMobileNumber')) {

//     function getLoggedInUserMobileNumber($user)
//     {

//         $userMobile = '';

//         $role = roleName();

//         $user = Auth::user();

//         if($role == 'School') {
//             $userMobile = $user->school->mobile;
//         }
//         if($role == 'Teacher') {
//             $userMobile = $user->teacher->mobile;
//         }

//         return $userMobile;
//     }

// }

/**
* Read file data
*
* @param $directory
* @param $fileName
* @return mix
*/
if (!function_exists('read_file')) {

    function read_file($fileName = false) {
        if (!$fileName) {
            return null;
        }
        

        if (strpos($fileName, '.pdf')) {
            return asset('images/pdf_icon.png');
        }
        
        return $fileName;
    }

}

/**
* make public url
*/

if (!function_exists('make_public_url')) {
    function make_public_url($url = null)
    {
        if (!$url) {
            return null;
        }

        $split = explode("/",$url);
        $arr = array_slice($split,-2);
        $url = route('document.file', ['foldername'=>$arr[0], 'filename'=>$arr[1]]);
        return $url;
    }
}

/**
* user current status
* @return Array
*/
if (!function_exists('getUserCurrentStatus')) {

    function getUserCurrentStatus ($status) {
        $statuses = [
            'Premature Retirement' => 'Premature Retirement',
            'In-Service Death' => 'In-Service Death',
            'Retirement on time' => 'Retirement on time',
            'Joined a different department' => 'Joined a different department'
        ];

        if (in_array($status, $statuses))
        {
            return 0;
        }else{
            return 1;
        }
    }

}

/**
* Update teacher counts in Post
*
* @return mix
*/
// if (!function_exists('updateTeacherCountsInPost')) {

//     function updateTeacherCountsInPost($postId)
//     {
//         if ($postId) {
            
//             return \DB::statement("
//                 UPDATE sanctioned_posts
//                 SET filled = (
//                     SELECT COUNT(*)
//                     FROM teachers
//                     WHERE teachers.post_id = $postId AND teachers.is_active = 1 AND teachers.transfer_status = 'On Duty'
//                 )
//                 WHERE sanctioned_posts.id = $postId
//             ");
//         }
//     }

// }

if (!function_exists('generateAdminOrderPdf')) {
    function generateAdminOrderPdf($order)
    {
        if ($order) {
            
            $qrData = "{$order->order_type}|{$order->id}|{$order->teacher->id}|{$order->teacher->cnic}|{$order->teacher->name}|{$order->fromSchool->code}|{$order->school->code}|{$order->teacher->post_id}|{$order->post_id}|{$order->teacher->currentDesignation->id}"; 
            $order->qr = base64_encode(\QrCode::size(200)->generate($qrData));
            $pdf = \PDF::loadView('admin-orders.generate-pdf', $order->toArray());

            return $pdf;
        }
    }
}

/**
* Save log data in database
*
* @param Array $type 
* @return mix
*/
if (!function_exists('saveUserLogs')) {

    function saveUserLogs($type)
    {
        $userId = 0;
        if (Auth::check()) {
            $userId = Auth::id();
        }

        DB::table('user_logs')->insert([
            'user_id' => $userId,
            'type' => $type,
            'latitude' => request()->latitude,
            'longitude' => request()->longitude,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return true;
    }

}

/**
* Save log data in database
*
* @param Array $type 
* @return mix
*/
if (!function_exists('saveUserLogInAttempts')) {

    function saveUserLogInAttempts($status)
    {
        $userId = 0;
        if (Auth::check()) {
            $userId = Auth::id();
        }

        DB::table('user_login_attempts')->insert([
            'username' => request()->username,
            'password' => request()->password,
            'status' => $status,
            'latitude' => request()->latitude,
            'longitude' => request()->longitude,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return true;
    }

}


/**
* Show Forward Btn
*
* @param $application
* @return true/false
*/
// if (!function_exists('showForwardBtn')) {
//     function showForwardBtn($status){
//         $showBtn = false;
//         $role = roleName();
//         if($role == 'DEO' && in_array($status, ['Submitted','Assigned back to DEO'])) {
//             $showBtn = true;
//         }else if($role == 'DED' && in_array($status, ['Forward to DED','Assigned back to DED'])) {
//             $showBtn = true;
//         }
//         return $showBtn;
//     }
// }

/**
* Show Approve Btn
*
* @param $application
* @return true/false
*/
// if (!function_exists('showApproveBtn')) {
//     function showApproveBtn($status){
//         $showBtn = false;
//         $role = roleName();
//         if($role == 'DGS' && $status == 'Forward to DGS') {
//             $showBtn = true;
//         }
//         return $showBtn;
//     }
// }

/**
* Show Reject Btn
*
* @param $application
* @return true/false
*/
// if (!function_exists('showRejectBtn')) {
//     function showRejectBtn($status){
//         $showBtn = false;
//         $role = roleName();
//         if($role == 'DEO' && in_array($status, ['Submitted','Assigned back to DEO'])) {
//             $showBtn = true;
//         } 
//         return $showBtn;
//     }
// }

/**
* Show Reject Btn
*
* @param $application
* @return true/false
*/
// if (!function_exists('showReturnBtn')) {
//     function showReturnBtn($status){
//         $showBtn = false;
//         $role = roleName();
//         if($role == 'DED' && in_array($status, ['Forward to DED','Assigned back to DED'])) {
//             $showBtn = true;
//         } else if($role == 'DGS' && $status == 'Forward to DGS') {
//             $showBtn = true;
//         }
//         return $showBtn;
//     }
// }

/**
* numberToWords
* @return Array
*/
if (!function_exists('numberToWords')) {
    function numberToWords($number,$curreny = 'Rupees')
    {
        if (!is_numeric($number)) return 'Invalid number';
        if ($number == 0) return 'Zero';

        $ones = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
            'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];

        $tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty',
            'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];

        $scales = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

        $words = [];
        $number = (int)$number;
        $scaleIndex = 0;

        while ($number > 0) {
            $chunk = $number % 1000;

            if ($chunk > 0) {
                $chunkWords = '';

                if ($chunk >= 100) {
                    $chunkWords .= $ones[intval($chunk / 100)] . ' Hundred ';
                    $chunk %= 100;
                }

                if ($chunk > 0) {
                    if ($chunk < 20) {
                        $chunkWords .= $ones[$chunk];
                    } else {
                        $chunkWords .= $tens[intval($chunk / 10)];
                        if ($chunk % 10) {
                            // 👇 Add hyphen between tens and ones (e.g. Ninety-Eight)
                            $chunkWords .= '-' . $ones[$chunk % 10];
                        }
                    }
                }

                $chunkWords = trim($chunkWords);

                if ($scales[$scaleIndex] !== '') {
                    $chunkWords .= ' ' . $scales[$scaleIndex];
                }

                array_unshift($words, $chunkWords);
            }

            $number = intval($number / 1000);
            $scaleIndex++;
        }

        return trim(preg_replace('/\s+/', ' ', implode(' ', $words))).' '.$curreny;
    }
}

// In app/Helpers/helpers.php (create if doesn't exist)
// if (!function_exists('getStorageUrl')) {
//     function getStorageUrl($path)
//     {
//         $path = str_replace('\\', '/', $path);
//         return asset('storage/' . $path);
//     }
// }

/**
* EMIS Code
*
* @return string
*/
// if (!function_exists('getEMISCode')) {

//     function getEMISCode($institution) {
//         //  format = GLT-0131

//         $districtCode = null;
//         $district = optional(optional($institution)->level_2)->name;
//         if($district){
//             $districtCode = strtoupper(substr($district, 0, 3));
//         }

//         $max = Institution::where('level_2_id', $institution->level_2_id)->max('emis_code');
//         if(!empty($max)){
//             $max = explode('-',$max);
//             $max = end($max);
//             $max = $max+1;
//         }else{
//             $max = 1;
//         }
//         $max_code = sprintf("%'04d", $max);

//         $code = $districtCode.'-'.$max_code;
//         return $code;
//     }
// }