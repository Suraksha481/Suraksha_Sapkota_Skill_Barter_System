@extends('app')

@section('content')

<section class="container">
    <h1>Request Details</h1>

    <div class="card">
        <p><strong>Requester:</strong> {{ $requestModel->requester->name ?? 'Unknown' }}</p>
        <p><strong>Responder:</strong> {{ $requestModel->responder->name ?? 'Unknown' }}</p>
        <p><strong>Skill:</strong> {{ $requestModel->userSkill->skill->title ?? '' }}</p>
        @if($requestModel->message)
            <p><strong>Message:</strong> {{ $requestModel->message }}</p>
        @endif
        <p><strong>Status:</strong> <span class="badge {{ $requestModel->status }}">{{ ucfirst($requestModel->status) }}</span></p>
        @if($requestModel->scheduled_at)
            <p><strong>Scheduled:</strong> {{ $requestModel->scheduled_at }}</p>
        @endif

        <div style="margin-top:1rem">
            @can('view', $requestModel)
                @if($requestModel->status === 'open' && auth()->id() === $requestModel->responder_id)
                    <form method="POST" action="{{ route('requests.accept', $requestModel) }}" style="display:inline">
                        @csrf
                        <button class="btn primary">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('requests.decline', $requestModel) }}" style="display:inline">
                        @csrf
                        <button class="btn ghost">Decline</button>
                    </form>
                @endif

                @if(in_array($requestModel->status, ['open','accepted']) && auth()->id() === $requestModel->requester_id)
                    <form method="POST" action="{{ route('requests.cancel', $requestModel) }}" style="display:inline">
                        @csrf
                        <button class="btn ghost">Cancel</button>
                    </form>
                @endif

                @if($requestModel->status === 'accepted' && (auth()->id() === $requestModel->responder_id || auth()->id() === $requestModel->requester_id))
                    <form method="POST" action="{{ route('requests.complete', $requestModel) }}" style="display:inline">
                        @csrf
                        <button class="btn primary">Mark Complete</button>
                    </form>
                @endif

                
            @endcan
        </div>
    </div>

</section>

@endsection
