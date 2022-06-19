<?php

namespace App\Models;

class SetupAwal
{
    public static $struktur_akun = [
        [
            'nama' => 'Aktifa',
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
                // piutang
                [
                    'nama' => 'Piutang',
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
            'jenis' => 'Laba Rugi',
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
            'jenis' => 'Laba Rugi',
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
            'jenis' => 'Laba Rugi',
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
            'jenis' => 'Laba Rugi',
            'detail' => [
                [
                    'nama' => 'Biaya Penyusutan',
                    'cash' => false,
                    'bank' => false,
                ]
            ]
        ],
    ];

    public static $konsep_akun = [
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
            ]
        ]
    ];

    public static $labarugi_akun = [];

    public static $akun = [];

}
