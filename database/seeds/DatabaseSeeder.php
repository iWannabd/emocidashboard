<?php

use Illuminate\Database\Seeder;
use App\Oranghilang;
use App\User;
use App\Lantas;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Bapak Polisi',
            'username' => 'pakpolisi',
            'password' => \Illuminate\Support\Facades\Hash::make("omteloletom"),
        ]);
        Lantas::create([
            'konten'=>'terjadi kemacetan',
            'img'=>'img/asd.jpg'
        ]);

    }
}
