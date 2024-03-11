<?php

namespace App\Http\Controllers;

use App\Models\SocialNet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SocialNetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $socialNets = SocialNet::all();

        return Inertia::render(component: 'SocialNet/Index', props: ['socialNets' => $socialNets]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, string $id): void
    {
        $socialNet = SocialNet::find($id);
        $socialNet->name = $request->get(key: 'name');
        $socialNet->url = $request->get(key: 'url');
        $socialNet->active = $request->get(key: 'active');
        $socialNet->save();
    }

    public function getSocialNets(): JsonResponse
    {
        return new JsonResponse(SocialNet::all());
    }
}
