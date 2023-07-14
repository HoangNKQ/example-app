<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="app.css">
    <title>Post</title>
</head>
<body>
    <?php foreach($posts as $post) : ?>
        <article>
            <h1>
                <a href="/posts/<?= $post->slug?>">
                    <?php echo $post->title; ?>   
                </a>
                 
            </h1>

            <div>
                <?php echo $post->body; ?>
            </div>
            {{-- <?php echo $post; ?> --}}
        </article>
    <?php endforeach; ?>
</body>
</html>