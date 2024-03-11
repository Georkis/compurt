<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $abouts = About::all();

        return Inertia::render(component: 'About/Index', props: ['abouts' => $abouts]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request): void
    {
        About::create([
            'title' => $request->get('title'),
            'content' => $request->get('content')
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, string $id): void
    {
        $about = About::find($id);
        $about->title = $request->get(key: 'title');
        $about->content = $request->get(key: 'content');
        $about->save();
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     */
    public function destroy(string $id): void
    {
        About::destroy($id);
    }

    public function getAbouts(): JsonResponse
    {
        return new JsonResponse(About::all());
    }
}
