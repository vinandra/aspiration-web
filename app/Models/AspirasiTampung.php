<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AspirasiTampung extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'title',
        'content',
        'kategori',
        'status',
        'photo_proof'
    ];
}