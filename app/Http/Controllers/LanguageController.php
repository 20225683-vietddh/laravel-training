<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $language) {
        Session::put('lang', $language);

        // Nếu có 'return_to' trong URL thì dùng, nếu không thì fallback về trang trước hoặc trang chủ
        $returnTo = $request->query('return_to') ?? url()->previous() ?? '/';

        return redirect($returnTo);
    }
}
