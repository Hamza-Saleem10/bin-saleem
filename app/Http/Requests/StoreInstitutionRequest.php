<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInstitutionRequest extends FormRequest
{
    public function authorize()
    {
        // You can add your authorization logic here
        return true;
    }

    public function rules()
    {
        return [
            // Institution
            'name' => 'required|string|max:191',
            'level_2_id' => 'required|exists:level_2,id', // district
            'level_3_id' => [
                'required',
                Rule::exists('level_3', 'id')->where(function ($query) {
                    $query->where('level_2_id', $this->input('level_2_id'));
                }),
            ],
            'level_4_id' => [
                'required',
                Rule::exists('level_4', 'id')->where(function ($query) {
                    $query->where('level_2_id', $this->input('level_2_id'))
                        ->where('level_3_id', $this->input('level_3_id'));
                }),
            ],
            'institution_nature' => 'required|in:Individual,Branch,Franchise',
            'institution_level' => 'required|in:Primary,Elementary,High',
            'management_nature' => 'required|in:Association of Person,Corporate Body,Educational Society Individual',
            'institution_type' => 'required|in:School,ECD Centre,Day-care Centre,Tuition Centre',
            'teaching_level' => 'required|in:Pre-Primary,Primary,Middle Secondary,High Secondary or equivalent',
            'institution_medium' => 'required|in:English,Urdu,Both',
            'institution_gender' => 'required|in:Boys Campus,Girls Campus,Co-Education',
            'address' => 'nullable|string|max:256',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'institution_official_web_url' => 'required|url|max:128',
            'institution_official_email' => 'required|email|max:128',
            'institution_phone' => 'required|string|max:20',
            'institution_fax' => 'nullable|string|max:20',
            'institution_public_email' => 'required|email|max:30',
            'board_of_directors_owners' => 'required|boolean',
            'board_of_directors' => 'required_if:board_of_directors_owners,1|array',
            'board_of_directors.*.name' => 'required_if:board_of_directors_owners,1|nullable|string|max:64',
            'board_of_directors.*.designation' => 'nullable|string|max:64',
            'male_faculty' => 'required|integer|min:0',
            'female_faculty' => 'required|integer|min:0',
            'total_faculty' => 'nullable|integer|min:0',
            'examination_board' => 'required|in:BISE,CIE,PLC',

            // Types of Curriculum Adopted
            'curriculums' => 'required|array',
            'curriculums.*' => ['nullable', Rule::in(['National Curriculum', 'CIE', 'PLC'])],

            'national_education_policy_adherence' => 'required|string|max:191',
            'other_allied_facilities' => ['required', Rule::in(['Yes', 'No'])],

            // Enrollment Counts
            'grade_id' => 'required|exists:grades,id',
            'male_students' => 'required|integer|min:0',
            'female_students' => 'required|integer|min:0',

            // Owner
            'owner.name' => 'required|string|max:64|exists:users,name',
            'owner.designation' => 'required|string|max:64',
            'owner.mobile' => 'required|string|max:20',
            'owner.phone' => 'nullable|string|max:20',
            'owner.fax' => 'nullable|string|max:20',
            'owner.email' => 'required|email|max:64|exists:users,email',

            // Principal
            'principal.name' => 'required|string|max:64',
            'principal.designation' => 'required|string|max:64',
            'principal.mobile' => 'required|string|max:20',
            'principal.phone' => 'nullable|string|max:20',
            'principal.fax' => 'nullable|string|max:20',
            'principal.email' => 'required|email|max:64',

            // Faculty info (includes CV upload)
            'faculty' => 'nullable|array',
            'faculty.*.name' => 'required_with:faculty|string|max:64',
            'faculty.*.cnic' => 'required_with:faculty|string|max:15',
            'faculty.*.qualification' => [
                'required_with:faculty',
                'string',
                Rule::in([
                    'Graduation (BSc/ BA)',
                    'Graduation (BS 4 Years)',
                    'Post-Graduation (MA/ MSc etc.)',
                    'MS/ M.Phil',
                    'PhD',
                ]),
            ],
            'faculty.*.cv' => 'required_with:faculty|file|mimes:pdf,doc,docx|max:5120',

            // Infrastructure
            'infrastructure.building_type' => 'required|in:Purpose Built,Residential,Commercial',
            'infrastructure.building_possession' => 'required|in:Owned,Leased,Rented',
            'infrastructure.area_in_kanal' => 'required|numeric|min:0',
            'infrastructure.area_in_marla' => 'required|numeric|min:0',
            'infrastructure.no_of_classrooms' => 'required|integer|min:0',

            // The checkboxes only required if other_allied_facilities == 1 (Yes)
            'facilities.has_auditorium' => 'sometimes|boolean',
            'facilities.has_conference_room' => 'sometimes|boolean',
            'facilities.has_tutorial_room' => 'sometimes|boolean',
            'facilities.has_examination_hall' => 'sometimes|boolean',
            'facilities.has_other' => 'sometimes|boolean',

            // Other facilities input field shown only if has_other == 1
            'facilities.other_facilities' => 'required_if:facilities.has_other,1|nullable|string|max:191',

            // Library
            'library.has_library' => 'required|boolean',
            'library.no_of_books' => 'nullable|integer|min:0',
            'library.no_of_subscription_e_library' => 'nullable|integer|min:0',
            'library.no_of_subscription_e_journals' => 'nullable|integer|min:0',
            'other_resources.other_instructional_material' => 'required|boolean',
            'other_resources.has_atlas' => 'nullable|boolean',
            'other_resources.has_dictionaries' => 'nullable|boolean',
            'other_resources.has_encyclopedia' => 'nullable|boolean',
            'other_resources.has_daily_newspaper' => 'nullable|boolean',
            'other_resources.has_magazines' => 'nullable|boolean',
            //laboratories
            'science_laboratories' => 'required|in:yes,no,1,0,true,false',
            'physic_laboratories' => 'required_if:science_laboratories,yes,1|in:yes,no',
            'no_of_physic_laboratory_staff' => 'required_if:physic_laboratories,yes|nullable|integer|min:0',
            'has_bunsen_burner' => 'nullable|boolean',
            'has_test_tubes' => 'nullable|boolean',
            'physic_has_microscope' => 'nullable|boolean',
            'has_funnels' => 'nullable|boolean',
            'physics_has_eye_wash' => 'nullable|boolean',
            'physics_has_fume_hood' => 'nullable|boolean',
            'physics_has_disposable_masks' => 'nullable|boolean',
            'physics_has_lab_coat' => 'nullable|boolean',
            'bio_laboratories' => 'required_if:science_laboratories,yes,1|in:yes,no',
            'no_of_bio_laboratory_staff' => 'required_if:bio_laboratories,yes|nullable|integer|min:0',
            'has_siring' => 'nullable|boolean',
            'has_dropper' => 'nullable|boolean',
            'has_retort' => 'nullable|boolean',
            'has_beaker' => 'nullable|boolean',
            'bio_has_eye_wash' => 'nullable|boolean',
            'bio_has_fume_hood' => 'nullable|boolean',
            'bio_has_disposable_masks' => 'nullable|boolean',
            'bio_has_lab_coat' => 'nullable|boolean',
            'chemistry_laboratories' => 'required_if:science_laboratories,yes,1|in:yes,no',
            'no_of_chemistry_laboratory_staff' => 'required_if:chemistry_laboratories,yes|nullable|integer|min:0',
            'has_ph_strip' => 'nullable|boolean',
            'has_hot_plate' => 'nullable|boolean',
            'has_centrifuge' => 'nullable|boolean',
            'chemistry_has_microscope' => 'nullable|boolean',
            'chemistry_has_eye_wash' => 'nullable|boolean',
            'chemistry_has_fume_hood' => 'nullable|boolean',
            'chemistry_has_disposable_masks' => 'nullable|boolean',
            'chemistry_has_lab_coat' => 'nullable|boolean',
            'computer_laboratories' => 'required|in:yes,no,1,0,true,false',
            'no_of_computers' => 'required_if:computer_laboratories,yes,1|nullable|integer|min:0',
            'has_computer' => 'nullable|boolean',
            'has_modems' => 'nullable|boolean',
            'has_printer' => 'nullable|boolean',
            'has_scanner' => 'nullable|boolean',
            'has_laptops' => 'nullable|boolean',
            // Transparency Public Disclosures validation
            'fee_structure_public' => 'required|in:yes,no',
            'scholarship_policy_public' => 'required|in:yes,no',
            'other_income_source' => 'required|in:yes,no',
            'record_income_expenditure' => 'required|in:yes,no',
            'financial_accounts_audited' => 'required|in:yes,no',
            'academic_calendar_public' => 'required|in:yes,no',
            'faculty_to_admin_staff_ratio' => 'required|string|max:255',
            'extra_curricular_activities' => 'required|string|max:500',
            'extracurricular_facilities' => 'required|string|max:500',
        ];
    }
    public function after()
    {
        return [
            function ($validator) {

                $male = (int) $this->input('male_faculty');
                $female = (int) $this->input('female_faculty');
                $total = (int) $this->input('total_faculty');

                if ($total !== ($male + $female)) {
                    $validator->errors()->add(
                        'total_faculty',
                        'Total faculty is not correct. It must be sum of male & female faculty.'
                    );
                }

            }
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Institution name is required.',
            'name.string' => 'Institution name must be valid text.',
            'name.max' => 'Institution name cannot exceed 191 characters.',

            'level_2_id.required' => 'District is required.',
            'level_2_id.exists' => 'Selected district is invalid.',

            'level_3_id.required' => 'Tehsil is required.',
            'level_3_id.exists' => 'The tehsil you selected is invalid for the chosen district.',

            'level_4_id.required' => 'Village is required.',
            'level_4_id.exists' => 'the Village you selected is invalid for the chosen district & Tehsil.',

            'institution_nature.required' => 'Nature of school is required.',
            'institution_nature.in' => 'Invalid institution nature selected.',
            'institution_level.required' => 'School level is required.',
            'institution_level.in' => 'Invalid institution level selected.',
            'management_nature.required' => 'Nature of management is required.',
            'management_nature.in' => 'Invalid management nature selected.',
            'institution_type.required' => 'Type of institution is required.',
            'institution_type.in' => 'Invalid institution type selected.',
            'teaching_level.required' => 'Teaching level is required.',
            'teaching_level.in' => 'Invalid teaching level selected.',
            'institution_medium.required' => 'Medium of instruction is required.',
            'institution_medium.in' => 'Invalid institution medium selected.',

            'address.string' => 'Address must be valid text.',
            'address.max' => 'Address cannot exceed 256 characters.',

            'latitude.required' => 'This latitude field is required.',
            'latitude.numeric' => 'Latitude must be a number.',
            'latitude.between' => 'Latitude must be between -90 and 90.',

            'longitude.required' => 'this longitude field is required.',
            'longitude.numeric' => 'Longitude must be a number.',
            'longitude.between' => 'Longitude must be between -180 and 180.',

            'institution_official_web_url.required' => 'Official website url is required.',
            'institution_official_web_url.url' => 'Please enter a valid URL.',
            'institution_official_web_url.max' => 'Website URL cannot exceed 128 characters.',

            'institution_official_email.required' => 'Official email is required.',
            'institution_official_email.email' => 'Official email must be valid.',
            'institution_official_email.max' => 'Official email cannot exceed 128 characters.',

            'institution_phone.required' => 'Institution phone is required.',
            'institution_phone.max' => 'Phone number cannot exceed 20 characters.',

            'institution_fax.max' => 'Fax number cannot exceed 20 characters.',

            'institution_public_email.required' => 'Institution public is required.',
            'institution_public_email.email' => 'Public email must be valid.',
            'institution_public_email.max' => 'Public email cannot exceed 30 characters.',

            'board_of_directors_owners.boolean' => 'Board of directors field must be yes or no.',

            // =====================================
            // BOARD OF DIRECTORS
            // =====================================
            'board_of_directors.required_if' =>
                'Board of directors information is required when board of directors is selected as YES.',
            'board_of_directors.array' => 'Board of directors must be a valid list.',

            'board_of_directors.*.name.required_if' => 'Director name is required.',
            'board_of_directors.*.name.string' => 'Director name must be text.',
            'board_of_directors.*.name.max' => 'Director name cannot exceed 64 characters.',

            'board_of_directors.*.designation.required_if' => 'Director designation is required.',
            'board_of_directors.*.designation.string' => 'Director designation must be text.',
            'board_of_directors.*.designation.max' => 'Director designation cannot exceed 64 characters.',

            // =====================================
            // FACULTY COUNTS
            // =====================================
            'male_faculty.required' => 'Male faculty is required.',
            'male_faculty.integer' => 'Male faculty must be a number.',
            'male_faculty.min' => 'Male faculty cannot be negative.',

            'female_faculty.required' => 'Female faculty is required.',
            'female_faculty.integer' => 'Female faculty must be a number.',
            'female_faculty.min' => 'Female faculty cannot be negative.',

            'examination_board.required' => 'Examination Board is required',
            'examination_board.in' => 'Invalid examination board selected.',

            // =====================================
            // CURRICULUM
            // =====================================
            'curriculums.required' => 'At least one curriculum must be selected.',
            'curriculums.array' => 'Curriculums must be a valid list.',
            'curriculums.*.in' => 'Invalid curriculum selected.',

            'national_education_policy_adherence.required' => 'Input field must be required.',
            'national_education_policy_adherence.string' => 'Input must be valid text.',
            'national_education_policy_adherence.max' => 'Input exceeds maximum length.',

            'other_allied_facilities.required' => 'Selection between yes/no is required.',
            'other_allied_facilities.boolean' => 'Other allied facilities must be yes or no.',

            // =====================================
            // ENROLLMENT
            // =====================================
            'grade_id.required' => 'Grade is required.',
            'grade_id.exists' => 'Selected grade is invalid.',

            'male_students.required' => 'Male students count is required.',
            'male_students.integer' => 'Male students must be numeric.',
            'male_students.min' => 'Male students cannot be negative.',

            'female_students.required' => 'Female students count is required.',
            'female_students.integer' => 'Female students must be numeric.',
            'female_students.min' => 'Female students cannot be negative.',

            // =====================================
            // OWNER INFORMATION
            // =====================================
            'owner.name.required' => 'Owner name is required.',
            'owner.name.string' => 'Owner name must be valid text.',
            'owner.name.max' => 'Owner name cannot exceed 64 characters.',
            'owner.designation.required' => 'Owner designation is required.',
            'owner.designation.max' => 'Owner designation cannot exceed 64 characters.',
            'owner.mobile.required' => 'Owner mobile no is required.',
            'owner.mobile.max' => 'Owner mobile cannot exceed 20 characters.',
            'owner.phone.max' => 'Owner phone cannot exceed 20 characters.',
            'owner.fax.max' => 'Owner fax cannot exceed 20 characters.',
            'owner.email.required' => 'Owner email address is required.',
            'owner.email.email' => 'Owner email must be valid.',
            'owner.email.max' => 'Owner email cannot exceed 64 characters.',

            // =====================================
            // PRINCIPAL INFORMATION
            // =====================================
            'principal.name.required' => 'Principal name is required.',
            'principal.name.string' => 'Principal name must be valid text.',
            'principal.name.max' => 'Principal name cannot exceed 64 characters.',
            'principal.designation.required' => 'Principal designation is required.',
            'principal.designation.max' => 'Principal designation cannot exceed 64 characters.',
            'principal.mobile.required' => 'Principal mobile no is required.',
            'principal.mobile.max' => 'Principal mobile cannot exceed 20 characters.',
            'principal.phone.max' => 'Principal phone cannot exceed 20 characters.',
            'principal.fax.max' => 'Principal fax cannot exceed 20 characters.',
            'principal.email.required' => 'Principal email address is required.',
            'principal.email.email' => 'Principal email must be valid.',
            'principal.email.max' => 'Principal email cannot exceed 64 characters.',

            // =====================================
            // FACULTY (ARRAY)
            // =====================================
            'faculty.array' => 'Faculty list must be valid.',
            'faculty.*.name.required_with' => 'Faculty name is required.',
            'faculty.*.name.string' => 'Faculty name must be a valid text.',
            'faculty.*.name.max' => 'Faculty name cannot exceed 64 characters.',

            'faculty.*.cnic.required_with' => 'Faculty CNIC is required.',
            'faculty.*.cnic.max' => 'Faculty CNIC cannot exceed 15 characters.',

            'faculty.*.qualification.required_with' => 'Faculty qualification is required.',
            'faculty.*.qualification.in' => 'Invalid qualification selected.',

            'faculty.*.cv.required_with' => 'Faculty member CV is required.',
            'faculty.*.cv.mimes' => 'CV must be a PDF or DOC file.',
            'faculty.*.cv.max' => 'CV cannot exceed 5MB.',

            // =====================================
            // INFRASTRUCTURE
            // =====================================
            'infrastructure.building_type.required' => 'Building type is required.',
            'infrastructure.building_type.in' => 'Invalid building type selected.',

            'infrastructure.building_possession.required' => 'Building possession type is required.',
            'infrastructure.building_possession.in' => 'Invalid building possession selected.',

            'infrastructure.area_in_kanal.required' => 'Area in kanal are required.',
            'infrastructure.area_in_kanal.numeric' => 'Area in kanal must be numeric.',
            'infrastructure.area_in_marla.required' => 'Area in marla are required.',
            'infrastructure.area_in_marla.numeric' => 'Area in marla must be numeric.',
            'infrastructure.no_of_classrooms.required' => 'Number of classrooms are required.',
            'infrastructure.no_of_classrooms.integer' => 'Number of classrooms must be numeric.',

            // =====================================
            // FACILITIES
            // =====================================
            'facilities.has_auditorium.boolean' => 'Invalid value for auditorium.',
            'facilities.has_conference_room.boolean' => 'Invalid value for conference room.',
            'facilities.has_tutorial_room.boolean' => 'Invalid value for tutorial room.',
            'facilities.has_examination_hall.boolean' => 'Invalid value for examination hall.',
            'facilities.has_other.boolean' => 'Invalid value for other facilities.',
            'facilities.other_facilities.required_if' => 'Please specify if the institution has other facilities.',
            'facilities.other_facilities.string' => 'Other facilities must be valid text.',
            'facilities.other_facilities.max' => 'Other facilities cannot exceed 191 characters.',

            // =====================================
            // LIBRARY
            // =====================================
            'library.has_library.required' => 'Selection of library is required between Yes/No.',
            'library.has_library.boolean' => 'Invalid value for library field.',

            'library.no_of_books.integer' => 'Number of books must be numeric.',
            'library.no_of_subscription_e_library.integer' => 'E-library subscriptions must be numeric.',
            'library.no_of_subscription_e_journals.integer' => 'E-journals subscriptions must be numeric.',

            // =====================================
            // OTHER RESOURCES
            // =====================================
            'other_resources.other_instructional_material.required' => 'Yes/No is required for instructional material.',
            'other_resources.other_instructional_material.boolean' => 'Instructional material field must be yes or no.',

            'other_resources.*.boolean' => 'Resource values must be yes or no.',

            // =====================================
            // LABS
            // =====================================
            'science_laboratories.required' => 'Science laboratories selection is required between Yes/No.',
            'science_laboratories.in' => 'Invalid science laboratory selection.',

            'physic_laboratories.required_if' => 'Physics laboratory Yes/No is required if science lab exist.',
            'physic_laboratories.in' => 'Invalid physics laboratory selection.',

            'bio_laboratories.required_if' => 'Biology laboratory Yes/No is required if science lab exist.',
            'bio_laboratories.in' => 'Invalid biology laboratory selection.',

            'chemistry_laboratories.required_if' => 'Chemistry laboratory Yes/No is required if science lab exist.',
            'chemistry_laboratories.in' => 'Invalid chemistry laboratory selection.',

            'computer_laboratories.required' => 'Computer laboratories selection is required between Yes/No.',
            'computer_laboratories.in' => 'Invalid computer laboratory selection.',

            'no_of_physic_laboratory_staff.required_if' => 'How many physics lab staff do you have.',
            'no_of_physic_laboratory_staff.integer' => 'Physics lab staff must be numeric.',
            'no_of_bio_laboratory_staff.required_if' => 'How many biology lab staff do you have.',
            'no_of_bio_laboratory_staff.integer' => 'Biology lab staff must be numeric.',
            'no_of_chemistry_laboratory_staff.required_if' => 'How many chemistry lab staff do you have.',
            'no_of_chemistry_laboratory_staff.integer' => 'Chemistry lab staff must be numeric.',
            'no_of_computers.required_if' => 'How many computers are there.',
            'no_of_computers.integer' => 'Number of computers must be numeric.',

            // =====================================
            // TRANSPARENCY / PUBLIC DISCLOSURE
            // =====================================
            'fee_structure_public.required' => 'Check between Yes/No is required.',
            'fee_structure_public.in' => 'Invalid value for fee structure.',

            'scholarship_policy_public.required' => 'Check between Yes/No is required.',
            'scholarship_policy_public.in' => 'Invalid scholarship policy value.',

            'other_income_source.required' => 'Check between Yes/No is required.',
            'other_income_source.in' => 'Invalid other income source value.',

            'record_income_expenditure.required' => 'Check between Yes/No is required.',
            'record_income_expenditure.in' => 'Invalid record income selection.',

            'financial_accounts_audited.required' => 'Check between Yes/No is required.',
            'financial_accounts_audited.in' => 'Invalid audit selection.',

            'academic_calendar_public.required' => 'Check between Yes/No is required.',
            'academic_calendar_public.in' => 'Invalid academic calendar selection.',

            'faculty_to_admin_staff_ratio.required' => 'This Admin Staff ratio field is required.',
            'faculty_to_admin_staff_ratio.max' => 'Ratio cannot exceed 255 characters.',
            'extra_curricular_activities.required' => 'This Extra Curricular activities field is required.',
            'extra_curricular_activities.max' => 'Extracurricular activities cannot exceed 500 characters.',
            'extracurricular_facilities.required' => 'This Extracurricular facilities field is required.',
            'extracurricular_facilities.max' => 'Extracurricular facilities cannot exceed 500 characters.',
        ];
    }
}
