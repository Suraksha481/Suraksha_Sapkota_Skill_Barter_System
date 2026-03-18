@extends('admin.layout')

@section('title', 'Payouts Management')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Payouts Management (50/50 Split)</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1rem; padding: 1rem; background: #d4edda; color: #155724; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #f1f1f1;">
                    <th style="padding: 12px; text-align: left;">Date</th>
                    <th style="padding: 12px; text-align: left;">Student</th>
                    <th style="padding: 12px; text-align: left;">Total Amount</th>
                    <th style="padding: 12px; text-align: left;">Admin Share (50%)</th>
                    <th style="padding: 12px; text-align: left;">Teacher Share (50%)</th>
                    <th style="padding: 12px; text-align: left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(count($transactions) > 0)
                    @foreach($transactions as $transaction)
                        <tr style="border-bottom: 1px solid #f9f9f9;">
                            <td style="padding: 12px;">{{ $transaction->created_at->format('M d, Y') }}</td>
                            <td style="padding: 12px;">{{ $transaction->student->name ?? 'Unknown Student' }}</td>
                            <td style="padding: 12px;">NPR {{ number_format($transaction->amount, 2) }}</td>
                            <td style="padding: 12px; color: #2ecc71;">NPR {{ number_format($transaction->admin_share, 2) }}</td>
                            <td style="padding: 12px; color: #3498db;">NPR {{ number_format($transaction->teacher_share, 2) }}</td>
                            <td style="padding: 12px;">
                                <span style="padding: 4px 8px; border-radius: 12px; font-size: 12px; background: #e8f5e9; color: #2e7d32; text-transform: capitalize;">
                                    {{ $transaction->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center; color: #888;">No transactions found.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div style="margin-top: 1rem;">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
