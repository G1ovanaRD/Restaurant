<?php

namespace App\Imports;

use App\Models\Platillo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class PlatillosImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    // Contadores accesibles desde el controlador
    public int $creados = 0;
    public int $actualizados = 0;

    /**
     * Mapear cada fila a un modelo Platillo (hace upsert por nombre)
     */
    public function model(array $row): ?Platillo
    {
        $nombre = isset($row['nombre']) ? trim($row['nombre']) : null;
        if (!$nombre) return null;

        $data = [
            'descripcion' => $row['descripcion'] ?? null,
            'precio' => isset($row['precio']) ? floatval(str_replace(',', '.', $row['precio'])) : 0,
            'categoria' => $row['categoria'] ?? null,
            'imagen' => $row['imagen'] ?? null,
        ];

        $platillo = Platillo::updateOrCreate(
            ['nombre' => $nombre],
            array_merge(['nombre' => $nombre], $data)
        );

        if ($platillo->wasRecentlyCreated) {
            $this->creados++;
        } else {
            $this->actualizados++;
        }

        return $platillo;
    }

    /**
     * Reglas de validación por fila
     */
    public function rules(): array
    {
        return [
            '*.nombre' => ['required','string','max:255'],
            '*.precio' => ['nullable','numeric'],
            '*.categoria' => ['nullable','string','max:255'],
            '*.imagen' => ['nullable','string','max:1000'],
        ];
    }

    /**
     * Manejo de fallos (se almacenan en SkipsFailures)
     */
    public function onFailure(Failure ...$failures)
    {
        // no-op
    }
}
