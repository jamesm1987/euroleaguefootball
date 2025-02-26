<?php

namespace App\Filament\Imports;

use App\Models\Team;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class TeamImporter extends Importer
{
    protected static ?string $model = Team::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('display_name')
                ->rules(['max:255']),
            ImportColumn::make('price')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Team
    {
        return Team::firstOrNew([
            'name' => $this->data['name'],
        ]);

        return new Team();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your team import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
