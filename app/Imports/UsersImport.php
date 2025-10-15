<?php
// app/Imports/UsersImport.php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $importedBy;
    protected $errors = [];
    protected $successCount = 0;
    protected $createdUsers = []; // NUEVO: Almacenar usuarios creados con sus contraseñas

    public function __construct($importedBy)
    {
        $this->importedBy = $importedBy;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Normalizar los nombres de las columnas (case insensitive)
                $normalizedRow = $this->normalizeRow($row);

                // Validar fila individual
                $validator = Validator::make($normalizedRow->toArray(), [
                    'nombre' => 'required|string|max:255',
                    'apellido' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'dni' => 'required|digits:8|unique:users,dni',
                    'telefono' => 'required|digits:9|unique:users,phone',
                ]);

                if ($validator->fails()) {
                    $this->errors[] = [
                        'row' => $index + 2,
                        'errors' => $validator->errors()->all(),
                        'data' => $normalizedRow
                    ];
                    continue;
                }

                // Generar contraseña temporal
                $tempPassword = Str::random(10);

                // Crear usuario
                $user = User::create([
                    'name' => $normalizedRow['nombre'],
                    'last_name' => $normalizedRow['apellido'],
                    'email' => $normalizedRow['email'],
                    'dni' => $normalizedRow['dni'],
                    'phone' => $normalizedRow['telefono'],
                    'password' => Hash::make($tempPassword),
                    'is_temp_password' => true,
                    'temp_password_expires_at' => now()->addDays(7),
                    'created_by' => $this->importedBy,
                    'role' => 'user',
                ]);

                $this->successCount++;

                // NUEVO: Guardar usuario creado con su contraseña temporal
                $this->createdUsers[] = [
                    'name' => $user->name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'temp_password' => $tempPassword,
                    'dni' => $user->dni
                ];

                // TODO: Enviar email con credenciales
                // Mail::to($normalizedRow['email'])->send(new TempPasswordEmail($tempPassword));

            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'errors' => [$e->getMessage()],
                    'data' => $normalizedRow ?? []
                ];
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.nombre' => 'required',
            '*.apellido' => 'required',
            '*.email' => 'required',
            '*.dni' => 'required',
            '*.telefono' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nombre.required' => 'El campo nombre es requerido',
            'apellido.required' => 'El campo apellido es requerido',
            'email.required' => 'El campo email es requerido',
            'dni.required' => 'El campo DNI es requerido',
            'telefono.required' => 'El campo teléfono es requerido',
        ];
    }

    /**
     * Normalizar los nombres de las columnas para hacerlos case insensitive
     */
    private function normalizeRow(Collection $row): Collection
    {
        $normalized = collect();

        foreach ($row as $key => $value) {
            $lowerKey = strtolower(trim($key));

            switch ($lowerKey) {
                case 'nombre':
                case 'name':
                case 'nombres':
                    $normalized['nombre'] = $value;
                    break;
                case 'apellido':
                case 'apellidos':
                case 'last_name':
                case 'lastname':
                    $normalized['apellido'] = $value;
                    break;
                case 'email':
                case 'correo':
                case 'mail':
                    $normalized['email'] = $value;
                    break;
                case 'dni':
                case 'documento':
                case 'document':
                    $normalized['dni'] = $value;
                    break;
                case 'telefono':
                case 'teléfono':
                case 'phone':
                case 'celular':
                    $normalized['telefono'] = $value;
                    break;
            }
        }

        return $normalized;
    }

    /**
     * Obtener estadísticas de la importación
     */
    public function getResults(): array
    {
        return [
            'success_count' => $this->successCount,
            'error_count' => count($this->errors),
            'errors' => $this->errors,
            'created_users' => $this->createdUsers, // NUEVO: Incluir usuarios creados
        ];
    }
    
}
