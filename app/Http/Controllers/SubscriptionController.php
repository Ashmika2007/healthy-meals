<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
   public function subscriptions()
{
    $user = auth()->user();

    // Get user's subscriptions
    $subscriptions = Subscription::where('user_id', $user->id)->latest()->get();

    // Define plans as key => display name
    $plans = [
        'Basic' => ['name' => 'Basic Plan', 'price' => 500],
        'Premium' => ['name' => 'Premium Plan', 'price' => 1000],
        'Pro' => ['name' => 'Pro Plan', 'price' => 1500],
    ];

    // Make sure the view path matches your folder
    return view('user.subscriptions.index', compact('subscriptions', 'plans'));
}


    // Show payment page for selected plan
  public function showPaymentPage($plan)
{
    $plans = $this->plans();

    if (!isset($plans[$plan])) {
        abort(404);  // Not Found if plan invalid
    }

    $planDetails = $plans[$plan];

    return view('user.subscriptions.payment', [
        'plan' => $planDetails,
        'planKey' => $plan
    ]);
}

    // Process payment & create subscription
   public function processPayment(Request $request, $plan)
{
    $plans = $this->plans();

    if (!isset($plans[$plan])) {
        abort(404);
    }

    $planDetails = $plans[$plan];

    // Create subscription record
    auth()->user()->subscriptions()->create([
        'plan' => $plan,
        'status' => 'active',
        'start_date' => now(),
        'end_date' => now()->addMonth(), // adjust duration per plan
    ]);

    return redirect()->route('subscriptions.index')->with('success','Subscribed to '.$planDetails['name']);
}

    // Define available plans
 private function plans()
    {
        return [
            'Basic' => ['name' => 'Basic Plan', 'price' => 500],
            'Premium' => ['name' => 'Premium Plan', 'price' => 1000],
            'Pro' => ['name' => 'Pro Plan', 'price' => 1500],
        ];

}
}