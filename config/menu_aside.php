<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', 
            'page' => 'dashboard',
            
        ],
        [
            'title' => 'Invoice',
            'root' => true,
            'icon' => 'media/svg/icons/Communication/Clipboard-list.svg', 
            'page' => 'invoices',
            'new-tab' => false,
            'label' => [
                'type' => 'label-rounded label-primary total_invoice',
                'value' => '0'
            ],
        ],
        [
            'title' => 'Pajak',
            'root' => true,
            'icon' => 'media/svg/icons/Communication/Urgent-mail.svg', 
            'page' => 'pajak',
            'new-tab' => false,
            'label' => [
                'type' => 'label-rounded label-primary total_pajak',
                'value' => '0'
            ],
        ],
        [
            'title' => 'Saldo Bank',
            'root' => true,
            'icon' => 'media/svg/icons/Shopping/Wallet.svg', 
            'page' => 'saldo',
            'new-tab' => false,
        ],
        [
            'title' => 'Arsip',
            'icon' => 'media/svg/icons/Files/Group-folders.svg',
            'bullet' => 'line',
            'arrow' => true,
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Dokumen Invoice',
                    'page' => 'arsip-invoice'
                ],
                [
                    'title' => 'Dokumen Pajak',
                    'page' => 'arsip-pajak'
                ],
            ]
        ],
        [
            'title' => 'PRK',
            'root' => true,
            'icon' => 'media/svg/icons/Home/Book-open.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => 'prk',
            'new-tab' => false,
        ],
        [
            'title' => 'Laporan MAR/EMAR',
            'root' => true,
            'icon' => 'media/svg/icons/Home/Book-open.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => 'reportmaremar',
            'new-tab' => false,
        ],
        [
            'title' => 'Referensi',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'arrow' => true,
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Klasifikasi Invoice',
                    'page' => 'referensi/klasifikasi-invoice'
                ],
                [
                    'title' => 'Kategori MAR',
                    'page' => 'referensi/mar-emar'
                ],
                [
                    'title' => 'Bank',
                    'page' => 'referensi/bank'
                ],
            ]
        ],
        [
            'title' => 'Sistem',
            'icon' => 'media/svg/icons/General/Settings-1.svg',
            'bullet' => 'line',
            'arrow' => true,
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Users',
                    'page' => 'system/users'
                ],
                [
                    'title' => 'Roles',
                    'page' => 'system/role'
                ],
            ]
        ],


        
    ]

];
