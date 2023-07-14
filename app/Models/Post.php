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
            });
            
        return $posts;
    }

    public static function find($slug)
    {
        // Path to resource htmls
        $path = resource_path("posts/{$slug}.html");

        //check if file exists
        if (!file_exists($path)) {
            throw new ModelNotFoundException;
        }

        //get contents from $path and assign to $post
        $post =  cache()->remember("post.{$slug}", 5, function () use ($path) {
            var_dump("file_get_content");
            return file_get_contents($path);
        });

        // return post content
        return $post;
    }
}
