<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return User::query()
            ->with([
                'posts' => function ($query) {
                    $query->withCount('likes');
                }
            ]);
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->posts->count(),
            $user->posts->sum('likes_count'),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Post count',
            'Total Likes count',
        ];
    }
}
