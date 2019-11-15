<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Builder;

trait DateScope
{
    public function scopeDate(Builder $builder, $date = null)
    {
        if ($date === null)
            return;

        if (is_numeric($date)) {
            switch ($date) {
                case 1:
                    $date = now();
                    break;
                case 2:
                    $date = now()->addDays(-1);
                    break;
                case 3:
                    $date = [
                        now()->addDays(-7),
                        now()->addDay(),
                    ];
                    break;
                case 4:
                    $date = [
                        now()->firstOfMonth(),
                        now()->addDay(),
                    ];
                    break;
            }
        }

        if (!is_array($date)) {
            $date = [$date];
        }

        if (count($date) === 2) {
            $builder->whereBetween($this->getDateField(), $date);
        } elseif (count($date) === 1) {
            $builder->whereDate($this->getDateField(), $date[0]);
        }
    }

    protected function getDateField()
    {
        return $this->getTable() . '.created_at';
    }
}