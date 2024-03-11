<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Http\Requests\TestimonialRequest;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $testimonials = Testimonial::all();
        return Inertia::render(component: 'Testimonial/Index', props: [
            'testimonials' => $testimonials,
            'url_testimonial' => env('APP_URL_STORAGE').$this->getPath()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request): void
    {
        $filename = $request->image->hashName();
        Storage::disk(name: 'public')->putFileAs(path: $this->getPath(), file: $request->file(key: 'image'), name: $filename);

        $service = new Testimonial(attributes: [
            "name" => $request->request->get('name'),
            "occupation" => $request->request->get('occupation'),
            "content" => $request->request->get('content'),
            "image" => $filename
        ]);
        $service->save();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        $request->validate([
            'name' => 'required: true| max:30',
            'occupation' => 'required: true| max:30',
            'content' => 'required: true| max:200'
        ]);
        $testimonial = Testimonial::find($id);

        if($request->image) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=212,height=214|required: true',
            ]);

            $filename = $request->image->hashName();
            Storage::disk(name: 'public')->delete(paths :$this->getPath().$testimonial->image);
            Storage::disk(name: 'public')->putFileAs(path: $this->getPath(), file: $request->file(key: 'image'), name: $filename);
            $testimonial->image = $filename;
        }

        $testimonial->name = $request->get(key: 'name');
        $testimonial->content = $request->get(key: 'content');

        $testimonial->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial = Testimonial::find($id);
        Storage::disk(name: 'public')->delete(paths: $this->getPath().$testimonial->image);
        $testimonial->delete();
    }

    private function getPath(): string
    {
        return 'img/testimonial/';
    }

    //APi Rest
    public function getTestimonials(): JsonResponse
    {
        return new JsonResponse(Testimonial::all());
    }
}
