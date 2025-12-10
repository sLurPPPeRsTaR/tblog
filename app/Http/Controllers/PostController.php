<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::search($request->query('q'))
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created');
    }

    public function show(Post $post)
    {
        return view('dashboard.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted');
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'csv');
        $posts = Post::with('user')->get();

        if ($format === 'csv') {
            // Build CSV manually to avoid hard dependency for static analysis
            $lines = [];
            $lines[] = ['ID', 'Title', 'Excerpt', 'Author', 'Created At'];
            foreach ($posts as $post) {
                $lines[] = [
                    $post->id,
                    $post->title,
                    $post->excerpt,
                    $post->user?->name,
                    $post->created_at->toDateTimeString(),
                ];
            }

            $fh = fopen('php://memory', 'r+');
            foreach ($lines as $row) {
                fputcsv($fh, $row);
            }
            rewind($fh);
            $csv = stream_get_contents($fh);
            fclose($fh);

            $filename = 'posts_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
            ];

            return Response::make($csv, 200, $headers);
        }

        // default to pdf
        $html = view('dashboard.posts.exports.pdf', compact('posts'))->render();

        if (class_exists('\\Dompdf\\Dompdf')) {
            $optionsClass = '\\Dompdf\\Options';
            $dompdfClass = '\\Dompdf\\Dompdf';
            $options = new $optionsClass();
            $options->set('isRemoteEnabled', true);
            $dompdf = new $dompdfClass($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return Response::make($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="posts_' . now()->format('Ymd_His') . '.pdf"',
            ]);
        }

        // Fallback: return HTML as download if Dompdf not available
        return Response::make($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="posts_' . now()->format('Ymd_His') . '.html"',
        ]);
    }

    // API endpoint to provide posts per month counts for chart
    public function postsPerMonth()
    {
        // Support both MySQL and SQLite
        $driver = config('database.default');

        if ($driver === 'sqlite') {
            $data = Post::selectRaw("strftime('%Y-%m', created_at) as month, COUNT(*) as count")
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
        } else {
            $data = Post::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
        }

        return response()->json($data);
    }
}

