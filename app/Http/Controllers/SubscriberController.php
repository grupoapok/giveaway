<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriberRequest;
use App\Http\Resources\SubscriberResource;
use App\Subscriber;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriberController extends Controller {
    use ProcessTokenTrait;

    public function index(Request $request) {
        $user = $this->getUser($request);
        return new SubscriberResource($user->load("tickets"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    public function store(CreateSubscriberRequest $request) {
        $existingUser = Subscriber::where("email", $request->input("email"))->first();
        if (is_null($existingUser)) {
            $ipinfo = $request->ipinfo;

            $newSubscriber = Subscriber::make($request->all());
            $newSubscriber->city = $ipinfo->city;
            $newSubscriber->country = $ipinfo->country_name;
            $newSubscriber->region = $ipinfo->region;
            $newSubscriber->ipinfo = json_encode($ipinfo);
            $newSubscriber->token = Str::uuid();
            $newSubscriber->save();

            Ticket::create(["subscriber_id" => $newSubscriber->id]);

            return new SubscriberResource($newSubscriber->load("tickets"));
        } else {
            return new SubscriberResource($existingUser);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber) {
        //
    }
}
