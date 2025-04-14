<?php

namespace App\Observers;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class Logger implements ShouldHandleEventsAfterCommit
{
    public function created(Model $model)
    {
        $this->logOperation('create', $model);
    }

    public function updated(Model $model)
    {
        $this->logOperation('update', $model);
    }

    public function deleted(Model $model)
    {
        $this->logOperation('delete', $model);
    }

    public function restored(Model $model)
    {
        $this->logOperation('restore', $model);
    }

    protected function logOperation(string $operation, Model $model)
    {
        $userId = Auth::id();
        Log::create([
            'table_name' => $model->getTable(),
            'record_id' => $model->getKey(),
            'operation' => $operation,
            'old_data' => $operation === 'update' ? json_encode($model->getOriginal()) : null,
            'new_data' => $operation === 'create' || $operation === 'update' ? json_encode($model->getAttributes()) : null,
            'user_id' => $userId,
        ]);
    }
}
