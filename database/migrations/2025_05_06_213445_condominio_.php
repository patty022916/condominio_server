<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->json('permisos');
            $table->timestamps();
        });

        // Tabla usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique()->comment('Medio de comunicación');
            $table->string('password');
            $table->string('telefono', 150)->comment('Medio de comunicación');
            $table->foreignId('id_rol')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();
        });

        // Tabla proveedores (corregido)
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('servicio');
            $table->string('telefono');
            $table->timestamps();
        });

        // Tabla cuotas
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable();
            $table->double('monto');
            $table->integer('periodo');
            $table->date('fecha');
            $table->timestamps();
        });

        // Tabla apartamentos
        Schema::create('apartamentos', function (Blueprint $table) {
            $table->id();
            $table->string('piso');
            $table->string('letra');
            $table->integer('habitaciones');
            $table->foreignId('propietario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('inquilino_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->timestamps();

            // Si deseas que un inquilino esté en un solo apartamento
            $table->unique('inquilino_id');
        });

        // Tabla gastos
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->decimal('monto', 10, 2);
            $table->enum('tipo_gasto', ['fijo', 'comun', 'extraordinario']);// cambiado el ultimo tipo
            $table->date('fecha');
            $table->boolean('recurrente');
            $table->foreignId('id_proveedor')->nullable()->constrained('proveedores')->nullOnDelete();
            $table->foreignId('user_id')->constrained('usuarios')->cascadeOnDelete(); // Añadido
            $table->timestamps();
        });

        // Tabla notificaciones
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('mensaje')->nullable();
            $table->enum('tipo', ['cobro','reunion','alerta','general']);
            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();
            $table->timestamp('leida_at')->nullable();
            $table->timestamps();
        });
        
        // Tabla deudas_apartamentos
        Schema::create('deudas_apartamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('id_apartamento')->constrained('apartamentos')->cascadeOnDelete();
            $table->decimal('monto_deuda', 10, 2);
            $table->date('fecha_pago');
            $table->timestamps();
        });

        // Tabla pagos
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_apartamento')->constrained('apartamentos')->cascadeOnDelete();
            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();
            $table->decimal('monto', 10, 2);
            $table->date('fecha_pago');
            $table->string('url')->nullable();
            $table->enum('estatus', ['pendiente', 'pagado'])->default('pendiente');
            $table->enum('forma_pago', ['parcial', 'completo']);
            $table->foreignId('id_cuota')->nullable()->constrained('cuotas')->nullOnDelete();
            $table->timestamps();
        });

        // Tabla fondos_condominio
        Schema::create('fondos_condominio', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_movimiento', ['ingreso', 'egreso']);
            $table->decimal('monto', 10, 2);
            $table->string('descripcion');
            $table->date('fecha');
            $table->foreignId('id_gasto')->nullable()->constrained('gastos')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Eliminar las tablas en orden inverso para evitar problemas de claves foráneas
        Schema::dropIfExists('fondos_condominio');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('deudas_apartamentos');
        Schema::dropIfExists('notificaciones');
        Schema::dropIfExists('gastos');
        Schema::dropIfExists('apartamentos');
        Schema::dropIfExists('cuotas');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
};
