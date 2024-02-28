<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;
use Inertia\Inertia;
use Inertia\Response;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $sliders = Slider::all();
        return inertia(component: 'Slider/Index', props: ['sliders' => $sliders, 'url_slider' => env('APP_URL_STORAGE').'img/sliders/']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //todo dev upload image
        $filename = $request->image->hashName();
        Storage::disk(name: 'public')->putFileAs(path: $this->getPath(), file: $request->file(key: 'image'), name: $filename);

        $slider = new Slider(attributes: [
            "title" => $request->request->get('title'),
            "content" => $request->request->get('content'),
            "image" => $filename
        ]);
        $slider->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        $slider = Slider::find($id);
        if($request->image) {
            $filename = $request->image->hashName();
            Storage::disk(name: 'public')->delete(paths :$this->getPath().$slider->image);
            Storage::disk(name: 'public')->putFileAs(path: $this->getPath(), file: $request->file(key: 'image'), name: $filename);
            $slider->image = $filename;
        }

        $slider->title = $request->request->get(key: 'title');
        $slider->content = $request->request->get(key: 'content');

        $slider->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        $slider = Slider::find($id);
        Storage::disk(name: 'public')->delete(paths: $this->getPath().$slider->image);
        $slider->delete();
    }

    /**
     * @param string $image
     * @return string
     */
    private function getPath(): string
    {
        return 'img/sliders/';
    }
}
