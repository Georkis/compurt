<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Ramsey\Uuid\Uuid;
use function Illuminate\Support\Facades\Request;
use function Illuminate\Support\Facades\Response;

class SubscriberController extends Controller
{
    public function index(): Response
    {
        //todo
        return Inertia::render(component: '', props: []);
    }

    /**
     * @param SubscriberRequest $request
     * @return void
     * @Description Just Use in api
     */
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->content, true);
        $dateExpire = new \DateTime('now');
        Subscriber::create([
            'email' => $data['email'],
            'token' => Uuid::uuid4(),
            'dateExpire' => $dateExpire->modify('1 day'),
            'confirm' => false
        ]);

        return new JsonResponse([
            'message => Se ha enviado un email para validar la subscripción'
        ]);


    }

    /**
     * @param SubscriberRequest $request
     * @param string $id
     * @return void
     * @Description Just Use in api and change subscribe
     */
    public function update(SubscriberRequest $request, string $id): void
    {
        //todo
        Subscriber::update($request->all());
    }

    public function validEmail(string $token): void
    {
        //todo
    }

    public function sendMessageSubscriber(): view
    {
        //todo dev use Queue
        return view();
    }
}
