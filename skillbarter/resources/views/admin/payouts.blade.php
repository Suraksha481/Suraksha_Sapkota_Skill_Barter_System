@extends('admin.layout')

@section('title', 'Payouts Management')
@section('subtitle', 'Manage financial splits (50/50) and teacher payments')

@section('content')

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1rem; padding: 1rem; background: #d4edda; color: #155724; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Student</th>
                    <th>Teacher & Khalti ID</th>
                    <th>Total Amount</th>
                    <th>Admin (50%)</th>
                    <th>Teacher (50%)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if(count($transactions) > 0)
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                            <td>{{ $transaction->student->name ?? 'Unknown Student' }}</td>
                            <td>
                                <strong>{{ $transaction->teacher->name ?? 'N/A' }}</strong><br>
                                <small style="color: #64748b; font-weight:600;">ID: {{ $transaction->teacher->teacherProfile->khalti_id ?? 'NOT SET' }}</small>
                            </td>
                            <td><strong>NPR {{ number_format($transaction->amount, 2) }}</strong></td>
                            <td><span style="color: var(--primary-teal); font-weight:800;">NPR {{ number_format($transaction->admin_share, 2) }}</span></td>
                            <td><span style="color: #3b82f6; font-weight:800;">NPR {{ number_format($transaction->teacher_share, 2) }}</span></td>
                            <td>
                                @if($transaction->teacher_id && $transaction->status !== 'paid_to_teacher')
                                    <form action="{{ route('admin.payouts.pay', $transaction->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-admin btn-primary-admin">
                                            Pay Teacher
                                        </button>
                                    </form>
                                @else
                                    <span class="admin-badge badge-teal">
                                        {{ $transaction->status === 'paid_to_teacher' ? 'Paid' : 'Platform Rev' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" style="text-align: center;">No transactions found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

        <div style="margin-top: 1rem;">
            {{ $transactions->links() }}
        </div>
    </div>
    </div>
@endsection
