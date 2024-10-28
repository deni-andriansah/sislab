<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Serah Terima</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }

        /* Full-page container for PDF export */
        .container {
            max-width: 100%; /* Adjusted to full width */
            padding: 5%; /* Padding for content */
            box-sizing: border-box; /* Include padding in width calculations */
            overflow: hidden; /* Prevent scrolling */
            margin: auto; /* Center the container */
        }

        /* Center and style headings */
        h2,
        h3 {
            text-align: center;
            margin-bottom: 1%; /* Margin bottom for headings */
        }

        p {
            margin: 1% 0; /* Margin top and bottom for paragraphs */
        }

        /* Horizontal line */
        hr {
            margin: 1% 0; /* Margin top and bottom for horizontal line */
            border: 0;
            border-top: 2px solid #333;
        }

        /* Styling for the bordered heading */
        .border h3 {
            border: 3px double #000;
        }

        /* Checkbox styling */
        .checkbox {
            margin-right: 1%; /* Margin right for checkboxes */
        }

        /* Signature area */
        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 10%; /* Margin top for signature area */
        }

        /* Signature block */
        .signature {
            text-align: center;
            width: 40%; /* Adjusted to fit better in smaller screens */
        }

        /* Space for signature line */
        .signature-line {
            border-top: 1px solid black;
            width: 100%;
            margin-top: 1%; /* Margin top for signature line */
        }

        .badan {
            border: 3px double #000;
            padding: 1%; /* Padding for content inside the bordered section */
            box-sizing: border-box; /* Include padding in width calculations */
        }

        /* Styling for the information section */
        .badan strong {
            font-size: 18px;
            display: block;
            margin: 1% 0; /* Margin top and bottom for strong tags */
        }

        /* Dynamic margin for signature section */
        .signature-area .signature p {
            margin-bottom: 1%; /* Margin bottom for signature section paragraphs */
        }

        /* Print Styles */
        @media print {
            body {
                margin: 0; /* Remove margins for print */
            }

            .container {
                max-width: none; /* Allow full width for printing */
                height: auto; /* Allow height to adjust */
                padding: 5%; /* Padding for content */
            }

            /* Hide elements that shouldn't be printed */
            .no-print {
                display: none;
            }
        }

        /* Responsive design adjustments */
        @media (max-width: 0px) {
            .signature-area {
                flex-direction: column;
                align-items: center;
            }

            .signature {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Title Section -->
        <h2>SNPMPB</h2>
        <div class="head">
            <center>
                <p><strong>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</strong><br>
                    SELEKSI NASIONAL BERDASARKAN TES (SNBT)<br>
                    PUSAT UJIAN TULIS BERBASIS KOMPUTER (UTBK) UNIVERSITAS PADJADJARAN<br>
                    Sekretariat: Gedung Kandaga Universitas Padjadjaran Jl. Ir. Soekarno Km. 21 (dh/Jl. Raya
                    Bandung-Sumedang Km.
                    21)
                    Jatinangor - Tlp 022848288888
                </p>
            </center>
        </div>

        <hr>

        <!-- Document Title -->
        <div class="border">
            <h3>BERITA ACARA SERAH TERIMA</h3>
        </div>

        <!-- Main Content -->
        <div class="badan">
            <p>Lembar ini untuk:</p>
            <p><input type="checkbox" class="checkbox"> Yang Menyerahkan<br>
                <input type="checkbox" class="checkbox"> Yang Menerima
            </p>

            <center>
                <p>Pada hari ini Kamis tanggal 25 bulan April tahun 2024 bertempat di Universitas Padjadjaran telah
                    diserahkan oleh:</p>

                <strong>Sub Bidang TIK Pusat UTBK Unpad</strong>

                <p><strong>Kepada</strong><br>
                    PIC Laboratorium Komputer PTIPD UIN Sunan Gunung Djati Bandung</p>

                <p><strong>Berupa</strong><br>
                    Stiker Workstation dan Daftar Nomor Meja Peserta<br>
                    Lab 2.1 - 2.4 - PTIPD Lt. 2<br>
                    Lab 3.1 - 3.7 - PTIPD Lt. 3<br>
                    Lab 4.1 - 4.5 - PTIPD Lt. 4
                </p>
            </center>

            <!-- Signature Area -->

            <div class="signature-area">
                <div class="signature">
                    <p>Yang Menyerahkan,</p>
                    <div class="signature-line"></div>
                </div>
                <div class="signature">
                    <p>Yang Menerima,</p>
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
