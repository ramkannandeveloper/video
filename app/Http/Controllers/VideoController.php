<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::orderByDesc('created_at')->get();
        return view('formlist', ['videos' => $videos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimes:mp4,avi,wmv|max:102400',
            'content' => 'nullable|string',
        ]);

        $videoPath = $request->file('video')->store('uploads/videos', ['disk' => 'my_files']);

        // Generate screenshot
        $screenshotPath = 'uploads/videos/' . basename($videoPath) . '.jpg';
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoPath);
        $screenshotTime = 5;
        $video->frame(TimeCode::fromSeconds($screenshotTime))->save(public_path($screenshotPath));

        $data = [
            'title' => $request->title,
            'video_path' => $videoPath,
            'screenshot' => $screenshotPath,
            'content' => $request->content
        ];

        $user = Video::create($data);

        return redirect()->route('videos.index')->with('success', 'Video created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return view('formshow', ['video' => $video]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::find($id);
        return view('formedit', ['video' => $video]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'file|mimes:mp4,avi,wmv|max:102400',
            'content' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content
        ];

        if ($request->hasFile('video') && $request->file('video')->isValid()) {
            $videoPath = $request->file('video')->store('uploads/videos', ['disk' => 'my_files']);
            $data['video_path'] = $videoPath;

            // Generate screenshot
            $screenshotPath = 'uploads/videos/' . basename($videoPath) . '.jpg';
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($videoPath);
            $screenshotTime = 5;
            $video->frame(TimeCode::fromSeconds($screenshotTime))->save(public_path($screenshotPath));

            $data['screenshot'] = $screenshotPath;
        }

        $video = Video::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Video updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::find($id);
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video deleted successfully');
    }
}
