<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        "title",
        "description",
        "link"
    ];
    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany;
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tools_tags', 'tool_id', 'tag_id');
    }
}
