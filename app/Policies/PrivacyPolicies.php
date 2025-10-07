<?php

namespace App\Policies;

use Illuminate\Http\Request;

class PrivacyPolicies
{
    public function policies()
    {
        return view('privacy.privacy_policies');
    }

    public function cookie()
    {
        return view('privacy.cookies');
    }
    
    public function condicion()
    {
        return view('privacy.condiciones');
    }

    public function promocional()
    {
        return view('privacy.promocional');
    }
}
