<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded = [];

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'new' => 'Baru',
            'processing' => 'Sedang Diproses',
            'completed' => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }

    public function getReportDateLabelAttribute()
    {
        return \Carbon\Carbon::parse($this->report_date)->format('d M Y');
    }
}
