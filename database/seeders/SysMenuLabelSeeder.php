<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class SysMenuLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuLabel= array(
            [
                'menu_id'   => 2,
                'type'      => 'label-rounded label-primary total_invoice',
                'value'     => '0'
            ],
            [
                'menu_id'   => 3,
                'type'      => 'label-rounded label-primary total_pajak',
                'value'     => '0'
            ],
            [
                'menu_id'   => 3,
                'type'      => 'label-rounded label-primary total_reimburse',
                'value'     => '0'
            ],
            
           
        );
        DB::table('sys_menu_labels')->insert($menuLabel);
    }
}
