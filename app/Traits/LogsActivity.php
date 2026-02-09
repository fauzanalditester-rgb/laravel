<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', null, $model->toArray());
        });

        static::updated(function ($model) {
            $model->logActivity('updated', $model->getOriginal(), $model->getDirty());
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->toArray(), null);
        });
    }

    protected function logActivity($action, $oldValues, $newValues)
    {
        if (auth()->check()) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'module' => class_basename($this),
                'action' => $action,
                'description' => $action . ' ' . class_basename($this) . ' with ID: ' . $this->id,
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => Request::ip(),
            ]);
        }
    }
}
