<?php
    return[
        'struktur_akun' => [
            [
                'nama' => 'Aktiva',
                'jenis' => 'Neraca',
                'detail' => [
                    [
                        'nama' => 'Kas',
                        'cash' => true,
                        'bank' => false
                    ],
                    [
                        'nama' => 'Bank',
                        'cash' => false,
                        'bank' => true
                    ],
                    [
                        'nama' => 'Piutang',
                        'cash' => false,
                        'bank' => false
                    ],
                    [
                        'nama' => 'Persediaan',
                        'cash' => false,
                        'bank' => false
                    ],
                    [
                        'nama' => 'Biaya Dibayar Dimuka',
                        'cash' => false,
                        'bank' => false
                    ],
                    [
                        'nama' => 'Aktiva Tetap',
                        'cash' => false,
                        'bank' => false
                    ],
                    [
                        'nama' => 'Investasi',
                        'cash' => false,
                        'bank' => false
                    ]
                ],
            ],
            [
                'nama' => 'Hutang',
                'jenis' => 'Neraca',
                'detail' => [
                    [
                        'nama' => 'Hutang',
                        'cash' => false,
                        'bank' => false,
                    ]
                ]
            ],
            [
                'nama' => 'Modal',
                'jenis' => 'Neraca',
                'detail' => [
                    [
                        'nama' => 'Modal',
                        'cash' => false,
                        'bank' => false,
                    ]
                ]
            ],
            [
                'nama' => 'Pendapatan',
                'jenis' => 'Laba - Rugi',
                'detail' => [
                    [
                        'nama' => 'Pendapatan',
                        'cash' => false,
                        'bank' => false,
                    ],
                    [
                        'nama' => 'Pendapatan Lain-lain',
                        'cash' => false,
                        'bank' => false,
                    ],
                    [
                        'nama' => 'Pendapatan Bunga',
                        'cash' => false,
                        'bank' => false,
                    ]
                ]
            ],
            [
                'nama' => 'HPP',
                'jenis' => 'Laba - Rugi',
                'detail' => [
                    [
                        'nama' => 'HPP',
                        'cash' => false,
                        'bank' => false,
                    ]
                ]
            ],
            [
                'nama' => 'Biaya Operasional',
                'jenis' => 'Laba - Rugi',
                'detail' => [
                    [
                        'nama' => 'Biaya Operasional',
                        'cash' => false,
                        'bank' => false,
                    ]
                ]
            ],
            [
                'nama' => 'Biaya Penyusutan',
                'jenis' => 'Laba - Rugi',
                'detail' => [
                    [
                        'nama' => 'Biaya Penyusutan',
                        'cash' => false,
                        'bank' => false,
                    ]
                ]
            ],
        ],

        'konsep_akun' => [
            'levelmax' => 6,
            'digitmax' => 12,
            'detail' => [
                [
                    'level' => 1,
                    'jumlahdigit' => 1
                ],
                [
                    'level' => 2,
                    'jumlahdigit' => 3
                ],
                [
                    'level' => 3,
                    'jumlahdigit' => 5
                ],
                [
                    'level' => 4,
                    'jumlahdigit' => 7
                ],
                [
                    'level' => 5,
                    'jumlahdigit' => 10
                ],
                [
                    'level' => 6,
                    'jumlahdigit' => 12
                ],
            ],
        ],

        'akun' => [
            #region level 1
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => null,
                'normalpos' => 'Debit',
                'level' => 1,
                'no' => '1',
                'nama' => 'AKTIVA',
            ],
            [
                'komponen' => 'NERACA',
                'id_struktur_akun' => 'Hutang',
                'id_struktur_akun_detail' => 'Hutang',
                'normalpos' => 'Kredit',
                'level' => 1,
                'no' => '2',
                'nama' => 'HUTANG',
            ],
            [
                'komponen' => 'NERACA',
                'id_struktur_akun' => 'Modal',
                'id_struktur_akun_detail' => 'Modal',
                'normalpos' => 'Kredit',
                'level' => 1,
                'no' => '3',
                'nama' => 'EKUITAS',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'Pendapatan',
                'id_struktur_akun_detail' => 'Pendapatan',
                'normalpos' => 'Kredit',
                'level' => 1,
                'no' => '4',
                'nama' => 'PENDAPATAN',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'HPP',
                'id_struktur_akun_detail' => null,
                'normalpos' => 'Debit',
                'level' => 1,
                'no' => '5',
                'nama' => 'HARGA POKOK PENJUALAN',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'Biaya Operasional',
                'id_struktur_akun_detail' => 'Biaya Operasional',
                'normalpos' => 'Debit',
                'level' => 1,
                'no' => '6',
                'nama' => 'BIAYA OPERASIONAL',
            ],
            #endregion

            #region level 2
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => null,
                'normalpos' => 'Debit',
                'level' => 2,
                'no' => '101',
                'nama' => 'AKTIVA LANCAR',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => 'Aktiva Tetap',
                'normalpos' => 'Debit',
                'level' => 2,
                'no' => '102',
                'nama' => 'AKTIVA TETAP',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Hutang',
                'id_struktur_akun_detail' => 'Hutang',
                'normalpos' => 'Kredit',
                'level' => 2,
                'no' => '201',
                'nama' => 'HUTANG LANCAR',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Hutang',
                'id_struktur_akun_detail' => 'Hutang',
                'normalpos' => 'Kredit',
                'level' => 2,
                'no' => '202',
                'nama' => 'HUTANG JANGKA PANJANG',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Modal',
                'id_struktur_akun_detail' => 'Modal',
                'normalpos' => 'Kredit',
                'level' => 2,
                'no' => '301',
                'nama' => 'MODAL DISETOR',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'Pendapatan',
                'id_struktur_akun_detail' => 'Pendapatan',
                'normalpos' => 'Kredit',
                'level' => 2,
                'no' => '401',
                'nama' => 'PENDAPATAN USAHA',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'HPP',
                'id_struktur_akun_detail' => null,
                'normalpos' => 'Debit',
                'level' => 2,
                'no' => '501',
                'nama' => 'HARGA POKOK PENJUALAN',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'Biaya Operasional',
                'id_struktur_akun_detail' => 'Biaya Operasional',
                'normalpos' => 'Debit',
                'level' => 2,
                'no' => '601',
                'nama' => 'BIAYA KARYAWAN',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'Biaya Operasional',
                'id_struktur_akun_detail' => 'Biaya Operasional',
                'normalpos' => 'Debit',
                'level' => 2,
                'no' => '602',
                'nama' => 'BIAYA PERKANTORAN DAN LAYANAN UMUM',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'Biaya Operasional',
                'id_struktur_akun_detail' => 'Biaya Operasional',
                'normalpos' => 'Debit',
                'level' => 2,
                'no' => '603',
                'nama' => 'BIAYA ENERGI, KOMUNIKASI, DAN AKOMODASI',
            ],
            [
                'komponen' => 'Laba - Rugi',
                'id_struktur_akun' => 'Biaya Operasional',
                'id_struktur_akun_detail' => 'Biaya Operasional',
                'normalpos' => 'Debit',
                'level' => 2,
                'no' => '604',
                'nama' => 'BIAYA PEMELIHARAAN DAN SEWA',
            ],
            #endregion

            #region level 3
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => 'Kas',
                'normalpos' => 'Debit',
                'level' => 3,
                'no' => '10101',
                'nama' => 'KAS',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => 'Bank',
                'normalpos' => 'Debit',
                'level' => 3,
                'no' => '10102',
                'nama' => 'BANK & DEPOSITO',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => 'Piutang',
                'normalpos' => 'Debit',
                'level' => 3,
                'no' => '10103',
                'nama' => 'PIUTANG USAHA',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => 'Aktiva Tetap',
                'normalpos' => 'Debit',
                'level' => 3,
                'no' => '10201',
                'nama' => 'Mobil',
            ],
            [
                'komponen' => 'Neraca',
                'id_struktur_akun' => 'Aktiva',
                'id_struktur_akun_detail' => 'Aktiva Tetap',
                'normalpos' => 'Debit',
                'level' => 3,
                'no' => '10202',
                'nama' => 'Motor',
            ],
            #endregion
        ],

        'labarugi_akun' => [

        ],
    ]
?>
