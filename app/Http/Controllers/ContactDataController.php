<?php

namespace App\Http\Controllers;

use App\Models\ContactData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class ContactDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactDatas = ContactData::all();
        //todo
        return Inertia::render(component: 'ContactData/Index', props: compact(var_name: 'contactDatas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        $contactData = ContactData::find($id);

        $contactData->email = $request->email;
        $contactData->address = $request->address;
        $contactData->phone = $request->phone;
        $contactData->save();
    }

    public function getContactData(): JsonResponse
    {
        return new JsonResponse(ContactData::find(1));
    }
}
