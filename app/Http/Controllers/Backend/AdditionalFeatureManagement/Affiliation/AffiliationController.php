<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\Affiliation;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationHistory;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationRegistration;
use Illuminate\Http\Request;

class AffiliationController extends Controller
{
    public function generateAffiliateCode()
    {
        $existUser = AffiliationRegistration::whereUserId(ViewHelper::loggedUser()->id)->first();
        if (isset($existUser))
        {
            return ViewHelper::returEexceptionError('You already applied.');
        } else {
            $affiliateReg = new AffiliationRegistration();
            $affiliateReg->user_id  = ViewHelper::loggedUser()->id;
            $affiliateReg->affiliate_code   = $this->generateUniqueCodeForAffiliate();
            $affiliateReg->status = 1;
            $affiliateReg->save();
            return ViewHelper::returnSuccessMessage('Your Application submitted successfully.');
        }
    }

    public function generateUniqueCodeForAffiliate()
    {
        $code = rand(10000000, 99999990);
        $existCode = AffiliationRegistration::where('affiliate_code', $code)->first();
        if (!empty($existCode))
        {
//            return 1;
            $this->generateUniqueCodeForAffiliate();
        } else {
            return $code;
        }
    }

    public function showAffiliationHistory()
    {
        return view('backend.additional-features-management.affiliation.registrations', ['affiliationRegistrations' => AffiliationRegistration::latest()->get()]);
    }
    public function showAffiliateHistory($id)
    {
        return view('backend.additional-features-management.affiliation.history', ['affiliationRegistration' => AffiliationRegistration::find($id)]);
    }
}
