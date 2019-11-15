<?php

namespace App\Http\Controllers;

use App\Models\DouTopTask;
use App\Services\DouAccountService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DouTopTaskController extends Controller
{
    public function index(Request $request)
    {
        $douTopTasks = DouTopTask::query()
            ->with(['douaccount'])
            ->when($request->query('state'), function (Builder $builder, $state) {
                $builder->where('state', $state);
            })
            ->when($request->query('account_id'), function (Builder $builder, $account_id) {
                $builder->where('aweme_author_id', $account_id);
            })
            ->orderBy('create_time', 'desc')
            ->paginate()->appends($request->all());

        $douAccounts = app(DouAccountService::class)->getAll(['user_id', 'nick']);

        return view('douTopTasks.index', compact('douTopTasks', 'douAccounts'));
    }
}
