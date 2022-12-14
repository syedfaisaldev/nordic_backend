<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatisticsRequest;
use App\Http\Requests\UpdateStatisticsRequest;
use App\Models\Statistics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer_id = $request->customer_id;
        $job_id = $request->job_id;
        $client_id = $request->client_id;
        $Backupset = $request->Backupset;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $hour = $request->hour;
        $where = [];

        if (isset($customer_id)) {
            $where['customer_id'] =  $customer_id;
        }
        if (isset($job_id)) {
            $where['job_id'] =  $job_id;
        }
        if (isset($client_id)) {
            $where['client_id'] =  $client_id;
        }
        if (isset($client_id)) {
            $where['client_id'] =  $client_id;
        }
        if (isset($Backupset)) {
            $where['Backupset'] =  $Backupset;
        }
        if (isset($hour) &&  $hour != 0) {
            $hour_from =  date("H:i:s", strtotime($hour . ':00:00'));
            $hour_to =  date("H:i:s", strtotime($hour . ':59:00'));
        }

        $data = [];
        if (isset($date_from) || isset($hour)) {
            if ($date_from && !$hour) {
                $data = Statistics::where($where)
                    ->whereDate('time_stamp', '>=', $date_from)
                    ->whereDate('time_stamp', '<=', $date_to)
                    ->paginate(5);
            } else if ($hour && $hour != 0 && !$date_from) {
                $data = Statistics::where($where)
                    ->whereTime('time_stamp', '>=', $hour_from)
                    ->whereTime('time_stamp', '<=', $hour_to)
                    ->paginate(5);
            } else {
                $date_from =  $date_from . ' ' . date("H:i:s", strtotime($hour . ':00:00'));
                $date_to =  $date_to . ' ' . date("H:i:s", strtotime($hour . ':59:00'));
                $data = Statistics::where($where)
                    ->where('time_stamp', '>=', $date_from)
                    ->where('time_stamp', '<=', $date_to)
                    ->paginate(5);
            }
        } else {
            $data = Statistics::where($where)->paginate(5);
        }
        return response()->json(["Status" => 'Success', 'response' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function customers(Request $request)
    {
        $customers = Statistics::select('customer_id')->distinct()->paginate(20);
        return response()->json(["Status" => "Success", "response" => $customers]);
    }

    public function clients(Request $request)
    {
        $customer_id = $request->customer_id;
        $clients = Statistics::select('client_id')
            ->where(["customer_id" => $customer_id])
            ->distinct()
            ->paginate(20);
        return response()->json(["Status" => "Success", "response" => $clients]);
    }

    public function jobs(Request $request)
    {
        $client_id = $request->client_id;
        $jobs = Statistics::select('job_id')
            ->where(["client_id" => $client_id])
            ->distinct()
            ->paginate(20);
        return response()->json(["Status" => "Success", "response" => $jobs]);
    }
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatisticsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatisticsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param  \App\Http\Requests\StoreStatisticsRequest  $request
     * @param  \App\Models\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function show(Statistics $statistics)
    {
        dd($statistics->date_from);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function edit(Statistics $statistics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatisticsRequest  $request
     * @param  \App\Models\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatisticsRequest $request, Statistics $statistics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statistics $statistics)
    {
        //
    }
}
