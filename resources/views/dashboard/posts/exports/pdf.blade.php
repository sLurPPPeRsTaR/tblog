<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Posts Export</title>
    <style>
        table { width:100%; border-collapse: collapse }
        td, th { border:1px solid #ccc; padding:6px }
    </style>
</head>
<body>
    <h1>Posts</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Excerpt</th>
                <th>Author</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->excerpt }}</td>
                    <td>{{ $post->user?->name }}</td>
                    <td>{{ $post->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

