<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all permissions with null action
        $permissions = \App\Models\Permission::whereNull('action')->get();

        foreach ($permissions as $permission) {
            // Extract action from permission name (format: action_module)
            $parts = explode('_', $permission->name);
            if (count($parts) >= 2) {
                $action = $parts[0]; // First part is the action
                $permission->update(['action' => $action]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set all action fields back to null
        \App\Models\Permission::whereNotNull('action')->update(['action' => null]);
    }
};
