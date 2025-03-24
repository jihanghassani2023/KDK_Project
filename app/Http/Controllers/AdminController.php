<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Queue;
use App\Models\queues;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalServicesCount = Service::count();
        $totalCountersCount = Counter::count();
        $todayQueuesCount = Queue::whereDate('created_at', now()->toDateString())->count();
        $servedQueuesCount = Queue::whereDate('created_at', now()->toDateString())
                            ->where('status', 'served')
                            ->count();

        $services = Service::withCount(['queues as waiting_count' => function($query) {
            $query->where('status', 'waiting');
        }])->get();

        $counters = Counter::withCount(['queues as served_today' => function($query) {
            $query->where('status', 'served')
                ->whereDate('created_at', now()->toDateString());
        }])->get();

        return view('admin.dashboard', compact(
            'totalServicesCount',
            'totalCountersCount',
            'todayQueuesCount',
            'servedQueuesCount',
            'services',
            'counters'
        ));
    }

    // Services Management
    public function services()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    public function createService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:5|unique:services',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Service::create($validated);

        return redirect()->route('admin.services')->with('success', 'Service created successfully');
    }

    // Counters Management
    public function counters()
    {
        $counters = Counter::all();
        return view('admin.counters.index', compact('counters'));
    }

    public function createCounter(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Counter::create($validated);

        return redirect()->route('admin.counters')->with('success', 'Counter created successfully');
    }
}
