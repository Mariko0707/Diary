<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//[];は　array();の省略形
        $diaries = [
        	[
        		'title' => 'セブでプログラミング',
        		'body' => '気づけばもうあと1ヶ月',
        	],
        	[
        		'title' => 'やり残したことは...',
        		'body' => 'ヨガのレッスン！',
        	],
        	[
        		'title' => 'いや、チーム開発でしょ！',
        		'body' => '絶対リリース！！',
        	],
        ];
        foreach($diaries as $diary){
        	DB::table('diaries')->insert([
        		'title' => $diary['title'],
        		'body' => $diary['body'],
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now(),
        	]);
        }
    }
}
