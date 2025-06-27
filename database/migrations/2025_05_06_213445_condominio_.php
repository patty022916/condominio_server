<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Tabla destinada a guardar los roles de los usuarios
         * *Tabla Activa
         */
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->json('permisos');
            $table->timestamps();
        });

        /**
         * Tabla destinada a guardar los usuarios
         * *Tabla Activa
         */
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

        /**
         * Tabla destinada a guardar los proveedores
         * *Tabla Activa
         */
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('servicio');
            $table->string('telefono');
            $table->timestamps();
        });

        /**
         * Tabla destinada a guardar las cuotas de los apartamentos
         * generadas según los gastos creados por administración 
         * depende de la tabla 'gastos'
         * *Tabla Activa
         */
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion')->nullable();
            //MONTO usd
            $table->double('monto');
            $table->integer('periodo');
            $table->date('fecha');
            $table->timestamps();
        });

        /**
         * Tabla destinada a guardar los apartamentos
         * *Tabla Activa
         */
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

        /**
         * Tabla destinada a guardar los gastos del edificio
         * para crear las cuotas a pagar
         * *Tabla Activa
         */
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->decimal('monto', 10, 2);
            $table->enum('tipo_gasto', ['fijo', 'comun', 'extraordinario']); // cambiado el ultimo tipo
            $table->datetime('fecha');
            $table->boolean('recurrente');
            $table->foreignId('id_proveedor')->nullable()->constrained('proveedores')->nullOnDelete();
            $table->timestamps();
        });

        /**
         * Tabla desninada a guardar las notificaciones de los usuarios, administradores etc
         * *Tabla Activa
         */
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('mensaje')->nullable();
            $table->enum('tipo', ['cobro', 'reunion', 'alerta', 'general']);
            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();
            $table->timestamp('leida_at')->nullable();
            $table->timestamps();
        });

        /**
         * Tabla destinada a guardar las deudas de los apartamentos
         * !Tabla inactiva
         */
        Schema::create('deudas_apartamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('id_apartamento')->constrained('apartamentos')->cascadeOnDelete();
            $table->decimal('monto_deuda', 10, 2);
            $table->date('fecha_pago');
            $table->timestamps();
        });

        /**
         * Tabla pagos, dedicada a los usuarios
         * Se guardara los pagos de los usuarios haciendo referencie a la tabla 'historial_pago'
         * *Tabla Activa
         */
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_apartamento')->constrained('apartamentos')->cascadeOnDelete();
            $table->foreignId('id_usuario')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('id_cuota')->constrained('cuotas')->restrictOnDelete();
            $table->enum('status', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');
            $table->enum('forma_pago', ['parcial', 'completo']);
            //MONTO BOLIVARES
            $table->decimal('monto', 10, 2);
            $table->string('referencia');
            $table->string('url');
            $table->timestamps();
        });

        /**
         * Tabla destinada a guardar los fondos del condominio   
         * tanto en dolares y bs, se guardaran los movimientos de los fondos
         * realizado por administración como : compra de dolares, antena, internet
         * !tabla inactiva
         */
        Schema::create('fondos_condominio', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_movimiento', ['ingreso', 'egreso']);
            $table->decimal('monto', 10, 2);
            $table->decimal('fondo_activo_bs', 14, 2)->default(0); // Bolívares
            $table->decimal('fondo_pasivo_usd', 10, 2)->default(0); // Dólares
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
        Schema::dropIfExists('historial_pago');
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
