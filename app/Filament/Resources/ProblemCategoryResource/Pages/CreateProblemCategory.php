<?php

namespace App\Filament\Resources\ProblemCategoryResource\Pages;

use App\Filament\Resources\ProblemCategoryResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ProblemCategory; 

class CreateProblemCategory extends CreateRecord
{
    protected static string $resource = ProblemCategoryResource::class;
    
    public function save()
    {
        $data = $this->getFormData();

        // Memeriksa apakah kategori sudah ada dalam database
        if (ProblemCategory::where('name', $data['name'])->exists()) {
            // Jika sudah ada, beri tanggapan kepada pengguna
            $this->addError('name', 'Kategori sudah ada dalam database.');
            return;
        }
        // Jika belum ada, lanjutkan proses penyimpanan
        parent::save();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}