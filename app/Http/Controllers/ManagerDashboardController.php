<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the manager dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $manager = Auth::user();
        
        // Get all employees excluding the manager
        $totalEmployees = User::where('id', '!=', $manager->id)->count();
        
        // Get interns count (excluding manager)
        $internsCount = User::where('role', 'Intern')
            ->where('id', '!=', $manager->id)
            ->count();
        
        // Get permanent employees count (Employee and Team_Lead roles, excluding manager)
        $permanentCount = User::whereIn('role', ['Employee', 'Team_Lead'])
            ->where('id', '!=', $manager->id)
            ->count();
        
        // Calculate percentages
        $totalForPercentage = $internsCount + $permanentCount;
        $internPercentage = $totalForPercentage > 0 ? round(($internsCount / $totalForPercentage) * 100) : 0;
        $permanentPercentage = $totalForPercentage > 0 ? round(($permanentCount / $totalForPercentage) * 100) : 0;
        
        return view('manager.dashboard', [
            'totalEmployees' => $totalEmployees,
            'internsCount' => $internsCount,
            'permanentCount' => $permanentCount,
            'internPercentage' => $internPercentage,
            'permanentPercentage' => $permanentPercentage,
        ]);
    }
}


