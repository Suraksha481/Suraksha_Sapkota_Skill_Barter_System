@extends('admin.layout')

@section('title','Platform Overview')
@section('subtitle', 'Quick statistics and system health at a glance')

@section('content')

{{-- ── STAT CARDS GRID ── --}}
<div class="dash-grid">

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-users">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Total Users</span>
            <span class="stat-number">{{ number_format($totalUsers) }}</span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-teacher">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Teachers</span>
            <span class="stat-number">{{ number_format($totalTeachers) }}</span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-student">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 6.5v2.694l-3-.985v1.525c0 .73-.317 1.343-.63 1.785a4.3 4.3 0 0 1-.71.714 2.5 2.5 0 0 1-.31.209l-.019.01-.004.002h-.002a.5.5 0 0 0 .466.885h.002l.019-.01.063-.033a3.5 3.5 0 0 0 .43-.28 5.3 5.3 0 0 0 .88-.887C11.566 11.157 12 10.329 12 9.219V6.331l2-.656v4.325a.5.5 0 0 0 0 .5V13.5a.5.5 0 1 0 1 0v-2.843a.5.5 0 0 0 0-.5V5.197l.795-.330a.5.5 0 0 0 .025-.917z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Students</span>
            <span class="stat-number">{{ number_format($totalStudents) }}</span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-sessions">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M1 2.5A2.5 2.5 0 0 1 3.5 0h8.999a2.5 2.5 0 0 1 2.5 2.5v10.999a2.5 2.5 0 0 1-2.5 2.5H3.5a2.5 2.5 0 0 1-2.5-2.5zm4.5 11h5v-1h-5zm-2-1h1v1H3.5a1.5 1.5 0 0 1-1.5-1.5V10h2zm9 0v1H11v-1l2.5-.001zM13 9h2v2h-2zm0-4h2v3h-2zm0-2.5V4h2v.5a.5.5 0 0 1-.5.5H13zm-1-2H4v9h8zM3.5 1A1.5 1.5 0 0 0 2 2.5V4h2V1zM2 8h2v2H2zm0-3h2v2H2z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Sessions</span>
            <span class="stat-number">{{ number_format($totalSessions) }}</span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-skills">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Skills</span>
            <span class="stat-number">{{ number_format($totalSkills) }}</span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-requests">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 2a5 5 0 1 0 0 10A5 5 0 0 0 8 2M3.732 6.055a.5.5 0 0 0-.707.707L5.5 9.243l2.475-2.475a.5.5 0 0 0-.707-.707L5.5 7.829 3.732 6.061z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Requests</span>
            <span class="stat-number">{{ number_format($totalRequests) }}</span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-premium">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Premium Members</span>
            <span class="stat-number">{{ number_format($totalPremium) }}</span>
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="stat-icon-wrap icon-feedback">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a21 21 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-label">Feedbacks</span>
            <span class="stat-number">{{ number_format($totalFeedbacks) }}</span>
        </div>
    </div>

</div>

{{-- ── REVENUE SECTION ── --}}
<div class="revenue-section">
    <h2 class="section-heading">Revenue Overview</h2>
    <div class="revenue-grid">

        <div class="revenue-card card-total">
            <div class="rev-label">Total Platform Revenue</div>
            <div class="rev-amount">NPR {{ number_format($totalRevenue, 2) }}</div>
            <div class="rev-sub">All transactions combined</div>
        </div>

        <div class="revenue-card card-admin">
            <div class="rev-label">Admin Earnings (50%)</div>
            <div class="rev-amount">NPR {{ number_format($adminShare, 2) }}</div>
            <div class="rev-sub">Platform cut from sessions</div>
        </div>

        <div class="revenue-card card-teacher">
            <div class="rev-label">Teacher Payouts (50%)</div>
            <div class="rev-amount">NPR {{ number_format($teacherShare, 2) }}</div>
            <div class="rev-sub">Distributed to teachers</div>
        </div>

    </div>
</div>

{{-- ── QUICK LINKS ── --}}
<div class="quick-links-section">
    <h2 class="section-heading">Quick Actions</h2>
    <div class="quick-links-grid">
        <a href="{{ route('admin.users') }}" class="quick-link-card">
            <span class="ql-icon">👥</span>
            <span class="ql-label">Manage Users</span>
        </a>
        <a href="{{ route('admin.teachers.pending') }}" class="quick-link-card">
            <span class="ql-icon">✅</span>
            <span class="ql-label">Pending Teachers</span>
        </a>
        <a href="{{ route('admin.payouts') }}" class="quick-link-card">
            <span class="ql-icon">💰</span>
            <span class="ql-label">Payouts</span>
        </a>
        <a href="{{ route('admin.disputes') }}" class="quick-link-card">
            <span class="ql-icon">⚖️</span>
            <span class="ql-label">Disputes</span>
        </a>
        <a href="{{ route('admin.feedbacks') }}" class="quick-link-card">
            <span class="ql-icon">💬</span>
            <span class="ql-label">Feedbacks</span>
        </a>
        <a href="{{ route('admin.skills') }}" class="quick-link-card">
            <span class="ql-icon">📚</span>
            <span class="ql-label">Skills</span>
        </a>
    </div>
</div>

<style>
/* ── STAT CARDS ─────────────────────────────────────────── */
.dash-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2.5rem;
}

.dash-stat-card {
    background: #fff;
    border: 1.5px solid var(--primary-teal-light);
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    transition: box-shadow 0.25s;
}

.dash-stat-card:hover {
    box-shadow: 0 8px 30px rgba(32,166,138,0.1);
}

.stat-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.icon-users    { background: #e0f5ef; color: var(--primary-teal); }
.icon-teacher  { background: #e0f0ff; color: #3b82f6; }
.icon-student  { background: #fef3c7; color: #d97706; }
.icon-sessions { background: #f0e7ff; color: #7c3aed; }
.icon-skills   { background: #fce7f3; color: #db2777; }
.icon-requests { background: #dcfce7; color: #16a34a; }
.icon-premium  { background: #fef9c3; color: #ca8a04; }
.icon-feedback { background: #fee2e2; color: #dc2626; }

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.stat-label {
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
}

.stat-number {
    font-size: 2rem;
    font-weight: 900;
    color: var(--text-slate);
    letter-spacing: -1px;
    line-height: 1;
}

/* ── REVENUE ────────────────────────────────────────────── */
.revenue-section { margin-bottom: 2.5rem; }

.section-heading {
    font-size: 1.25rem;
    font-weight: 900;
    color: var(--text-slate);
    margin: 0 0 1.25rem 0;
    letter-spacing: -0.5px;
}

.revenue-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.revenue-card {
    border-radius: 18px;
    padding: 2rem;
    color: #fff;
}

.card-total   { background: linear-gradient(135deg, #20a68a, #0e7a63); }
.card-admin   { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.card-teacher { background: linear-gradient(135deg, #f59e0b, #b45309); }

.rev-label  { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85; margin-bottom: 0.5rem; }
.rev-amount { font-size: 1.85rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 0.4rem; }
.rev-sub    { font-size: 0.8rem; opacity: 0.75; }

/* ── QUICK LINKS ────────────────────────────────────────── */
.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1rem;
}

.quick-link-card {
    background: #fff;
    border: 1.5px solid var(--primary-teal-light);
    border-radius: 16px;
    padding: 1.5rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    transition: box-shadow 0.25s, border-color 0.25s;
}

.quick-link-card:hover {
    box-shadow: 0 6px 20px rgba(32,166,138,0.12);
    border-color: var(--primary-teal);
}

.ql-icon  { font-size: 1.8rem; }
.ql-label { font-size: 0.82rem; font-weight: 700; color: var(--text-slate); text-align: center; }

/* ── RESPONSIVE ─────────────────────────────────────────── */
@media (max-width: 1200px) { .dash-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 900px)  { .revenue-grid { grid-template-columns: 1fr; } .quick-links-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 600px)  { .dash-grid { grid-template-columns: 1fr; } .quick-links-grid { grid-template-columns: repeat(2, 1fr); } }
</style>

@endsection
