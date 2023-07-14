<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{

    public $title;

    public $excerpt;

    public $date;

    public $body;

    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function all()
    {
        return cache()->rememberForever('posts.all', function () {
            $files = File::files(resource_path("posts/"));

            $posts = collect($files)
                ->map(function ($file) {
                    return YamlFrontMatter::parseFile($file);
                })
                ->map(function ($document) {
                    return new Post(
                        $document->matter('title'),
                        $document->matter('excerpt'),
                        $document->matter('date'),
                        $document->body(),
                        $document->matter('slug')
                    );
                })
                ->sortByDesc('title');

            return $posts;
        });
    }

    public static function find($slug)
    {
        $posts = static::all();

        $post = $posts->firstWhere('slug', $slug);

        return $post;
    }
}
