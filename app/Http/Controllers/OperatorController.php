<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Queue;
use App\Models\Service;
use Illuminate\Contracts\Queue\Queue as QueueQueue;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $counters = Counter::where('is_active', true)->get();
        return view('operator.index', compact('counters'));
    }

    public function dashboard($counterId)
    {
        $counter = Counter::findOrFail($counterId);
        $services = Service::where('is_active', true)->get();

        $currentQueue = Queue::with('service')
                        ->where('counter_id', $counterId)
                        ->where('status', 'calling')
                        ->first();

        return view('operator.dashboard', compact('counter', 'services', 'currentQueue'));
    }

    public function callNext(Request $request)
    {
        $counter = Counter::findOrFail($request->counter_id);
        $service = Service::findOrFail($request->service_id);

        // Set any currently calling queue to served
        Queue::where('counter_id', $counter->id)
            ->where('status', 'calling')
            ->update([
                'status' => 'served',
                'served_at' => now()
            ]);

        // Get next queue
        $nextQueue = Queue::where('service_id', $service->id)
                    ->where('status', 'waiting')
                    ->orderBy('created_at')
                    ->first();

        if (!$nextQueue) {
            return response()->json([
                'success' => false,
                'message' => 'No more queues for this service.'
            ]);
        }

        $nextQueue->update([
            'status' => 'calling',
            'counter_id' => $counter->id,
            'called_at' => now()
        ]);

        // Reload the queue with relationships
        $nextQueue->load('service');

        // Trigger event for real-time update (use Laravel Echo, Pusher, etc.)
        // event(new QueueCalled($nextQueue));

        return response()->json([
            'success' => true,
            'queue' => $nextQueue
        ]);
    }

    public function complete(Request $request)
    {
        $queue = Queue::findOrFail($request->queue_id);

        $queue->update([
            'status' => 'served',
            'served_at' => now()
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function skip(Request $request)
    {
        $queue = Queue::findOrFail($request->queue_id);

        $queue->update([
            'status' => 'skipped',
            'counter_id' => null
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
