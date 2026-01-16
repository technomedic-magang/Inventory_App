<?php
defined('BASEPATH') or exit('No direct script access allowed');

// 1. Panggil File FPDF dari folder third_party
require_once APPPATH . 'third_party/fpdf/fpdf.php';

// 2. Buat Class PDF Custom (Extend FPDF) untuk Header/Footer
class PDF_Penggunaan extends FPDF
{
    // Header muncul otomatis di setiap halaman baru
    function Header()
    {
        // Logo (Opsional, uncomment jika ada logo)
        // $this->Image('assets/img/logo.png', 10, 6, 30);
        
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, 'LAPORAN PENGGUNAAN & DISTRIBUSI ASET', 0, 1, 'C');
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'PT. INDO TECHNO MEDIC', 0, 1, 'C');
        
        $this->Ln(5);
        $this->Line(10, 25, 287, 25); // Garis horizontal (Format Landscape)
        $this->Ln(5);
    }

    // Footer muncul otomatis di setiap halaman
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
}

class Laporan_penggunaan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _models(['laporan/m_laporan_penggunaan']);
        $this->template = 'laporan/laporan_penggunaan/';
        $this->uri      = 'laporan/laporan_penggunaan';
    }

    public function index()
    {
        // ... (Kode index/tampilan filter HTML biasa) ...
        // Anda bisa copy dari contoh sebelumnya jika butuh view HTML-nya
        $this->render($this->template . 'index'); 
    }

    // 3. FUNGSI CETAK PDF
    public function cetak_pdf()
    {
        // Ambil Filter dari URL
        $start  = $this->input->get('start') ?? date('Y-m-01');
        $end    = $this->input->get('end') ?? date('Y-m-d');
        $status = $this->input->get('status') ?? 'ALL';

        // Ambil Data
        $data = $this->m_laporan_penggunaan->get_report_data($start, $end, $status);

        // Init PDF (Landscape, Millimeter, A4)
        $pdf = new PDF_Penggunaan('L', 'mm', 'A4');
        $pdf->AliasNbPages(); // Untuk hitung total halaman {nb}
        $pdf->AddPage();

        // --- INFO PERIODE ---
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 6, 'Periode', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0);
        $pdf->Cell(100, 6, date('d M Y', strtotime($start)) . ' s/d ' . date('d M Y', strtotime($end)), 0, 1);
        
        $pdf->Cell(30, 6, 'Filter Status', 0, 0);
        $pdf->Cell(5, 6, ':', 0, 0);
        $label_status = ($status == 'ALL') ? 'Semua Transaksi' : (($status == 'OPEN') ? 'Sedang Dipakai' : 'Sudah Kembali');
        $pdf->Cell(100, 6, $label_status, 0, 1);
        $pdf->Ln(5);

        // --- HEADER TABEL ---
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(230, 230, 230); // Abu-abu muda

        // Set Lebar Kolom (Total Landscape A4 margin kiri kanan = +- 277mm)
        // No(10)+Tgl(25)+Bukti(35)+Aset(60)+Peminjam(45)+Keperluan(50)+Status(25)+Qty(20) = 270
        $w = [10, 25, 35, 60, 45, 50, 25, 20];

        $pdf->Cell($w[0], 8, 'No', 1, 0, 'C', true);
        $pdf->Cell($w[1], 8, 'Tanggal', 1, 0, 'C', true);
        $pdf->Cell($w[2], 8, 'No. Bukti', 1, 0, 'C', true);
        $pdf->Cell($w[3], 8, 'Nama Aset', 1, 0, 'L', true);
        $pdf->Cell($w[4], 8, 'Peminjam', 1, 0, 'L', true);
        $pdf->Cell($w[5], 8, 'Keperluan', 1, 0, 'L', true);
        $pdf->Cell($w[6], 8, 'Status', 1, 0, 'C', true);
        $pdf->Cell($w[7], 8, 'Qty', 1, 1, 'C', true); // 1 = Pindah Baris

        // --- ISI DATA ---
        $pdf->SetFont('Arial', '', 9);
        $no = 1;

        if (empty($data)) {
            $pdf->Cell(array_sum($w), 10, 'Tidak ada data ditemukan pada periode ini.', 1, 1, 'C');
        } else {
            foreach ($data as $row) {
                // Tentukan Status Teks
                $is_dipakai = ($row['qty_kembali'] < $row['qty_ambil']);
                $status_txt = $is_dipakai ? 'DIPAKAI' : 'KEMBALI';

                // Warna text status (Opsional, FPDF mendukung SetTextColor)
                if ($is_dipakai) {
                    $pdf->SetTextColor(220, 53, 69); // Merah
                } else {
                    $pdf->SetTextColor(25, 135, 84); // Hijau
                }
                
                // Cetak Baris
                // Gunakan Cell biasa agar rapi (jika teks panjang akan terpotong, 
                // jika ingin teks turun ke bawah gunakan MultiCell tapi lebih rumit di table)
                $pdf->Cell($w[0], 7, $no++, 1, 0, 'C');
                $pdf->SetTextColor(0, 0, 0); // Reset warna hitam untuk data lain
                
                $pdf->Cell($w[1], 7, date('d/m/y', strtotime($row['transaksi_tgl'])), 1, 0, 'C');
                $pdf->Cell($w[2], 7, $row['transaksi_no'], 1, 0, 'L');
                
                // Cut text (substr) agar tidak terlalu panjang
                $pdf->Cell($w[3], 7, substr($row['asset_nm'], 0, 30), 1, 0, 'L');
                $pdf->Cell($w[4], 7, substr($row['pegawai_nm'], 0, 20), 1, 0, 'L');
                $pdf->Cell($w[5], 7, substr($row['keperluan_txt'], 0, 25), 1, 0, 'L');
                
                // Cetak Status berwarna tadi
                if ($is_dipakai) $pdf->SetTextColor(220, 53, 69); 
                else $pdf->SetTextColor(25, 135, 84);
                
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell($w[6], 7, $status_txt, 1, 0, 'C');
                
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0); // Reset hitam
                $pdf->Cell($w[7], 7, $row['qty_ambil'], 1, 1, 'C');
            }
        }

        // --- TANDA TANGAN ---
        $pdf->Ln(10);
        $pdf->SetX(220); 
        $pdf->Cell(50, 5, 'Dicetak Oleh,', 0, 1, 'C');
        $pdf->Ln(15);
        $pdf->SetX(220);
        $pdf->Cell(50, 5, '( Admin Logistik )', 0, 1, 'C');

        // Output PDF ke Browser
        $pdf->Output('I', 'Laporan_Penggunaan_Aset.pdf');
    }
}