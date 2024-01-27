<?php

use App\Models\SysMenu;

function menuAside()
{
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
                'title' => 'Perolehan Suara',
                'root' => true,
                'icon' => 'media/svg/icons/Communication/Urgent-mail.svg', 
                'page' => 'voting',
                'new-tab' => false,
                
            ],   
            [
                'title' => 'Data Caleg',
                'root' => true,
                'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'page' => 'caleg',
                'new-tab' => false,
                
            ],    
            [
                'title' => 'Data Pemilih',
                'root' => true,
                'icon' => 'media/svg/icons/Communication/Clipboard-list.svg', 
                'page' => 'pemilih',
                'new-tab' => false,
                
            ],       
            [
                'title' => 'Master Data',
                'icon' => 'media/svg/icons/Files/Group-folders.svg',
                'bullet' => 'line',
                'arrow' => true,
                'root' => true,
                'submenu' => [
                    [
                        'title' => 'Kecamatan',
                        'page' => 'kecamatan'
                    ],
                    [
                        'title' => 'Desa',
                        'page' => 'desa'
                    ],
                    // [
                    //     'title' => 'TPS',
                    //     'page' => 'tps'
                    // ],
                   
                ]
            ],
            // [
            //     'title' => 'Transaksi',
            //     'icon' => 'media/svg/icons/Shopping/Cart3.svg',
            //     'bullet' => 'line',
            //     'arrow' => true,
            //     'root' => true,
            //     'submenu' => [
            //         [
            //             'title' => 'Barang Masuk',
            //             'page' => 'master-data/kategori'
            //         ],
            //         [
            //             'title' => 'Transaksi',
            //             'page' => 'master-data/satuan'
            //         ],
            //         [
            //             'title' => 'Barang Keluar',
            //             'page' => 'produk'
            //         ],
            //     ]
            // ],
            
            
            
           
            // [
            //     'title' => 'Referensi',
            //     'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            //     'bullet' => 'line',
            //     'arrow' => true,
            //     'root' => true,
            //     'submenu' => [
            //         [
            //             'title' => 'Klasifikasi Invoice',
            //             'page' => 'referensi/klasifikasi-invoice'
            //         ],
            //         [
            //             'title' => 'Kategori MAR',
            //             'page' => 'referensi/mar-emar'
            //         ],
            //         [
            //             'title' => 'Bank',
            //             'page' => 'referensi/bank'
            //         ],
            //     ]
            // ],
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
                    // [
                    //     'title' => 'Menu',
                    //     'page' => 'system/menu'
                    // ],
                ]
            ],


            
        ]

    ];

}
function menuAsidedb()
{
    $role_id = auth()->user()->role_id;
    $data = SysMenu::select('title', 'root', 'icon', 'page', 'parent_id', 'id', 'arrow','bullet')
    ->with(['submenu' => function ($builder) use ($role_id ) {
        $builder->select('id', 'parent_id', 'title', 'page');
        $builder->whereHas('menu_action', function ($builder) use ($role_id) {
            $builder->whereHas('role_menu_access',function ($builder) use ($role_id) {
                $builder->where('role_id',$role_id);
            });
        });
    }, 'labelmenu' => function ($builder) {
        $builder->select('id', 'type', 'value', 'menu_id');
    }])
    ->whereHas('menu_action', function( $query ) use ( $role_id ){
        $query->whereHas('role_menu_access', function ($query) use ($role_id) {
            $query->where('role_id',$role_id);
        });
    })
    ->where([['is_parent', '=', '1'], ['status_code', '=', 'active']])
    ->orderBy('order','ASC')
    ->get();

    $tmp = array();
    foreach ($data as $key => $value) {
        $menu = [
            'title' => $value['title'],
            'root' => true,
            'icon' => $value['icon'], 
            'page' => $value['page'],
            'new-tab' => false,
        ];

        $tmp[$key]['items'] = $menu;
        if(!empty($value['labelmenu'])){
            foreach ($value['labelmenu'] as $label) {
                $tmp[$key]['items']['label'] = [
                    'type' => $label['type'],
                    'value' => $label['value']
                ];
            }
        }

        if(isset($value['submenu']) && !empty($value['submenu']) && !empty($value['arrow'])) {
            $tmp[$key]['items'] = array_merge($menu, [
                'bullet' => $value['bullet'],
                'arrow' => true,
                'submenu' => $value['submenu']->toArray(),
            ]);
        }
    }
    
    return $tmp;
}
