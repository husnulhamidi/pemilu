<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class SysActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $act= array(
            [
                "action_name"          => "View",
                "action_function"      => "index",
            ],
            [
                "action_name"          => "Add",
                "action_function"      => "add",
            ],
            [
                "action_name"          => "Update",
                "action_function"      => "update",
            ],
            [
                "action_name"          => "Delete",
                "action_function"      => "delete",
            ],
            [
                "action_name"          => "Add Dokumen",
                "action_function"      => "add_dokumen",
            ],
            [
                "action_name"          => "Update Dokumen",
                "action_function"      => "update_dokumen",
            ],
            [
                "action_name"          => "Delete Dokumen",
                "action_function"      => "delete_dokumen",
            ],
            [
                "action_name"          => "Disposisi Dokumen",
                "action_function"      => "disposisi",
            ],
            [
                "action_name"          => "Approval",
                "action_function"      => "approval",
            ],
            [
                "action_name"          => "Kembalikan Dokumen",
                "action_function"      => "kembalikan_dokumen",
            ],
            [
                "action_name"          => "Konfirmasi Dokumen",
                "action_function"      => "konfirmasi_dokumen",
            ],
            [
                "action_name"          => "Verifikasi Pajak",
                "action_function"      => "verifikasi_pajak",
            ],
            [
                "action_name"          => "Update Verifikasi Pajak",
                "action_function"      => "update_verifikasi_pajak",
            ],
            [
                "action_name"          => "Verifikasi Anggaran",
                "action_function"      => "verifikasi_anggaran",
            ],
            [
                "action_name"          => "Update Verifikasi Anggaran",
                "action_function"      => "update_verifikasi_anggaran",
            ],
            [
                "action_name"          => "Verifikasi Treasury",
                "action_function"      => "verifikasi_treasury",
            ],
            [
                "action_name"          => "Update Verifikasi Treasury",
                "action_function"      => "update_verifikasi_treasury",
            ],
            [
                "action_name"          => "Entri Form Verifikator",
                "action_function"      => "verifikator",
            ],
            [
                "action_name"          => "Print Form Verifikator",
                "action_function"      => "print_form_verifikator",
            ],
            [
                "action_name"          => "View Log Activity",
                "action_function"      => "view_log_activity",
            ],
            [
                "action_name"          => "Cancel Payment",
                "action_function"      => "cancel_payment",
            ],
            [
                "action_name"          => "Pending Payment",
                "action_function"      => "pending_payment",
            ],
           
           
        );
        DB::table('sys_actions')->insert($act);
    }
}
