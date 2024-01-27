<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class SysMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu= array(
            [
                "parent_id"      => null,
                "title"          => "Dashboard",
                'icon'           => 'media/svg/icons/Design/Layers.svg', 
                'page'           => 'dashboard',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                'title' => 'Invoice',
                'icon' => 'media/svg/icons/Communication/Clipboard-list.svg', 
                'page' => 'invoices',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                'title'          => 'Pajak',
                'icon'           => 'media/svg/icons/Communication/Urgent-mail.svg', 
                'page'           => 'pajak',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                'title'          => 'Saldo Bank',
                'icon'           => 'media/svg/icons/Shopping/Wallet.svg', 
                'page'           => 'saldo',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                'title'          => 'Arsip',
                'icon'           => 'media/svg/icons/Files/Group-folders.svg',
                'page'           => null,
                'bullet'         => 'line',
                'arrow'          => 1,
                'root'           => true,
                'is_parent'      => '1'
                
            ],
            [
               
                "parent_id"      => null,
                'title'         => 'PRK',
                'icon'          => 'media/svg/icons/Home/Book-open.svg', // or can be 'flaticon-home' or any flaticon-*
                'page'          => 'prk',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                'title'         => 'Laporan MAR/EMAR',
                'icon'          => 'media/svg/icons/Home/Book-open.svg', // or can be 'flaticon-home' or any flaticon-*
                'page'          => 'reportmaremar',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                'title'         => 'Referensi',
                'icon'          => 'media/svg/icons/Layout/Layout-4-blocks.svg',
                'page'          => null,
                'bullet'        => 'line',
                'arrow'         => true,
                'root'          => true,
                'is_parent'      => '1'
            ],
            [
                "parent_id"      => null,
                'title'          => 'Sistem',
                'icon'          => 'media/svg/icons/General/Settings-1.svg',
                'page'          => null,
                'bullet'        => 'line',
                'arrow'         => true,
                'root'          => true,
                'is_parent'      => '1'
                
            ],
            [
                'parent_id'     => 5,
                'title'         => 'Dokumen Invoice',
                'icon'          => null,
                'page'          => 'arsip-invoice',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 5,
                'title'         => 'Dokumen Pajak',
                'icon'          => null,
                'page'          => 'arsip-pajak',
                'bullet'         => null,
                'arrow'          => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 8,
                'title'         => 'Klasifikasi Invoice',
                'icon'          => null,
                'page'          => 'referensi/klasifikasi-invoice',
                'bullet'        => null,
                'arrow'         => null,
                'root'          => true,
                'is_parent'     => '0',
            ],
            [
                'parent_id'     => 8,
                'title'         => 'Kategori MAR',
                'icon'          => null,
                'page'          => 'referensi/mar-emar',
                'bullet'        => null,
                'arrow'         => null,
                'root'          => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 8,
                'title'         => 'Bank',
                'icon'          => null,
                'page'          => 'referensi/bank',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 9,
                'title'         => 'Users',
                'icon'          => null,
                'page'          => 'system/users',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'     =>'0',
            ],
            [
                'parent_id'     => 9,
                'title'         => 'Roles Access',
                'icon'          => null,
                'page'          => 'system/role',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '0',
            ],
            [
                "parent_id"      => null,
                'title'         => 'Reimburse PO',
                'icon'          => 'media/svg/icons/Communication/Clipboard-list.svg', 
                'page'           => 'reimburse',
                'bullet'         => null,
                'arrow'          => null,
                'root'           => true,
                'is_parent'      => '1'
            ],
           
        );
        DB::table('sys_menus')->insert($menu);
    }
}
