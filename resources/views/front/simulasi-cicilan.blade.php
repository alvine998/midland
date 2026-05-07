@extends('layouts.public')

@section('title', 'Simulasi Cicilan KPR')
@section('meta_description', 'Hitung estimasi cicilan KPR properti Anda secara mudah. Masukkan data diri dan detail simulasi untuk melihat skema cicilan lengkap.')

@push('styles')
<style>
    .sim-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    }
    .sim-card .card-header {
        background: var(--primary);
        color: #fff;
        border-radius: 12px 12px 0 0;
        padding: 1.25rem 1.5rem;
    }
    .sim-card .card-header h5 {
        font-family: 'Playfair Display', serif;
        margin-bottom: 0;
    }
    .result-card {
        background: linear-gradient(135deg, var(--primary) 0%, #0d3321 100%);
        color: #fff;
        border-radius: 12px;
        padding: 2rem;
    }
    .result-card .result-label {
        font-size: 0.8rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.7);
        margin-bottom: 0.25rem;
    }
    .result-card .result-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--gold);
    }
    .result-card .result-value.main {
        font-size: 2.2rem;
    }
    .amortization-table th {
        background: var(--primary);
        color: #fff;
        font-weight: 600;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .amortization-table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }
    .amortization-table tr:hover td { background: var(--light-bg); }
    .step-badge {
        width: 32px;
        height: 32px;
        background: var(--gold);
        color: var(--primary);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    #resultSection { display: none; }
    .progress-bar-cicilan { background: var(--gold); }
    .tooltip-icon { cursor: pointer; color: var(--gray); font-size: 0.85rem; }
    /* Recommended property cards */
    .rec-card { border: none; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 16px rgba(0,0,0,.08); transition: all .3s; }
    .rec-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,0,0,.14); }
    .rec-card .rec-img { width: 100%; height: 160px; object-fit: cover; }
    .rec-card .rec-img-placeholder { width: 100%; height: 160px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.25); font-size:3rem; }
    .rec-card .rec-price { font-family: 'Playfair Display', serif; color: var(--gold); font-size: 1.1rem; font-weight: 700; }
    .rec-card .rec-title { color: var(--primary); font-weight: 600; font-size: .95rem; }
    .rec-match-badge { font-size: .72rem; letter-spacing: .5px; text-transform: uppercase; }
</style>
@endpush

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="mb-2"><i class="bi bi-calculator me-2"></i>Simulasi Cicilan KPR</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Simulasi Cicilan</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5 bg-light-custom">
    <div class="container">

        <!-- Info Banner -->
        <div class="alert border-0 shadow-sm mb-4 d-flex align-items-start gap-3" style="background:#fff; border-left: 4px solid var(--gold) !important; border-radius: 8px;">
            <i class="bi bi-info-circle-fill text-gold fs-4 mt-1 flex-shrink-0"></i>
            <div>
                <strong class="d-block mb-1" style="color:var(--primary)">Cara Menggunakan Simulasi Cicilan</strong>
                <span class="text-muted" style="font-size:.9rem">
                    Isi data diri Anda, lalu masukkan detail properti yang ingin diambil. Klik tombol <strong>Hitung Simulasi</strong> untuk melihat skema cicilan lengkap.
                    Simulasi ini bersifat estimasi — angka aktual dapat berbeda tergantung kebijakan bank.
                </span>
            </div>
        </div>

        <div class="row g-4">

            <!-- ── FORM ── -->
            <div class="col-lg-5">

                <!-- Step 1: Data Diri -->
                <div class="sim-card card mb-4">
                    <div class="card-header">
                        <h5><span class="step-badge me-2">1</span> Data Diri</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="inputNama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                            <div class="invalid-feedback">Nama wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="tel" id="inputPhone" class="form-control" placeholder="08xx-xxxx-xxxx" required>
                            </div>
                            <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="inputEmail" class="form-control" placeholder="nama@email.com" required>
                            </div>
                            <div class="invalid-feedback">Email yang valid wajib diisi.</div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Detail Simulasi -->
                <div class="sim-card card">
                    <div class="card-header">
                        <h5><span class="step-badge me-2">2</span> Detail Simulasi</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Harga Properti (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="inputHarga" class="form-control" placeholder="500.000.000" required>
                            </div>
                            <div id="hargaDisplay" class="form-text text-muted mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-flex justify-content-between">
                                <span>Uang Muka / DP <span class="text-danger">*</span></span>
                                <span id="dpPercent" class="text-gold fw-bold">30%</span>
                            </label>
                            <input type="range" id="inputDPRange" class="form-range mb-2" min="10" max="90" step="5" value="30">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="inputDP" class="form-control" placeholder="150.000.000">
                            </div>
                            <div id="dpDisplay" class="form-text text-muted mt-1"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold d-flex justify-content-between">
                                <span>Tenor / Jangka Waktu <span class="text-danger">*</span></span>
                                <span id="tenorDisplay" class="text-gold fw-bold">15 Tahun</span>
                            </label>
                            <input type="range" id="inputTenorRange" class="form-range mb-2" min="1" max="30" step="1" value="15">
                            <div class="d-flex justify-content-between" style="font-size:.75rem;color:var(--gray)">
                                <span>1 tahun</span><span>30 tahun</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex justify-content-between">
                                <span>
                                    Suku Bunga / Tahun <span class="text-danger">*</span>
                                    <i class="bi bi-question-circle tooltip-icon ms-1"
                                       data-bs-toggle="tooltip"
                                       title="Suku bunga rata-rata KPR di Indonesia saat ini berkisar 7–12% per tahun."></i>
                                </span>
                                <span id="bungaDisplay" class="text-gold fw-bold">9%</span>
                            </label>
                            <input type="range" id="inputBungaRange" class="form-range mb-2" min="1" max="20" step="0.5" value="9">
                            <div class="d-flex justify-content-between" style="font-size:.75rem;color:var(--gray)">
                                <span>1%</span><span>20%</span>
                            </div>
                        </div>

                        <button id="btnHitung" class="btn btn-gold w-100 py-3 fs-5">
                            <i class="bi bi-calculator me-2"></i>Hitung Simulasi
                        </button>
                    </div>
                </div>

            </div>

            <!-- ── RESULT ── -->
            <div class="col-lg-7">
                <!-- Placeholder -->
                <div id="placeholderSection" class="text-center py-5">
                    <i class="bi bi-house-heart" style="font-size:5rem;color:var(--primary);opacity:.15"></i>
                    <p class="mt-3 text-muted">Isi form di sebelah kiri, lalu klik <strong>Hitung Simulasi</strong><br>untuk melihat skema cicilan Anda.</p>
                </div>

                <!-- Result -->
                <div id="resultSection">

                    <!-- Greeting -->
                    <div class="alert border-0 mb-4" style="background:#fff;border-left:4px solid var(--gold) !important;border-radius:8px;box-shadow:0 2px 12px rgba(0,0,0,.06)">
                        <strong id="resultGreeting" class="d-block" style="color:var(--primary);font-size:1.05rem"></strong>
                        <small class="text-muted">Berikut adalah estimasi skema cicilan KPR Anda.</small>
                    </div>

                    <!-- Summary Cards -->
                    <div class="result-card mb-4">
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <div class="result-label">Cicilan per Bulan (estimasi)</div>
                                <div class="result-value main" id="rCicilanBulan">—</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="result-label">Harga Properti</div>
                                <div class="result-value" id="rHarga">—</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="result-label">Uang Muka (DP)</div>
                                <div class="result-value" id="rDP">—</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="result-label">Pinjaman Pokok</div>
                                <div class="result-value" id="rPokok">—</div>
                            </div>
                        </div>
                        <hr style="border-color:rgba(255,255,255,.15);margin:1.25rem 0">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="result-label">Tenor</div>
                                <div class="result-value" id="rTenor">—</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="result-label">Suku Bunga</div>
                                <div class="result-value" id="rBunga">—</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="result-label">Total Pembayaran</div>
                                <div class="result-value" id="rTotal">—</div>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Properties -->
                    <div class="sim-card card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-house-heart me-2"></i>Properti Rekomendasi</h5>
                            <span id="recBudgetBadge" class="badge" style="background:var(--gold);color:var(--primary);font-size:.75rem"></span>
                        </div>
                        <div class="card-body p-3">
                            <!-- Loading state -->
                            <div id="recLoading" class="text-center py-4" style="display:none">
                                <div class="spinner-border" style="color:var(--primary);width:2rem;height:2rem" role="status"></div>
                                <p class="mt-2 text-muted mb-0" style="font-size:.9rem">Mencari properti yang sesuai…</p>
                            </div>
                            <!-- Empty state -->
                            <div id="recEmpty" class="text-center py-4" style="display:none">
                                <i class="bi bi-search" style="font-size:2.5rem;color:var(--gray);opacity:.4"></i>
                                <p class="mt-2 text-muted mb-0" style="font-size:.9rem">Belum ada properti yang cocok dengan anggaran ini.<br>Coba ubah harga properti atau hubungi kami.</p>
                            </div>
                            <!-- Cards -->
                            <div id="recCards" class="row g-3"></div>
                        </div>
                    </div>

                    <!-- Tabel Amortisasi (5 tahun pertama) -->
                    <div class="sim-card card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-table me-2"></i>Tabel Amortisasi <small class="fw-normal opacity-75">(5 tahun pertama)</small></h5>
                            <button class="btn btn-sm btn-outline-light" id="btnShowAll" onclick="toggleAmortization()">Lihat Semua</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover amortization-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-3">Tahun</th>
                                            <th>Angsuran/Bln</th>
                                            <th>Bunga/Bln</th>
                                            <th>Pokok/Bln</th>
                                            <th class="pe-3">Sisa Pinjaman</th>
                                        </tr>
                                    </thead>
                                    <tbody id="amortizationBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="text-center p-4 rounded-3" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.06)">
                        <p class="mb-3 text-muted" style="font-size:.9rem">
                            Tertarik dengan simulasi ini? Hubungi kami untuk konsultasi lebih lanjut dan temukan properti yang sesuai dengan kemampuan Anda.
                        </p>
                        @php $waNumber = preg_replace('/\D/', '', \App\Models\Setting::get('social_whatsapp', '6281234567890')); @endphp
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a id="btnWA" href="https://wa.me/{{ $waNumber }}" target="_blank" class="btn btn-success px-4">
                                <i class="bi bi-whatsapp me-2"></i>Hubungi via WhatsApp
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-envelope me-2"></i>Form Kontak
                            </a>
                        </div>
                    </div>

                </div><!-- /resultSection -->
            </div>

        </div><!-- /row -->
    </div>
</section>

@endsection

@push('scripts')
<script>
// ── Utilities ────────────────────────────────────────────────────────────────
const fmt = (n) => 'Rp ' + Math.round(n).toLocaleString('id-ID');
const fmtShort = (n) => {
    if (n >= 1e9) return 'Rp ' + (n / 1e9).toFixed(2).replace('.', ',') + ' M';
    if (n >= 1e6) return 'Rp ' + (n / 1e6).toFixed(1).replace('.', ',') + ' Jt';
    return fmt(n);
};
const parseNum = (s) => parseFloat(s.replace(/[^\d]/g, '')) || 0;

// ── Number format on input ──────────────────────────────────────────────────
function formatInputNumber(input) {
    let raw = input.value.replace(/\D/g, '');
    if (raw === '') { input.value = ''; return; }
    input.value = parseInt(raw, 10).toLocaleString('id-ID');
}

document.getElementById('inputHarga').addEventListener('input', function () {
    formatInputNumber(this);
    syncDP();
    document.getElementById('hargaDisplay').textContent = parseNum(this.value) > 0
        ? '= ' + fmtShort(parseNum(this.value)) : '';
});

document.getElementById('inputDP').addEventListener('input', function () {
    formatInputNumber(this);
    const harga = parseNum(document.getElementById('inputHarga').value);
    const dp    = parseNum(this.value);
    if (harga > 0 && dp <= harga) {
        const pct = Math.round(dp / harga * 100);
        document.getElementById('inputDPRange').value = Math.min(90, Math.max(10, pct));
        document.getElementById('dpPercent').textContent = pct + '%';
    }
    document.getElementById('dpDisplay').textContent = dp > 0 ? '= ' + fmtShort(dp) : '';
});

// ── Sliders ─────────────────────────────────────────────────────────────────
document.getElementById('inputDPRange').addEventListener('input', function () {
    document.getElementById('dpPercent').textContent = this.value + '%';
    syncDP();
});

document.getElementById('inputTenorRange').addEventListener('input', function () {
    document.getElementById('tenorDisplay').textContent = this.value + ' Tahun';
});

document.getElementById('inputBungaRange').addEventListener('input', function () {
    document.getElementById('bungaDisplay').textContent = this.value + '%';
});

function syncDP() {
    const harga = parseNum(document.getElementById('inputHarga').value);
    const pct   = parseInt(document.getElementById('inputDPRange').value);
    if (harga > 0) {
        const dp = Math.round(harga * pct / 100);
        document.getElementById('inputDP').value = dp.toLocaleString('id-ID');
        document.getElementById('dpDisplay').textContent = '= ' + fmtShort(dp);
    }
}

// ── Validation ───────────────────────────────────────────────────────────────
function validate() {
    let ok = true;
    const fields = [
        { id: 'inputNama',  check: v => v.trim().length >= 2 },
        { id: 'inputPhone', check: v => /^[\d\s\-\+]{8,15}$/.test(v.trim()) },
        { id: 'inputEmail', check: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()) },
        { id: 'inputHarga', check: v => parseNum(v) >= 50000000 },
        { id: 'inputDP',    check: v => parseNum(v) >= 1000000 },
    ];
    fields.forEach(f => {
        const el = document.getElementById(f.id);
        if (f.check(el.value)) {
            el.classList.remove('is-invalid');
            el.classList.add('is-valid');
        } else {
            el.classList.add('is-invalid');
            el.classList.remove('is-valid');
            ok = false;
        }
    });
    return ok;
}

// ── KPR Calculation (annuity / flat) ─────────────────────────────────────────
function calcKPR(pinjaman, annualRate, tenorYears) {
    const n = tenorYears * 12;
    const r = annualRate / 100 / 12;
    let monthly;
    if (r === 0) {
        monthly = pinjaman / n;
    } else {
        monthly = pinjaman * r * Math.pow(1 + r, n) / (Math.pow(1 + r, n) - 1);
    }
    return { monthly, n, r };
}

// ── Amortization table ───────────────────────────────────────────────────────
let fullAmortData = [];
let showAll = false;

function buildAmortization(pinjaman, r, n, monthly) {
    fullAmortData = [];
    let balance = pinjaman;
    for (let i = 1; i <= n; i++) {
        const interest = balance * r;
        const principal = monthly - interest;
        balance -= principal;
        fullAmortData.push({
            bulan: i,
            tahun: Math.ceil(i / 12),
            monthly,
            interest,
            principal,
            balance: Math.max(0, balance)
        });
    }
}

function renderAmortization(limitYears) {
    const tbody = document.getElementById('amortizationBody');
    tbody.innerHTML = '';
    // One row per year (end of year snapshot)
    const years = limitYears ? Math.min(limitYears, Math.ceil(fullAmortData.length / 12)) : Math.ceil(fullAmortData.length / 12);
    for (let y = 1; y <= years; y++) {
        const row = fullAmortData[(y * 12) - 1] || fullAmortData[fullAmortData.length - 1];
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="ps-3 fw-semibold">Tahun ${y}</td>
            <td>${fmt(row.monthly)}</td>
            <td class="text-danger">${fmt(row.interest)}</td>
            <td class="text-success">${fmt(row.principal)}</td>
            <td class="pe-3">${fmt(row.balance)}</td>`;
        tbody.appendChild(tr);
    }
}

function toggleAmortization() {
    showAll = !showAll;
    renderAmortization(showAll ? null : 5);
    document.getElementById('btnShowAll').textContent = showAll ? 'Sembunyikan' : 'Lihat Semua';
}

// ── Main Calculate ───────────────────────────────────────────────────────────
document.getElementById('btnHitung').addEventListener('click', function () {
    if (!validate()) {
        document.getElementById('resultSection').style.display = 'none';
        document.getElementById('placeholderSection').style.display = 'block';
        return;
    }

    const nama    = document.getElementById('inputNama').value.trim();
    const harga   = parseNum(document.getElementById('inputHarga').value);
    const dp      = parseNum(document.getElementById('inputDP').value);
    const tenor   = parseInt(document.getElementById('inputTenorRange').value);
    const bunga   = parseFloat(document.getElementById('inputBungaRange').value);
    const pinjaman = harga - dp;

    if (dp >= harga) {
        alert('Uang muka tidak boleh melebihi atau sama dengan harga properti.');
        return;
    }

    const { monthly, n, r } = calcKPR(pinjaman, bunga, tenor);
    const totalBayar        = monthly * n;
    const totalBunga        = totalBayar - pinjaman;

    // Build amortization
    buildAmortization(pinjaman, r, n, monthly);
    showAll = false;
    renderAmortization(5);
    document.getElementById('btnShowAll').textContent = 'Lihat Semua';

    // Update result card
    document.getElementById('resultGreeting').textContent = 'Halo, ' + nama + '! Berikut simulasi KPR Anda:';
    document.getElementById('rCicilanBulan').textContent  = fmt(monthly) + '/bulan';
    document.getElementById('rHarga').textContent         = fmtShort(harga);
    document.getElementById('rDP').textContent            = fmtShort(dp);
    document.getElementById('rPokok').textContent         = fmtShort(pinjaman);
    document.getElementById('rTenor').textContent         = tenor + ' tahun (' + n + ' bulan)';
    document.getElementById('rBunga').textContent         = bunga + '% / tahun';
    document.getElementById('rTotal').textContent         = fmtShort(totalBayar);

    // Recommended properties fetch
    fetchRecommended(harga);

    // Save lead silently (fire-and-forget)
    fetch('{{ route("simulasi-cicilan.lead") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            name: nama,
            email: document.getElementById('inputEmail').value.trim(),
            phone: document.getElementById('inputPhone').value.trim(),
            price_input: harga
        })
    }).catch(() => {}); // silent fail — don't block UX

    // WhatsApp message pre-fill
    const waMsg = encodeURIComponent(
        `Halo Midland Properti,\n\nSaya ${nama} ingin konsultasi lebih lanjut mengenai properti.\n\nHasil simulasi saya:\n` +
        `- Harga Properti: ${fmt(harga)}\n` +
        `- DP: ${fmt(dp)}\n` +
        `- Tenor: ${tenor} tahun\n` +
        `- Suku Bunga: ${bunga}%\n` +
        `- Estimasi Cicilan: ${fmt(monthly)}/bulan\n\nMohon bantuannya. Terima kasih.`
    );
    const waBase = document.getElementById('btnWA').href.split('?')[0];
    document.getElementById('btnWA').href = waBase + '?text=' + waMsg;

    // Show result, hide placeholder
    document.getElementById('placeholderSection').style.display = 'none';
    document.getElementById('resultSection').style.display = 'block';
    document.getElementById('resultSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
});

// ── Recommended properties ───────────────────────────────────────────────────
function fetchRecommended(harga) {
    const loading = document.getElementById('recLoading');
    const empty   = document.getElementById('recEmpty');
    const cards   = document.getElementById('recCards');
    const badge   = document.getElementById('recBudgetBadge');

    badge.textContent = 'Anggaran: ' + fmtShort(harga);
    loading.style.display = 'block';
    empty.style.display   = 'none';
    cards.innerHTML       = '';

    fetch('{{ route("simulasi-cicilan.recommend") }}?price=' + harga)
        .then(r => r.json())
        .then(data => {
            loading.style.display = 'none';
            if (!data.length) {
                empty.style.display = 'block';
                return;
            }
            data.forEach(p => {
                const imgHtml = p.image
                    ? `<img src="${p.image}" alt="${p.title}" class="rec-img">`
                    : `<div class="rec-img-placeholder"><i class="bi bi-building"></i></div>`;

                const diffPct = Math.abs(Math.round((p.price - harga) / harga * 100));
                const isClose = diffPct <= 10;
                const badgeHtml = isClose
                    ? `<span class="badge rec-match-badge" style="background:var(--primary);color:#fff"><i class="bi bi-check-circle me-1"></i>Sesuai Anggaran</span>`
                    : (p.price < harga
                        ? `<span class="badge rec-match-badge bg-success-subtle text-success">Di bawah anggaran</span>`
                        : `<span class="badge rec-match-badge bg-warning-subtle text-warning">Sedikit di atas</span>`);

                cards.innerHTML += `
                <div class="col-12">
                    <div class="rec-card d-flex overflow-hidden" style="background:#fff">
                        <div style="flex:0 0 140px">${imgHtml}</div>
                        <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                    <div class="rec-title">${p.title}</div>
                                    ${badgeHtml}
                                </div>
                                <div class="rec-price mb-1">${p.price_fmt}</div>
                                ${p.location ? `<div class="text-muted" style="font-size:.8rem"><i class="bi bi-geo-alt me-1"></i>${p.location}</div>` : ''}
                                ${p.type_label ? `<div class="text-muted" style="font-size:.8rem"><i class="bi bi-tag me-1"></i>${p.type_label} &bull; <span class="${p.status === 'available' ? 'text-success' : 'text-secondary'}">${p.status_label}</span></div>` : ''}
                            </div>
                            <div class="mt-2">
                                <a href="${p.url}" class="btn btn-sm btn-gold px-3">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        })
        .catch(() => {
            loading.style.display = 'none';
            empty.style.display   = 'block';
        });
}

// ── Bootstrap tooltips ───────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    var tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(el => new bootstrap.Tooltip(el));
});
</script>
@endpush
