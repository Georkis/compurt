<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $services = Service::all();
        return Inertia::render(component: 'Service/Index', props: [
            'services' => $services,
            'url_service' => env('APP_URL_STORAGE').$this->getPath()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request): void
    {
        //todo save image and route store image
        $filename = $request->image->hashName();
        Storage::disk(name: 'public')->putFileAs(path: $this->getPath(), file: $request->file(key: 'image'), name: $filename);

        $service = new Service(attributes: [
            "title" => $request->request->get('title'),
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
            'title' => 'required: true| max:30',
            'content' => 'required: true| max:120'
        ]);

        $service = Service::find($id);

        if($request->image) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=212,height=214',
            ]);
            $filename = $request->image->hashName();
            Storage::disk(name: 'public')->delete(paths :$this->getPath().$service->image);
            Storage::disk(name: 'public')->putFileAs(path: $this->getPath(), file: $request->file(key: 'image'), name: $filename);
            $service->image = $filename;
        }

        $service->title = $request->get(key: 'title');
        $service->content = $request->get(key: 'content');

        $service->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        Storage::disk(name: 'public')->delete(paths: $this->getPath().$service->image);
        $service->delete();
    }

    private function getPath(): string
    {
        return 'img/services/';
    }

    public function getServices(): JsonResponse
    {
        return new JsonResponse(Service::all());
    }
}
