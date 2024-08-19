<?php

namespace App\Http\Controllers;

use App\Actions\CreateWeddingEvent;
use App\Actions\CreateWeddingPage;
use App\Models\PagesType;
use App\Models\PageType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OnboardingController extends Controller
{
    public function index()
    {
        if (auth()->user()->onboardingComplete()) {
            return redirect()->route('dashboard');
        }
        return Inertia::render('Onboarding/Index', [
            'types' => PagesType::with('pageOnboardingForms')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $type = PagesType::find($request->type);
        $data = collect($request->data);

       if($type->name == 'Wedding Invitation') {
            CreateWeddingPage::handle($request->user()->id, $data, $type);
       }

       return redirect()->route('dashboard');
    }
}
