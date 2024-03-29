<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $member_idd
 * @property int $milliseconds
 */
class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'milliseconds',
    ];

    /**
     * @return BelongsTo<Member,Result>
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
