<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $files = File::files(resource_path("posts"));
    
    $posts= [];

    foreach($files as $file) {
        $document = YamlFrontMatter::parseFile($file); 
        
        array_push($posts, new Post (
            $document -> matter('title'),
            $document -> matter('excerpt'),
            $document -> matter('date'),
            $document -> body(),
            $document -> matter('slug')
        ));
    }

    // ddd($posts[0] -> slug);
    
    return view('posts', ['posts' => $posts]);  
});

Route::get('/posts/{post}', function ($slug) {
    //find a post by its slug and pass it to a view called 'post'
    $post = Post::find($slug);
    return view('post', ['post' => $post]);
})->where('post', '[A-z_\-]+');
