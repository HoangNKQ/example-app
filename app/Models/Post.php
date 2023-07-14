<?php
namespace App\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class Post {

    public $title;

    public $excerpt;

    public $date;

    public $body;

    public function __construct($title, $excerpt, $date, $body) {
        $this -> title = $title;
        $this -> excerpt = $excerpt;
        $this -> date = $date;
        $this -> body = $body;
    }

    public static function all() 
    {
        $files = File::files(resource_path("posts/"));
        
        return array_map(function($file) {
            return $file->getContents();
        }, $files);
    }
    
    public static function find($slug) 
    {
        // Path to resource htmls
        // $path = __DIR__."/../resources/posts/{$slug}.html";
        $path = resource_path("posts/{$slug}.html");

        //check if file exists
        if(!file_exists($path)) {
            throw new ModelNotFoundException;
        }

        //get contents from $path and assign to $post
        $post =  cache()->remember("post.{$slug}", 5, function() use ($path) {
                var_dump("file_get_content");
                return file_get_contents($path);
        });

        // return post content
        return $post;
    }

}