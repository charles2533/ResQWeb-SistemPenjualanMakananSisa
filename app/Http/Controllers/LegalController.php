<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function terms(): View
    {
        if (request('audience') === 'seller') {
            return $this->sellerTerms();
        }

        if (request('audience') === 'customer') {
            return $this->customerTerms();
        }

        if (Auth::check() && Auth::user()->role === 'seller') {
            return $this->sellerTerms();
        }

        return $this->customerTerms();
    }

    public function customerTerms(): View
    {
        return view('legal.terms-customer');
    }

    public function sellerTerms(): View
    {
        return view('legal.terms-seller');
    }

    public function pnc(): View
    {
        return view('legal.pnc');
    }
}
