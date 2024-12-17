<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder; 
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::query()->create([
            'name' => 'Ahmad',
        ]);
        Teacher::query()->create([
            'name' => 'Mohmmad',
        ]);
        Teacher::query()->create([
            'name' => 'Masa',
        ]);
        Teacher::query()->create([
            'name' => 'Lojeen',
        ]);

        // $teacher_names = ['Ahmad', 'Mohmmad', 'Masa', 'Lojeen'];
        // for($i = 0; $i<4; $i++){
        //     Teacher::query()->create([
        //         'name' => $teacher_names[$i],
        //     ]);
    }
    
}
