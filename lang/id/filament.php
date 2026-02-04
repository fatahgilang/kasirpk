<?php

return [
    'pages' => [
        'dashboard' => [
            'title' => 'Dasbor',
            'widgets' => [
                'account-widget' => [
                    'heading' => 'Selamat datang',
                    'subheading' => 'Anda masuk sebagai',
                    'buttons' => [
                        'logout' => [
                            'label' => 'Keluar',
                        ],
                    ],
                ],
                'global-search' => [
                    'field' => [
                        'label' => 'Pencarian',
                        'placeholder' => 'Cari',
                    ],
                ],
            ],
        ],
        'auth' => [
            'login' => [
                'title' => 'Masuk ke akun Anda',
                'heading' => 'Masuk',
                'buttons' => [
                    'authenticate' => [
                        'label' => 'Masuk',
                    ],
                ],
                'fields' => [
                    'email' => [
                        'label' => 'Alamat Email',
                    ],
                    'password' => [
                        'label' => 'Kata Sandi',
                    ],
                    'remember' => [
                        'label' => 'Ingat saya',
                    ],
                ],
                'messages' => [
                    'failed' => 'Kredensial ini tidak cocok dengan catatan kami.',
                    'throttled' => 'Terlalu banyak percobaan masuk. Silakan coba lagi dalam :seconds detik.',
                ],
            ],
        ],
    ],
    'resources' => [
        'pages' => [
            'create' => [
                'title' => 'Buat :label',
                'buttons' => [
                    'create' => [
                        'label' => 'Buat',
                    ],
                    'create_and_create_another' => [
                        'label' => 'Buat & Buat Lainnya',
                    ],
                    'cancel' => [
                        'label' => 'Batal',
                    ],
                ],
            ],
            'edit' => [
                'title' => 'Edit :label',
                'buttons' => [
                    'save' => [
                        'label' => 'Simpan',
                    ],
                    'cancel' => [
                        'label' => 'Batal',
                    ],
                ],
            ],
            'list' => [
                'title' => ':label',
                'table' => [
                    'heading' => ':label',
                    'columns' => [
                        'actions' => [
                            'label' => 'Aksi',
                        ],
                    ],
                ],
                'actions' => [
                    'create' => [
                        'label' => 'Buat :label',
                    ],
                    'edit' => [
                        'label' => 'Edit',
                    ],
                    'delete' => [
                        'label' => 'Hapus',
                        'modal' => [
                            'heading' => 'Hapus :label',
                            'subheading' => 'Apakah Anda yakin ingin melakukan ini?',
                            'buttons' => [
                                'delete' => [
                                    'label' => 'Hapus',
                                ],
                                'cancel' => [
                                    'label' => 'Batal',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'components' => [
        'button' => [
            'submit' => [
                'label' => 'Kirim',
            ],
        ],
    ],
];