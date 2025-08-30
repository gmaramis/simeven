<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peserta - {{ $event->title }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .header h2 {
            font-size: 18px;
            font-weight: normal;
            margin: 0 0 5px 0;
            color: #666;
        }
        
        .event-info {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
        
        .event-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .event-info td {
            padding: 5px 10px;
            border: none;
        }
        
        .event-info td:first-child {
            font-weight: bold;
            width: 120px;
        }
        
        .participants-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .participants-table th,
        .participants-table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
            font-size: 12px;
        }
        
        .participants-table th {
            background: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        
        .participants-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
        
        .ministry-badge {
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .page-number {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button class="print-button no-print" onclick="window.print()">
        🖨️ Print Daftar
    </button>
    
    <!-- Header -->
    <div class="header">
        <h1>GSJA KAIROS MANADO</h1>
        <h2>Daftar Peserta Event</h2>
        <h2>{{ $event->title }}</h2>
    </div>
    
    <!-- Event Information -->
    <div class="event-info">
        <table>
            <tr>
                <td>Nama Event:</td>
                <td>{{ $event->title }}</td>
                <td>Tanggal Event:</td>
                <td>{{ $event->start_date->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <td>Lokasi:</td>
                <td>{{ $event->location }}</td>
                <td>Total Peserta:</td>
                <td>{{ $participants->count() }} orang</td>
            </tr>
            <tr>
                <td>Deskripsi:</td>
                <td colspan="3">{{ $event->description }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Participants Table -->
    @if($participants->count() > 0)
        <table class="participants-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No.</th>
                    <th style="width: 200px;">Nama Lengkap</th>
                    <th style="width: 150px;">Asal Gereja</th>
                    <th style="width: 120px;">Bidang Pelayanan</th>
                    <th style="width: 120px;">Nomor HP/WA</th>
                    <th style="width: 150px;">Email</th>
                    <th style="width: 100px;">Tanggal Daftar</th>
                    <th style="width: 200px;">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $index => $participant)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                        <td>{{ $participant->name }}</td>
                        <td>{{ $participant->church ?? 'Tidak diisi' }}</td>
                        <td style="text-align: center;">
                            <span class="ministry-badge">{{ $participant->ministry ?? 'Tidak diisi' }}</span>
                        </td>
                        <td>{{ $participant->phone }}</td>
                        <td>{{ $participant->email ?? 'Tidak diisi' }}</td>
                        <td style="text-align: center;">{{ $participant->created_at->format('d/m/Y') }}</td>
                        <td>{{ $participant->notes ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Summary -->
        <div style="margin-top: 20px; padding: 15px; background: #f5f5f5; border-radius: 5px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px;">Ringkasan Peserta:</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 5px 10px; border: none;"><strong>Total Peserta:</strong></td>
                    <td style="padding: 5px 10px; border: none;">{{ $participants->count() }} orang</td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: none;"><strong>Gembala Sidang:</strong></td>
                    <td style="padding: 5px 10px; border: none;">{{ $participants->where('ministry', 'Gembala Sidang')->count() }} orang</td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: none;"><strong>Pengerja:</strong></td>
                    <td style="padding: 5px 10px; border: none;">{{ $participants->where('ministry', 'Pengerja')->count() }} orang</td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: none;"><strong>Worship Leader:</strong></td>
                    <td style="padding: 5px 10px; border: none;">{{ $participants->where('ministry', 'Worship Leader')->count() }} orang</td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: none;"><strong>Singers:</strong></td>
                    <td style="padding: 5px 10px; border: none;">{{ $participants->where('ministry', 'Singers')->count() }} orang</td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: none;"><strong>Tim Musik:</strong></td>
                    <td style="padding: 5px 10px; border: none;">{{ $participants->where('ministry', 'Tim Musik')->count() }} orang</td>
                </tr>
            </table>
        </div>
    @else
        <div class="no-data">
            <h3>Belum ada peserta terkonfirmasi</h3>
            <p>Peserta akan muncul di sini setelah pendaftaran dikonfirmasi</p>
        </div>
    @endif
    
    <!-- Footer -->
    <div class="footer">
        <p><strong>Dicetak pada:</strong> {{ now()->format('d M Y, H:i') }}</p>
        <p><strong>GSJA Kairos Manado</strong> - Sistem Manajemen Event</p>
    </div>
    
    <script>
        // Auto print when page loads
        window.onload = function() {
            // Uncomment the line below to auto-print
            // window.print();
        };
    </script>
</body>
</html>
