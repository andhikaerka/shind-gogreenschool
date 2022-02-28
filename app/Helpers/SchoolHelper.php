<?php

function getSchoolProfile(){
    $schoolProfile = \app\SchoolProfile::where('school_id', auth()->user()->IsSTC)->where('is_active', true)->first();
    return $schoolProfile;
}
