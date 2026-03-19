@extends('app')

@section('content')

<section class="container">
    <h1>Request Details</h1>

    <div class="card" style="background: #fff; padding: 2.5rem; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
        <div style="display: grid; gap: 0.75rem; margin-bottom: 2rem;">
            <p style="margin: 0;"><strong>Requester:</strong> {{ $requestModel->requester->name ?? 'Unknown' }}</p>
            <p style="margin: 0;"><strong>Responder:</strong> {{ $requestModel->responder->name ?? 'Unknown' }}</p>
            <p style="margin: 0;"><strong>Skill:</strong> <span style="color: #000; font-weight: 700;">{{ $requestModel->userSkill->skill->title ?? '' }}</span></p>
            @if($requestModel->message)
                <p style="line-height: 1.6;"><strong>Message:</strong> {{ $requestModel->message }}</p>
            @endif
            <p style="margin: 0;"><strong>Status:</strong> 
                <span class="badge {{ $requestModel->status }}" style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">{{ ucfirst($requestModel->status) }}</span>
            </p>
            @if($requestModel->scheduled_at)
                <p style="margin: 0;"><strong>Scheduled:</strong> {{ $requestModel->scheduled_at }}</p>
            @endif
        </div>

        <div style="margin-top: 2rem; padding: 1.5rem; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px;">
            <p style="margin-bottom: 0.5rem;"><strong>{{ $requestModel->userSkill->type === 'offer' ? 'Offer Type:' : 'Request Type:' }}</strong> 
               <span style="color: #000; font-weight: 800; text-transform: uppercase; font-size: 0.9rem;">
                   {{ $requestModel->userSkill->type === 'offer' ? 'Teaching Offer' : 'Learning Request' }}
               </span>
            </p>
            <p style="margin: 0; color: #666; font-size: 0.95rem; line-height: 1.5;">
                @if($requestModel->userSkill->type === 'offer')
                    {{ $requestModel->responder_id === auth()->id() ? 'You offered to teach this skill.' : $requestModel->responder->name . ' offered to teach you this skill.' }}
                @else
                    {{ $requestModel->requester_id === auth()->id() ? 'You requested to learn this skill.' : $requestModel->requester->name . ' requested to learn a skill from you.' }}
                @endif
            </p>
        </div>

        <div style="margin-top:2.5rem; display: flex; gap: 1rem; justify-content: flex-start;">
            @can('view', $requestModel)
                @if($requestModel->status === 'open' && auth()->id() === $requestModel->responder_id)
                    <form method="POST" action="{{ route('requests.accept', $requestModel) }}">
                        @csrf
                        <button class="btn primary" style="background: #000; color: #fff; border: 1px solid #000; padding: 12px 25px; cursor: pointer; font-weight: 700;">Accept {{ $requestModel->userSkill->type === 'offer' ? 'Offer' : 'Request' }}</button>
                    </form>
                    <form method="POST" action="{{ route('requests.decline', $requestModel) }}">
                        @csrf
                        <button class="btn ghost" style="background: #fff; color: #000; border: 1px solid #000; padding: 12px 25px; cursor: pointer; font-weight: 700;">Decline</button>
                    </form>
                @endif

                @if(in_array($requestModel->status, ['open','accepted']) && auth()->id() === $requestModel->requester_id)
                    <form method="POST" action="{{ route('requests.cancel', $requestModel) }}">
                        @csrf
                        <button class="btn ghost" style="background: #fff; color: #000; border: 1px solid #000; padding: 12px 25px; cursor: pointer; font-weight: 700;">Cancel Request</button>
                    </form>
                @endif

                @if($requestModel->status === 'accepted' && (auth()->id() === $requestModel->responder_id || auth()->id() === $requestModel->requester_id))
                    <form method="POST" action="{{ route('requests.complete', $requestModel) }}">
                        @csrf
                        <button class="btn primary" style="background: #000; color: #fff; border: 1px solid #000; padding: 12px 25px; cursor: pointer; font-weight: 700;">Mark Complete</button>
                    </form>
                @endif
            @endcan
        </div>
    </div>

</section>

@endsection
