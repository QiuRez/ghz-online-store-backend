<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Str;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = collect($data);

        $data->put("slug", Str::slug($data['title']));
        return $data->toArray();
    }
}
