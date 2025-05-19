<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Gasto extends Model
{
    // Nombre de la tabla 
    protected $table = 'gastos';

    // Campos asignables masivamente 
    protected $fillable = [
        'descripcion',
        'monto',
        'tipo_gasto',
        'fecha',
        'id_proveedor',
        'recurrente',
        'user_id'
    ];

    // Registra un nuevo gasto con validación y lógica de negocio.
    
    public static function registrarGasto(Request $request)
    {
        try {
            // 1. Validación de campos 
            $requiredFields = [
                'descripcion' => 'string|max:255',
                'monto' => 'numeric|min:0.01',
                'tipo_gasto' => 'in:fijo,comun,extraordinario',
                'id_proveedor' => 'integer',
                'user_id' => 'integer'
            ];
            
            foreach ($requiredFields as $field => $rules) {
                if (empty($request->$field)) {
                    throw new Exception("El campo $field es requerido", 400);
                }
                
                if ($field === 'tipo_gasto' && !in_array($request->$field, ['fijo', 'comun', 'extraordinario'])) {
                    throw new Exception("Tipo de gasto no válido", 400);
                }
                
                if ($field === 'monto' && $request->$field <= 0) {
                    throw new Exception("El monto debe ser mayor a 0", 400);
                }
            }

            // 2. Verificar existencia del proveedor
            $proveedor = DB::table('proveedores')
                         ->where('id', $request->id_proveedor)
                         ->first();
            
            if (!$proveedor) {
                throw new Exception("El proveedor no existe", 404);
            }

            // 3. Preparar datos
            $gastoData = [
                'descripcion' => trim($request->descripcion),
                'monto' => round((float)$request->monto, 2),
                'tipo_gasto' => $request->tipo_gasto,
                'fecha' => $request->fecha ?? date('Y-m-d'),
                'id_proveedor' => (int)$request->id_proveedor,
                'recurrente' => !empty($request->recurrente),
                'user_id' => (int)$request->user_id,
                'created_at' => now(),
                'updated_at' => now()
            ];

            // 4. Insertar en BD usando el modelo 
            $gastoId = self::insertGetId($gastoData);
            $gastoInsertado = self::find($gastoId);

            // 5. Respuesta estructurada
            return [
                'success' => true,
                'data' => $gastoInsertado,
                'proveedor' => $proveedor->nombre,
                'message' => 'Gasto registrado correctamente'
            ];

        } catch (Exception $e) {
            // 6. Manejo de errores
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    /* Relación con proveedor (opcional, si usas Eloquent ORM)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    // Relación con usuario (opcional)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    } */
}