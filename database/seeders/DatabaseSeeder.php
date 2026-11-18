<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\Text;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleJournalist = Role::firstOrCreate(['name' => 'journalist']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);

        $catIT = Category::firstOrCreate(['name' => 'Информационные технологии']);
        $catScience = Category::firstOrCreate(['name' => 'Наука и космос']);
        $catMedicine = Category::firstOrCreate(['name' => 'Медицина и здоровье']);
        $catRobotics = Category::firstOrCreate(['name' => 'Робототехника']);

        $admin = User::firstOrCreate(
            ['login' => 'admin'],
            [
                'name' => 'Администратор',
                'email' => 'admin@local.host',
                'password' => Hash::make('qwerty123'),
                'role_id' => $roleAdmin->id,
            ]
        );

        $journalist = User::firstOrCreate(
            ['login' => 'journalist'],
            [
                'name' => 'Журналист',
                'email' => 'journalist@local.host',
                'password' => Hash::make('qwerty123'),
                'role_id' => $roleJournalist->id,
            ]
        );

        $user = User::firstOrCreate(
            ['login' => 'user'],
            [
                'name' => 'Пользователь',
                'email' => 'user@local.host',
                'password' => Hash::make('qwerty123'),
                'role_id' => $roleUser->id,
            ]
        );

        $articles = [
            [
                'heading' => 'Развитие квантовых вычислений в текущем году',
                'categorie_id' => $catIT->id,
                'user_id' => $journalist->id,
                'text' => "Инженеры представили новый квантовый процессор с улучшенной защитой от декогеренции. Новая архитектура позволяет проводить симуляции сложных химических реакций за минимальное время.",
                'is_blocked' => false,
            ],
            [
                'heading' => 'Телескоп обнаружил водяной пар в атмосфере экзопланеты',
                'categorie_id' => $catScience->id,
                'user_id' => $journalist->id,
                'text' => "Астрономы зафиксировали спектральные линии воды в газовой оболочке планеты в созвездии Льва. Планета находится в потенциально обитаемой зоне своей звезды.",
                'is_blocked' => false,
            ],
            [
                'heading' => 'Применение нейросетей в ранней медицинской диагностике',
                'categorie_id' => $catMedicine->id,
                'user_id' => $admin->id,
                'text' => "Алгоритмы глубокого обучения успешно протестированы для анализа медицинских снимков. Точность выявления ранних патологий составила свыше 95%.",
                'is_blocked' => false,
            ],
            [
                'heading' => 'Новые алгоритмы навигации автономных складских роботов',
                'categorie_id' => $catRobotics->id,
                'user_id' => $journalist->id,
                'text' => "Команда исследователей разработала систему координации гуманоидных роботов на базе машинного обучения, что позволило ускорить перемещение грузов.",
                'is_blocked' => false,
            ],
            [
                'heading' => 'Черновик публикации на проверке',
                'categorie_id' => $catIT->id,
                'user_id' => $journalist->id,
                'text' => "Пример публикации, заблокированной модератором. Доступна только в панели администратора для проверки работы статуса блокировки.",
                'is_blocked' => true,
            ],
        ];

        foreach ($articles as $data) {
            Text::firstOrCreate(['heading' => $data['heading']], $data);
        }
    }
}
