<?php

namespace App;


trait RecordActivity
{

    protected static function bootRecordActivity()
    {
        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event)
        {
            static::$event(function($model) use ($event) {
                $model->recordActivity($event);
            });
        }

    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {

        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);

        /*Activity::create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
            'subject_id' => $this->id,
            'subject_type' => get_class($this)
        ]);*/
    }

    protected function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $name = strtolower((new \ReflectionClass($this))->getShortName());
        return $event . '_' . $name;
    }

}