<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
  use HasFactory;

  protected $table = 'blogs';
  protected $primaryKey = 'blog_id';
  public $incrementing = true;
  protected $keyType = 'int';

  protected $fillable = [
    'slug',
    'picture',
    'detail',
    'title',
    'keywords',
    'short_description',
    'page_schema',
    'is_commentable'
  ];

  protected $casts = [
    'is_commentable' => 'boolean',
  ];

  // Auto-generate slug from title if not provided
  public static function boot()
  {
    parent::boot();

    static::creating(function ($blog) {
      if (empty($blog->slug)) {
        $blog->slug = Str::slug($blog->title);
      }
      $blog->slug = static::uniqueSlug($blog->slug);
    });

    static::updating(function ($blog) {
      if ($blog->isDirty('title') && empty($blog->slug)) {
        $blog->slug = Str::slug($blog->title);
        $blog->slug = static::uniqueSlug($blog->slug, $blog->blog_id);
      }
    });
  }

  private static function uniqueSlug($slug, $ignoreId = null)
  {
    $query = static::where('slug', $slug);
    if ($ignoreId) {
      $query->where('blog_id', '!=', $ignoreId);
    }
    $count = $query->count();
    return $count ? "{$slug}-{$count}" : $slug;
  }

  public function getPictureUrlAttribute()
  {
    return $this->picture ? asset($this->picture) : null;
  }
}
