<?php

namespace App\Http\Controllers;

use App\Models\DouTopTask;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DouTopTaskController extends Controller
{
    public function index(Request $request)
    {
        $douTopTasks = DouTopTask::query()
            ->when($request->query('state'), function (Builder $builder, $state) {
                $builder->where('state', $state);
            })
            ->paginate()->appends($request->all());

        return view('douTopTasks.index', compact('douTopTasks'));
    }
}
