<?php

namespace App\Http\Controllers;
class LanguageController
{
    public function switchLanguage($lang)
    {
        // Save the selected language in session or wherever needed
        session()->put('locale', $lang);

        // Redirect back to the previous page
        return redirect()->back();
    }
}