@extends('layouts.admin')

@section('content')
<style>
    /* ============================================================
       PREMIUM STYLING - USERS
    ============================================================ */

    /* ---- HEADING ---- */
    .heading-premium {
        margin-bottom: 28px;
    }
    .heading-premium .eyebrow {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        color: #9b7654;
        font-weight: 700;
    }
    .heading-premium h1 {
        font-size: 30px;
        font-weight: 500;
        font-family: 'Playfair Display', serif;
        margin: 4px 0 2px;
        color: #1a1410;
    }
    .heading-premium p {
        font-size: 13px;
        color: #817a72;
        margin: 0;
    }

    /* ---- STATS ---- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 22px;
        border: 1px solid #f0edea;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(26,20,16,0.05);
        border-color: #e7e1d9;
    }

    .stat-card .stat-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
    }
    .stat-card:nth-child(1) .stat-bar { background: #9b7654; }
    .stat-card:nth-child(2) .stat-bar { background: #3b6ea5; }
    .stat-card:nth-child(3) .stat-bar { background: #817a72; }
    .stat-card:nth-child(4) .stat-bar { background: #2d7a5a; }

    .stat-card .stat-icon {
        font-size: 18px;
        color: #b3aa9e;
        float: right;
    }
    .stat-card .stat-number {
        font-size: 24px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: #1a1410;
        line-height: 1.2;
    }
    .stat-card .stat-label {
        font-size: 12px;
        color: #817a72;
        margin-top: 4px;
    }

    /* ---- FILTER ---- */
    .filter-section {
        background: #fff;
        border-radius: 14px;
        padding: 18px 24px;
        margin-bottom: 28px;
        border: 1px solid #f0edea;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .filter-section .filter-left {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-section .filter-left .search-box {
        position: relative;
    }

    .filter-section .filter-left .search-box input {
        padding: 10px 16px 10px 40px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        font-size: 13px;
        background: #faf8f5;
        width: 220px;
        outline: none;
        transition: all 0.3s;
        font-family: inherit;
        color: #1a1410;
    }

    .filter-section .filter-left .search-box input:focus {
        border-color: #9b7654;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .filter-section .filter-left .search-box input::placeholder {
        color: #b3aa9e;
    }

    .filter-section .filter-left .search-box .icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #b3aa9e;
        font-size: 14px;
    }

    .filter-section .filter-left select {
        padding: 10px 16px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        font-size: 13px;
        background: #faf8f5;
        color: #1a1410;
        outline: none;
        cursor: pointer;
        font-family: inherit;
        min-width: 140px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M6 8L1 3h10z' fill='%23817a72'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
        transition: all 0.3s;
    }

    .filter-section .filter-left select:focus {
        border-color: #9b7654;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .filter-section .filter-left .btn-reset {
        padding: 10px 18px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        background: #faf8f5;
        font-size: 13px;
        font-weight: 500;
        color: #817a72;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-section .filter-left .btn-reset:hover {
        background: #f6f3ee;
        border-color: #9b7654;
        color: #1a1410;
    }

    .filter-section .filter-right .btn-add {
        padding: 10px 24px;
        border: none;
        border-radius: 10px;
        background: #1a1410;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-section .filter-right .btn-add:hover {
        background: #3a342f;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(26,20,16,0.15);
    }

    /* ---- TABLE ---- */
    .table-wrap {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #f0edea;
        overflow: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    th {
        text-align: left;
        padding: 14px 18px;
        background: #fbf9f6;
        color: #817a72;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    td {
        padding: 14px 18px;
        border-top: 1px solid #f6f3ee;
        font-size: 13px;
        vertical-align: middle;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
        background: #f1e9df;
        color: #9b7654;
    }

    .user-name {
        font-weight: 600;
        font-size: 13px;
        color: #1a1410;
    }

    .user-email {
        font-size: 11px;
        color: #817a72;
    }

    .role-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.04em;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .role-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
        flex-shrink: 0;
    }

    .role-badge.admin {
        background: #e8edf5;
        color: #3b6ea5;
    }

    .role-badge.customer {
        background: #f0edea;
        color: #817a72;
    }

    /* ---- ACTIONS ---- */
    .actions {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .action {
        width: 32px;
        height: 32px;
        border: 1px solid #e7e1d9;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #1a1410;
        text-decoration: none;
    }

    .action:hover {
        background: #f6f3ee;
        border-color: #9b7654;
    }

    .action.danger {
        color: #a64d47;
    }

    .action.danger:hover {
        background: #f7e3e2;
        border-color: #a64d47;
    }

    .action svg {
        width: 14px;
        height: 14px;
    }

    .actions form {
        display: inline;
        margin: 0;
        padding: 0;
    }

    .footer-table {
        padding: 14px 18px;
        display: flex;
        justify-content: space-between;
        color: #817a72;
        font-size: 11px;
        border-top: 1px solid #f6f3ee;
    }

    /* ---- EMPTY ---- */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #817a72;
    }

    .empty-state .icon { font-size: 48px; color: #d4c9be; margin-bottom: 16px; }
    .empty-state h3 { font-size: 18px; font-weight: 500; color: #1a1410; margin: 0 0 4px; font-family: 'Playfair Display', serif; }
    .empty-state p { font-size: 13px; margin: 0; }

    /* ---- TOAST ---- */
    .toast{position:fixed;right:28px;bottom:28px;background:#1a1410;color:#fff;padding:14px 22px;border-radius:12px;font-size:12px;z-index:50;opacity:0;transform:translateY(16px);transition:.4s ease}
    .toast.show{opacity:1;transform:translateY(0)}

    /* ---- MODAL ---- */
    .modal-bg{position:fixed;inset:0;background:#1814117a;backdrop-filter:blur(8px);z-index:20;display:none}
    .modal-bg.show{display:block}
    .modal{position:fixed;z-index:21;left:50%;top:50%;transform:translate(-50%,-50%);width:min(600px,calc(100% - 30px));max-height:90vh;overflow:auto;background:#fff;border-radius:20px;padding:32px;display:none;box-shadow:0 40px 100px rgba(0,0,0,0.15)}
    .modal.show{display:block}
    .modal-head{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px}
    .modal h2{font:500 28px "Playfair Display";margin:0 0 4px;color:#1a1410}
    .modal-sub{font-size:12px;color:#817a72}
    .close{border:0;background:#f4f0eb;width:36px;height:36px;border-radius:50%;font-size:20px;cursor:pointer;transition:.3s;display:flex;align-items:center;justify-content:center}
    .close:hover{background:#e5ddd5}
    .form{display:grid;grid-template-columns:1fr 1fr;gap:18px}
    .field{display:flex;flex-direction:column;gap:6px}
    .field.full{grid-column:1/-1}
    .field label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#817a72}
    .field input,.field select,.field textarea{border:1px solid #e7e1d9;border-radius:10px;padding:12px 14px;background:#faf8f5;outline:0;font-size:13px;width:100%;font-family:inherit;transition:.3s}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:#9b7654;box-shadow:0 0 0 3px rgba(155,118,84,0.08)}
    .field textarea{min-height:80px;resize:vertical}
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid #f0edea}
    .secondary{border:1px solid #e7e1d9;background:#fff;padding:12px 24px;border-radius:10px;font-size:12px;font-weight:600;cursor:pointer;transition:.3s;color:#1a1410}
    .secondary:hover{background:#f6f3ee}
    .primary{border:0;background:#1a1410;color:#fff;padding:12px 28px;border-radius:10px;font-size:12px;font-weight:600;cursor:pointer;transition:.3s}
    .primary:hover{background:#3a342f}
    .checkbox-field{display:flex;align-items:center;gap:10px;padding-top:8px}
    .checkbox-field input[type="checkbox"]{width:18px;height:18px;accent-color:#9b7654}
    .checkbox-field label{font-size:12px;font-weight:600;color:#1a1410;margin:0}

    /* ---- RESPONSIVE ---- */
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .filter-section { flex-direction: column; align-items: stretch; padding: 16px; }
        .filter-section .filter-left { flex-direction: column; }
        .filter-section .filter-left .search-box input { width: 100%; }
        .filter-section .filter-left select { width: 100%; }
        .filter-section .filter-right .btn-add { width: 100%; justify-content: center; }
        .form { grid-template-columns: 1fr; }
        .modal { padding: 20px; }
        th, td { padding: 10px 12px; font-size: 12px; }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        table { min-width: 700px; }
    }
</style>

<!-- HEADING -->
<div class="heading-premium">
    <div class="eyebrow">Customer Management</div>
    <h1>Pelanggan</h1>
    <p>Kelola semua data pelanggan Anti Fashion.</p>
</div>

<!-- STATS -->
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon">♙</span>
        <div class="stat-number">{{ $users->count() }}</div>
        <div class="stat-label">Total Pelanggan</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">⚙</span>
        <div class="stat-number">{{ $users->where('is_admin', true)->count() }}</div>
        <div class="stat-label">Admin</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">♙</span>
        <div class="stat-number">{{ $users->where('is_admin', false)->count() }}</div>
        <div class="stat-label">Customer</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">◫</span>
        <div class="stat-number">{{ $users->sum(function($u) { return $u->orders->count(); }) }}</div>
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-bar"></div>
    </div>
</div>

<!-- FILTER -->
<div class="filter-section">
    <div class="filter-left">
        <div class="search-box">
            <span class="icon">⌕</span>
            <input id="search" placeholder="Cari pelanggan...">
        </div>
        <select id="roleFilter">
            <option value="">Semua Role</option>
            <option value="1">Admin</option>
            <option value="0">Customer</option>
        </select>
        <button class="btn-reset" id="resetBtn">↻ Reset</button>
    </div>
    <div class="filter-right">
        <button class="btn-add" id="addBtn">+ Tambah Pelanggan</button>
    </div>
</div>

<!-- TABLE -->
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Role</th>
                <th>Bergabung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="userTable">
            @forelse($users as $user)
            <tr data-role="{{ $user->is_admin ? '1' : '0' }}">
                <td>
                    <div class="user-cell">
                        <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                        <div>
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-email">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td style="font-size:12px;max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $user->address ?? '-' }}
                </td>
                <td>
                    <span class="role-badge {{ $user->is_admin ? 'admin' : 'customer' }}">
                        <span class="dot"></span>
                        {{ $user->is_admin ? 'Admin' : 'Customer' }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="action" title="Detail">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <button class="action editBtn"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-phone="{{ $user->phone }}"
                            data-address="{{ $user->address }}"
                            data-role="{{ $user->is_admin ? '1' : '0' }}"
                            title="Edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5Z"/></svg>
                        </button>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.toggle-admin', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="action" title="Toggle Role" onclick="return confirm('Ubah role {{ $user->name }} menjadi {{ $user->is_admin ? 'Customer' : 'Admin' }}?')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="M9 12l2 2 4-4"/></svg>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action danger" title="Hapus">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="M9 7V4.8c0-.4.4-.8.9-.8h4.2c.5 0 .9.4.9.8V7"/><path d="M6 7l1 12.5a2 2 0 0 0 2 1.9h6a2 2 0 0 0 2-1.9L18 7"/><path d="M10 11v6M14 11v6"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:44px 0;color:#999;">
                    <div style="font-size:48px;color:#d4c9be;margin-bottom:16px;">♙</div>
                    <div style="font-size:18px;font-weight:500;color:#1a1410;font-family:'Playfair Display',serif;">Belum ada pelanggan</div>
                    <div style="font-size:13px;margin:0;">Pelanggan akan muncul setelah mereka mendaftar.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer-table">
        <span id="resultText">Menampilkan {{ $users->count() }} pelanggan</span>
    </div>
</div>

<!-- MODAL -->
<div class="modal-bg" id="modalBg"></div>
<div class="modal" id="modal">
    <div class="modal-head">
        <div>
            <h2 id="modalTitle">Tambah Pelanggan</h2>
            <div class="modal-sub">Lengkapi data pelanggan.</div>
        </div>
        <button class="close" id="closeBtn">×</button>
    </div>
    <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <input type="hidden" id="editId" name="edit_id" value="">
        <div class="form">
            <div class="field full">
                <label>Nama Lengkap <span style="color:#a64d47;">*</span></label>
                <input id="userName" name="name" required placeholder="Masukkan nama lengkap">
            </div>
            <div class="field full">
                <label>Email <span style="color:#a64d47;">*</span></label>
                <input id="userEmail" name="email" type="email" required placeholder="masukkan@email.com">
            </div>
            <div class="field">
                <label>Password <span style="color:#a64d47;" id="passwordRequired">*</span></label>
                <input id="userPassword" name="password" type="password" placeholder="Minimal 8 karakter">
                <small style="font-size:10px;color:#817a72;" id="passwordHint">Kosongkan jika tidak diubah</small>
            </div>
            <div class="field">
                <label>Telepon</label>
                <input id="userPhone" name="phone" placeholder="08xxxxxxxxxx">
            </div>
            <div class="field full">
                <label>Alamat</label>
                <textarea id="userAddress" name="address" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
            </div>
            <div class="field full checkbox-field">
                <input type="checkbox" name="is_admin" id="userRole" value="1">
                <label for="userRole">Berikan akses sebagai Administrator</label>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="secondary" id="cancelBtn">Batal</button>
            <button type="submit" class="primary" id="saveBtn">Simpan Pelanggan</button>
        </div>
    </form>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
// ============================================================
// FILTER TABLE
// ============================================================
function filterTable() {
    let search = document.getElementById('search').value.toLowerCase();
    let role = document.getElementById('roleFilter').value;
    let rows = document.querySelectorAll('#userTable tr');
    let count = 0;

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        let roleText = row.dataset.role || '';

        let show = true;
        if (search && !text.includes(search)) show = false;
        if (role && roleText != role) show = false;

        if (show) {
            row.style.display = '';
            count++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('resultText').textContent = 'Menampilkan ' + count + ' pelanggan';
}

document.getElementById('search').addEventListener('keyup', filterTable);
document.getElementById('roleFilter').addEventListener('change', filterTable);
document.getElementById('resetBtn').addEventListener('click', function() {
    document.getElementById('search').value = '';
    document.getElementById('roleFilter').value = '';
    filterTable();
});

// ============================================================
// MODAL
// ============================================================
const modalBg = document.getElementById('modalBg');
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const form = document.getElementById('userForm');
const editId = document.getElementById('editId');
const passwordRequired = document.getElementById('passwordRequired');
const passwordHint = document.getElementById('passwordHint');

function openModal(title, data = null) {
    modalTitle.textContent = title;

    form.reset();
    document.getElementById('editId').value = '';
    document.getElementById('userRole').checked = false;
    document.getElementById('userPassword').removeAttribute('required');
    passwordRequired.textContent = '';
    passwordHint.textContent = 'Kosongkan jika tidak diubah';
    form.action = '{{ route("admin.users.store") }}';

    let methodInput = document.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();

    if (data) {
        editId.value = data.id;
        document.getElementById('userName').value = data.name;
        document.getElementById('userEmail').value = data.email;
        document.getElementById('userPhone').value = data.phone || '';
        document.getElementById('userAddress').value = data.address || '';
        if (data.role == '1') {
            document.getElementById('userRole').checked = true;
        }
        passwordRequired.textContent = '';
        passwordHint.textContent = 'Kosongkan jika tidak diubah';

        form.action = '{{ url("admin/users") }}/' + data.id;
        let methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        document.getElementById('userPassword').setAttribute('required', 'required');
        passwordRequired.textContent = '*';
        passwordHint.textContent = 'Minimal 8 karakter';
    }

    modalBg.classList.add('show');
    modal.classList.add('show');
}

function closeModal() {
    modalBg.classList.remove('show');
    modal.classList.remove('show');
}

document.getElementById('addBtn').addEventListener('click', function() {
    openModal('Tambah Pelanggan');
});

document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        let data = {
            id: this.dataset.id,
            name: this.dataset.name,
            email: this.dataset.email,
            phone: this.dataset.phone,
            address: this.dataset.address,
            role: this.dataset.role
        };
        openModal('Edit Pelanggan', data);
    });
});

document.getElementById('closeBtn').addEventListener('click', closeModal);
document.getElementById('cancelBtn').addEventListener('click', closeModal);
modalBg.addEventListener('click', closeModal);

function showToast(message) {
    let toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}

@if(session('success'))
    showToast('{{ session('success') }}');
@endif

@if(session('error'))
    showToast('{{ session('error') }}');
@endif
</script>
@endsection
