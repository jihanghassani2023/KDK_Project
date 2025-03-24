<?php
namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        $waitingQueues = Queue::with('service')
                            ->where('status', 'waiting')
                            ->orderBy('created_at')
                            ->get();
        $currentlyServing = Queue::with(['service', 'counter'])
                            ->where('status', 'calling')
                            ->get();

        return view('queue.index', compact('services', 'waitingQueues', 'currentlyServing'));
    }

    public function create(Request $request)
    {
        $service = Service::findOrFail($request->service_id);

        // Generate queue number (e.g., A001, B001)
        $lastQueue = Queue::where('service_id', $service->id)
                        ->whereDate('created_at', Carbon::today())
                        ->latest()
                        ->first();

        $number = 1;
        if ($lastQueue) {
            $lastNumber = substr($lastQueue->queue_number, 1);
            $number = intval($lastNumber) + 1;
        }

        $queueNumber = $service->code . str_pad($number, 3, '0', STR_PAD_LEFT);

        $queue = Queue::create([
            'service_id' => $service->id,
            'queue_number' => $queueNumber,
            'status' => 'waiting',
        ]);

        return response()->json([
            'success' => true,
            'queue' => $queue->load('service'),
            'ticket_info' => [
                'queue_number' => $queue->queue_number,
                'service_name' => $service->name,
                'created_at' => $queue->created_at->format('d M Y H:i:s'),
            ]
        ]);
    }

    public function display()
    {
        $currentlyServing = Queue::with(['service', 'counter'])
                            ->where('status', 'calling')
                            ->get();

        return view('queue.display', compact('currentlyServing'));
    }
}