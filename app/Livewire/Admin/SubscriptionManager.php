<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionManager extends Component
{
    public $subscriptions;
    public $selectedId;
    public $userId, $plan, $status = 'active', $startDate, $endDate;

    protected $rules = [
        'userId' => 'required|exists:users,id',
        'plan' => 'required|string',
        'status' => 'required|in:active,cancelled,pending',
        'startDate' => 'required|date',
        'endDate' => 'nullable|date|after_or_equal:startDate',
    ];

    public function mount()
    {
        $this->loadSubscriptions();
    }

    public function loadSubscriptions()
    {
        // Load all subscriptions with user details
        $this->subscriptions = Subscription::with('user')->get();
    }

    public function resetFields()
    {
        $this->selectedId = null;
        $this->userId = '';
        $this->plan = '';
        $this->status = 'active';
        $this->startDate = '';
        $this->endDate = '';
    }

    public function edit($id)
    {
        $sub = Subscription::findOrFail($id);
        $this->selectedId = $id;
        $this->userId = $sub->user_id;
        $this->plan = $sub->plan;
        $this->status = $sub->status;
        $this->startDate = optional($sub->start_date)->format('Y-m-d');
        $this->endDate = optional($sub->end_date)->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        Subscription::updateOrCreate(
            ['id' => $this->selectedId],
            [
                'user_id' => $this->userId,
                'plan' => $this->plan,
                'status' => $this->status,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]
        );

        session()->flash('message', $this->selectedId ? 'Subscription Updated' : 'Subscription Created');

        $this->resetFields();
        $this->loadSubscriptions();
    }

    public function delete($id)
    {
        Subscription::findOrFail($id)->delete();
        session()->flash('message', 'Subscription Deleted');
        $this->loadSubscriptions();
    }

    public function render()
    {
        $users = User::all(); // for select dropdown in Add/Edit form
        return view('livewire.admin.subscription-manager', [
            'users' => $users
        ]);
    }
}
