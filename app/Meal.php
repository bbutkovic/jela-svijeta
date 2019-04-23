<?php

namespace App;

use \App\Traits\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Meal extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $appends = ['status'];

    protected $statusAfter;

    public $translatedAttributes = ['title'];

    public function category() {
        return $this->belongsTo('App\\Category');
    }

    public function tags() {
        return $this->belongsToMany('App\\Tag');
    }

    public function ingredients() {
        return $this->belongsToMany('App\\Ingredient');
    }

    public function scopeTouchedAfter($query, Carbon $time) {
        return $query->where(function($query) use($time) {
            $query->where('created_at', '>', $time)
                ->orWhere('deleted_at', '>', $time)
                ->orwhere('updated_at', '>', $time);
        });
    }

    public function scopeByCategory($query, $category) {
        switch($category) {
            case '!NULL':
                $query->whereNotNull('category_id');
                break;
            case 'NULL':
                $query->whereNull('category_id');
                break;
            default:
                $query->where('category_id', $category);
        }
        return $query;
    }

    public function scopeByTags($query, $tags) {
        $query->whereHas('tags', function($q) use($tags) {
            $q->whereIn('tags.id', $tags)
                ->havingRaw('count(distinct tags.id) = ?', [count($tags)]);
        }, '=', count($tags));
        return $query;

        // $tags = $request->input('tags');
        // $mq->whereHas('tags', function($q) use($tags) {
        //     $q->whereIn('tags.id', $tags)
        //         ->havingRaw('count(distinct tags.id) = ?', [count($tags)]);
        // }, '=', count($tags));
    }

    public function setStatusAfter(Carbon $time) {
        $this->statusAfter = $time;
    }

    public function getStatusAttribute() {
        if(!$this->statusAfter || ($this->created_at->gt($this->statusAfter))) {
            return 'created';
        } else if($this->updated_at->gt($this->statusAfter)) {
            return 'updated';
        }
        return 'deleted';
    }
}
