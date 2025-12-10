<?php

namespace App\Http\Controllers\Client\Web;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{

    public function index()
    {
        $clientId = Auth::user()->client->id;

        // Get all devices for this client
        $devices = Device::where('client_id', $clientId)->get();

        // Count devices by status
        $statusCounts = [
            'total'      => $devices->count(),
            'pending'    => $devices->where('status', 'pending')->count(),
            'connected'  => $devices->where('status', 'connected')->count(),
            'logged_out' => $devices->where('status', 'logged_out')->count(),
            'blocked'    => $devices->where('status', 'blocked')->count(),
        ];

        return view('backend.client.web.devices.index', compact('devices', 'statusCounts'));
    }

    public function deviceSetting($id)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));
            return back();
        }
        $data = Device::find($id);
        return view('backend.client.web.devices.setting', compact('data')); 
    }

    public function deviceChat($id)
    {
        $data = Device::find($id);
        $data->active_for_chat = 1;
        $data->active_for_chat_time = now();
        $data->update();

        return redirect()->route('client.web.chat.index');
    }

    public function allDevices()
    {
        $clientId = Auth::user()->client->id;

        $devices = Device::where('client_id', $clientId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Devices retrieved successfully.',
            'data' => $devices
        ], 200);
        
    }

    public function deviceActive($id)
    {
        $data = Device::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Device not found'], 404);
        }

        $data->active_for_chat = 1;
        $data->active_for_chat_time = now();
        $data->save();

        return response()->json(['success' => true, 'message' => 'Device Selected successfully']);
    }


}
