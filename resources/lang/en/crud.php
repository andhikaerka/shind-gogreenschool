<?php

return [
    'userManagement' => [
        'title' => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title' => 'Permissions',
        'title_singular' => 'Permission',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'title' => 'Title',
            'title_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role' => [
        'title' => 'Roles',
        'title_singular' => 'Role',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'title' => 'Title',
            'title_helper' => '',
            'permissions' => 'Permissions',
            'permissions_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'user' => [
        'title' => 'Users',
        'title_singular' => 'User',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'email' => 'Email',
            'email_helper' => '',
            'email_verified_at' => 'Email verified at',
            'email_verified_at_helper' => '',
            'password' => 'Password',
            'password_helper' => '',
            'roles' => 'Roles',
            'roles_helper' => '',
            'remember_token' => 'Remember Token',
            'remember_token_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
            'approved' => 'Approved',
            'approved_helper' => '',
            'username' => 'Username',
            'username_helper' => '',
        ],
    ],
    'school' => [
        'title' => 'School',
        'title_singular' => 'School',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'level' => 'Level',
            'level_helper' => '',
            'vision' => 'Vision',
            'vision_helper' => '',
            'status' => 'Status',
            'status_helper' => '',
            'address' => 'Address',
            'address_helper' => '',
            'phone' => 'Phone',
            'phone_helper' => '',
            'email' => 'Email',
            'email_helper' => '',
            'total_students' => 'Total Students',
            'total_students_helper' => '',
            'total_teachers' => 'Total Teachers',
            'total_teachers_helper' => '',
            'total_land_area' => 'Total Land Area',
            'total_land_area_helper' => '',
            'total_building_area' => 'Total Building Area',
            'total_building_area_helper' => '',
            'logo' => 'Logo',
            'logo_helper' => '',
            'photo' => 'Photo',
            'photo_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
            'city' => 'City',
            'city_helper' => '',
            'user' => 'User',
            'user_helper' => '',
        ],
    ],
    'infrastructure' => [
        'title' => 'Infrastructure',
        'title_singular' => 'Infrastructure',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'aspect' => 'Aspect',
            'aspect_helper' => '',
            'total' => 'Total',
            'total_helper' => '',
            'function' => 'Function',
            'function_helper' => '',
            'photo' => 'Photo',
            'photo_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'disaster' => [
        'title' => 'Disaster',
        'title_singular' => 'Disaster',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'potential' => 'Potential',
            'potential_helper' => '',
            'vulnerability' => 'Vulnerability',
            'vulnerability_helper' => '',
            'impact' => 'Impact',
            'impact_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
            'threats' => 'Threats',
            'threats_helper' => '',
        ],
    ],
    'disasterThreat' => [
        'title' => 'Disaster Threat',
        'title_singular' => 'Disaster Threat',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'qualityReport' => [
        'title' => 'Environment',
        'title_singular' => 'Environment',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'has_document' => 'Has Document',
            'has_document_helper' => '',
            'document' => 'Document',
            'document_helper' => '',
            'waste_management' => 'Waste Management',
            'waste_management_helper' => '',
            'energy_conservation' => 'Energy Conservation',
            'energy_conservation_helper' => '',
            'life_preservation' => 'Life Preservation',
            'life_preservation_helper' => '',
            'water_conservation' => 'Water Conservation',
            'water_conservation_helper' => '',
            'canteen_management' => 'Canteen Management',
            'canteen_management_helper' => '',
            'letter' => 'Letter',
            'letter_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'team' => [
        'title' => 'Team',
        'title_singular' => 'Team',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'status' => 'Status',
            'status_helper' => '',
            'gender' => 'Gender',
            'gender_helper' => '',
            'birth_date' => 'Birth Date',
            'birth_date_helper' => '',
            'aspect' => 'Sector',
            'aspect_helper' => '',
            'position' => 'Position',
            'position_helper' => '',
            'job_description' => 'Job Description',
            'job_description_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
            'user' => 'User',
            'user_helper' => '',
        ],
    ],
    'study' => [
        'title' => 'Study',
        'title_singular' => 'Study',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'quality_report' => 'Quality Report',
            'quality_report_helper' => '',
            'potential' => 'Potential',
            'potential_helper' => '',
            'problem' => 'Problem',
            'problem_helper' => '',
            'activity' => 'Activity',
            'activity_helper' => '',
            'behavioral' => 'Behavioral',
            'behavioral_helper' => '',
            'physical' => 'Physical',
            'physical_helper' => '',
            'kbm' => 'Kbm',
            'kbm_helper' => '',
            'artwork' => 'Artwork',
            'artwork_helper' => '',
            'period' => 'Period',
            'period_helper' => '',
            'cost' => 'Cost',
            'cost_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
            'work_group' => 'Work Group',
            'work_group_helper' => '',
            'partner' => 'Partner',
            'partner_helper' => '',
        ],
    ],
    'partner' => [
        'title' => 'Partner',
        'title_singular' => 'Partner',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'phone' => 'Phone',
            'phone_helper' => '',
            'category' => 'Category',
            'category_helper' => '',
            'activity' => 'Activity',
            'activity_helper' => '',
            'date' => 'Date',
            'date_helper' => '',
            'purpose' => 'Purpose',
            'purpose_helper' => '',
            'total_people' => 'Total People',
            'total_people_helper' => '',
            'photo' => 'Photo',
            'photo_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'workGroup' => [
        'title' => 'Work Group',
        'title_singular' => 'Work Group',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'year' => 'Year',
            'year_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'field' => 'Field',
            'field_helper' => '',
            'tutor_1' => 'Tutor 1',
            'tutor_1_helper' => '',
            'tutor_2' => 'Tutor 2',
            'tutor_2_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'cadre' => [
        'title' => 'Cadre',
        'title_singular' => 'Cadre',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'work_group' => 'Work Group',
            'work_group_helper' => '',
            'gender' => 'Gender',
            'gender_helper' => '',
            'class' => 'Class',
            'class_helper' => '',
            'phone' => 'Phone',
            'phone_helper' => '',
            'birth_date' => 'Birth Date',
            'birth_date_helper' => '',
            'address' => 'Address',
            'address_helper' => '',
            'hobby' => 'Hobby',
            'hobby_helper' => '',
            'position' => 'Position',
            'position_helper' => '',
            'photo' => 'Photo',
            'photo_helper' => '',
            'letter' => 'Letter',
            'letter_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
            'user' => 'User',
            'user_helper' => '',
        ],
    ],
    'workProgram' => [
        'title' => 'Work Program',
        'title_singular' => 'Work Program',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'work_group' => 'Work Group',
            'work_group_helper' => '',
            'study' => 'Study',
            'study_helper' => '',
            'condition' => 'Condition',
            'condition_helper' => '',
            'plan' => 'Plan',
            'plan_helper' => '',
            'activity' => 'Activity',
            'activity_helper' => '',
            'featured' => 'Featured',
            'featured_helper' => '',
            'photo' => 'Photo',
            'photo_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'province' => [
        'title' => 'Province',
        'title_singular' => 'Province',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'code' => 'Code',
            'code_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'city' => [
        'title' => 'City',
        'title_singular' => 'City',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'province' => 'Province',
            'province_helper' => '',
            'code' => 'Code',
            'code_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'budgetPlan' => [
        'title' => 'Budget Plan',
        'title_singular' => 'Budget Plan',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'aspect_id' => 'Topic',
            'aspect_id_helper' => '',
            'description' => 'Description',
            'description_helper' => '',
            'cost' => 'Cost',
            'cost_helper' => '',
            'category' => 'Category',
            'category_helper' => '',
            'source' => 'Source',
            'source_helper' => '',
            'pic' => 'Treasurer',
            'pic_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'curriculumCalendar' => [
        'title' => 'Curriculum Calendar',
        'title_singular' => 'Curriculum Calendar',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'name' => 'Name',
            'name_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'lessonPlan' => [
        'title' => 'Lesson Plan',
        'title_singular' => 'Lesson Plan',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'school' => 'School',
            'school_helper' => '',
            'ktsp_or_rpp' => 'Ktsp Or Rpp',
            'ktsp_or_rpp_helper' => '',
            'vision' => 'Vision',
            'vision_helper' => '',
            'mission' => 'Mission',
            'mission_helper' => '',
            'purpose' => 'Purpose',
            'purpose_helper' => '',
            'subject' => 'Subject',
            'subject_helper' => '',
            'teacher' => 'Teacher',
            'teacher_helper' => '',
            'class' => 'Class',
            'class_helper' => '',
            'aspect' => 'Aspect',
            'aspect_helper' => '',
            'hook' => 'Hook',
            'hook_helper' => '',
            'artwork' => 'Artwork',
            'artwork_helper' => '',
            'hour' => 'Hour',
            'hour_helper' => '',
            'period' => 'Period',
            'period_helper' => '',
            'syllabus' => 'Syllabus',
            'syllabus_helper' => '',
            'rpp' => 'Rpp',
            'rpp_helper' => '',
            'calendars' => 'Calendars',
            'calendars_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'planning' => [
        'title' => 'Planning',
        'title_singular' => 'Planning',
    ],
    'implementationActivity' => [
        'title' => 'Implementation Activities',
        'title_singular' => 'Implementation Activity',
    ],
    'monitoringAndEvaluation' => [
        'title' => 'Monitoring and Evaluation',
        'title_singular' => 'Monitoring and Evaluation',
    ],
    'assessment' => [
        'title' => 'Assessment',
        'title_singular' => 'Assessment',
    ],
    'setting' => [
        'title' => 'Settings',
        'title_singular' => 'Setting',
    ],
    'activity' => [
        'title' => 'Activity',
        'title_singular' => 'Activity',
        'fields' => [
            'id' => 'ID',
            'id_helper' => '',
            'slug' => 'Slug',
            'slug_helper' => '',
            'title' => 'Title',
            'title_helper' => '',
            'content' => 'Content',
            'content_helper' => '',
            'created_at' => 'Created at',
            'created_at_helper' => '',
            'updated_at' => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at' => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'oneYearActivity' => [
        'title' => 'One Year Activity',
        'title_singular' => 'One Year Activity',
    ],
    'assessmentResult' => [
        'title' => 'Assessment Results',
        'title_singular' => 'Assessment Result',
    ],
    'thisYearActionPlan' => [
        'title' => 'This Year Action Plan',
        'title_singular' => 'This Year Action Plan',
    ],
    'nextYearActionPlan' => [
        'title' => 'Next Year Action Plan',
        'title_singular' => 'Next Year Action Plan',
    ],
    'auditLog' => [
        'title' => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields' => [
            'id' => 'ID',
            'id_helper' => ' ',
            'description' => 'Description',
            'description_helper' => ' ',
            'subject_id' => 'Subject ID',
            'subject_id_helper' => ' ',
            'subject_type' => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id' => 'User ID',
            'user_id_helper' => ' ',
            'properties' => 'Properties',
            'properties_helper' => ' ',
            'host' => 'Host',
            'host_helper' => ' ',
            'created_at' => 'Created at',
            'created_at_helper' => ' ',
            'updated_at' => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
];
