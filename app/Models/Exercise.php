<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_db_id',
        'name',
        'body_part',
        'equipment',
        'target',
        'gif_url',
        'secondary_muscles',
        'instructions',
    ];

    protected $casts = [
        'secondary_muscles' => 'array',
        'instructions' => 'array',
    ];

    /**
     * Get exercises by equipment
     */
    public static function getByEquipment(string $equipment, int $limit = 100)
    {
        return self::where('equipment', $equipment)
            ->limit($limit)
            ->get();
    }

    /**
     * Get exercises by body part
     */
    public static function getByBodyPart(string $bodyPart, int $limit = 100)
    {
        return self::where('body_part', $bodyPart)
            ->limit($limit)
            ->get();
    }

    /**
     * Get exercises by target muscle
     */
    public static function getByTarget(string $target, int $limit = 100)
    {
        return self::where('target', $target)
            ->limit($limit)
            ->get();
    }

    /**
     * Filter exercises by multiple criteria
     */
    public static function filter(array $criteria)
    {
        $query = self::query();

        if (isset($criteria['equipment'])) {
            if (is_array($criteria['equipment'])) {
                $query->whereIn('equipment', $criteria['equipment']);
            } else {
                $query->where('equipment', $criteria['equipment']);
            }
        }

        if (isset($criteria['body_part'])) {
            if (is_array($criteria['body_part'])) {
                $query->whereIn('body_part', $criteria['body_part']);
            } else {
                $query->where('body_part', $criteria['body_part']);
            }
        }

        if (isset($criteria['target'])) {
            if (is_array($criteria['target'])) {
                $query->whereIn('target', $criteria['target']);
            } else {
                $query->where('target', $criteria['target']);
            }
        }

        return $query->get();
    }
}
